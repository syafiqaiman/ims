<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Picker;
use App\Models\Product;
use App\Models\Quantity;
use App\Models\Weight;
use App\Models\Order;
use App\Models\Rack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PickerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function PickerTaskList()
    {
        $user = Auth::user();
        $pickers = Picker::where('user_id', $user->id)
                          ->whereIn('status', ['Collected', 'Pending', 'Reracking', 'Disposing'])
                          ->orderBy('created_at', 'desc')
                          ->get();
    
        $allCollected = true; // Set to true by default
        $hasPending = false;
    
        foreach ($pickers as $picker) {
            $product = Product::find($picker->product_id);
            $picker->product_name = $product->name;
            $picker->company_id = $product->company_id;
            $rack_location = Rack::where('id', $product->rack_id)->first();
            $picker->location_code = $rack_location->location_code; // Get the location_code from the rack_location
    
            // Access the order_no from the pickers table
            $picker->order_no = $picker->order_no;
    
            if ($picker->status !== 'Collected' && $picker->status !== 'Packing') {
                $allCollected = false; // Set to false if any picker is not collected
                if ($picker->status === 'Pending') {
                    $hasPending = true; // Set to true if any picker is in 'Pending' status
                }
            }
        }
    
        return view('backend.picker.picker_task', [
            'pickers' => $pickers,
            'allCollected' => $allCollected,
            'hasPending' => $hasPending, // Pass the variable to the view
        ]);
    }
    
    
    
    


    public function confirmCollection(Request $request, $id, $quantity)
    {
        // Get the picker
        $picker = Picker::find($id);
    
            // Update the status, report, and remark
        $picker->status = ($request->report === 'Insufficient' || $request->report === 'Damaged') ? 'Reassign' : 'Collected';
        $picker->report = $request->report;
        $picker->remark = $request->remark;
        $picker->save();

    
        // Check if the report is "Completed"
        if ($request->report === 'Completed') {
            // Find the associated product
            $product = Product::find($picker->product_id);
    
            // Create a new order
            $order = new Order();
            $order->product()->associate($product);
            $order->user_id = Auth::user()->id;
            $order->quantity = $picker->quantity;
            $order->rack_id = $picker->rack_id;
            $order->order_no = $picker->order_no;
            $order->company_id = $product->company_id;
            $order->save();
        }
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Report updated successfully.');
    }
    
    



public function history()
{
    $user = Auth::user();
    $pickers = Picker::where('user_id', $user->id)
                      ->where('status', 'Collected')
                      ->update(['status' => 'Packing']);

    $orders = Order::with('product')
                   ->join('products', 'orders.product_id', '=', 'products.id')
                   ->where('orders.user_id', $user->id) // Retrieve orders of the logged-in picker only
                   ->orderBy('created_at', 'desc')
                   ->select('orders.id', 'orders.user_id', 'orders.product_id', 'orders.quantity', 'orders.created_at', 'orders.updated_at', 'products.product_name')
                   ->get()
                   ->groupBy(function($order) {
                        // Group orders by date
                        return $order->created_at->format('Y-m-d');
                   });
                   
    $dates = $orders->keys(); // Get the dates for the tabs
    
    return view('backend.picker.picker_history', [
        'orders' => $orders,
        'dates' => $dates,
    ]);
}

public function AdminView()
{
    $user = Auth::user();
    
    $pickers = DB::table('pickers')
    ->join('users', 'pickers.user_id', '=', 'users.id')
    ->join('products', 'pickers.product_id', '=', 'products.id')
    ->select('pickers.id', 'pickers.user_id',  'users.name as picker_name', 'products.product_name', 'pickers.quantity', 'pickers.status', 'pickers.report', 'pickers.remark', 'pickers.created_at', 'pickers.updated_at')
    ->groupBy('pickers.id', 'pickers.user_id', 'picker_name', 'products.product_name', 'pickers.quantity', 'pickers.status','pickers.report', 'pickers.remark', 'pickers.created_at', 'pickers.updated_at')
    ->get();



    return view('backend.picker.picker_status_view', [
        'pickers' => $pickers,
    ]);
}

public function rerackProductPicker($pickerId)
{
    // Find the associated picker
    $picker = Picker::where('id', $pickerId)
                     ->where('user_id', Auth::user()->id)
                     ->first();

    if ($picker) {

        // Set the picker status to "Reracked"
        $picker->status = 'Reracked';
        $picker->report = 'Rerack';
        $picker->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Product has been reracked');
    }
    
    // Redirect back with error message if picker not found or not associated with the logged-in user
    return redirect()->back()->with('error', 'Picker not found.');
}


public function rerackProductAdmin($pickerId)
{
    // Find the associated picker
    $picker = Picker::find($pickerId);

    if ($picker) {
        // Find the associated product
        $product = Product::find($picker->product_id);

        // Update the quantity in the quantities table
        $quantity = Quantity::where('product_id', $product->id)->first();
        $quantity->remaining_quantity += $picker->quantity;
        $quantity->sold_item_quantity -= $picker->quantity;
        $quantity->save();

        // Update the weight in the weights table
        $weight = Weight::where('product_id', $product->id)->first();
        $weight->weight_of_product += $product->weight_per_item * $picker->quantity;
        $weight->save();

         // Update the occupied_weight in the rack_locations table
        $rackLocation = Rack::where('id', $product->rack_id)->first();
        $rackLocation->occupied += $product->weight_per_item * $picker->quantity;
        $rackLocation->save();
         
        // Set the picker status to "Reracked"
        $picker->status = 'Reracking';
        $picker->report = 'Rerack';
        $picker->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Picker will be notified.');
    }
    
    // Redirect back with error message if picker not found
    return redirect()->back()->with('error', 'Picker not found.');
}

public function disposeProductAdmin($pickerId)
{
    // Find the associated picker
    $picker = Picker::find($pickerId);

    if ($picker) {
        // Find the associated product
        $product = Product::find($picker->product_id);
         
        // Set the picker status to "Reracked"
        $picker->status = 'Disposing';
        $picker->report = 'Dispose';
        $picker->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Picker will be notified.');
    }
    
    // Redirect back with error message if picker not found
    return redirect()->back()->with('error', 'Picker not found.');
}

public function disposeProductPicker($pickerId)
{
    // Find the associated picker
    $picker = Picker::where('id', $pickerId)
                     ->where('user_id', Auth::user()->id)
                     ->first();

    if ($picker) {

        // Set the picker status to "Reracked"
        $picker->status = 'Disposed';
        $picker->report = 'Dispose';
        $picker->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Product has been disposed');
    }
    
    // Redirect back with error message if picker not found or not associated with the logged-in user
    return redirect()->back()->with('error', 'Picker not found.');
}

public function returnOrderTask()
{
    $pickers = Picker::with(['product' => function ($query) {
        $query->select('id', 'rack_id');
    }])
    ->with(['product.rack' => function ($query) {
        $query->select('id', 'location_code');
    }])
    ->whereIn('status', ['Dispose', 'Refurbish'])
    ->whereNotNull('return_stock_id')
    ->join('return_stock', 'pickers.return_stock_id', '=', 'return_stock.id')
    ->select('pickers.*', 'return_stock.return_no AS return_no')
    ->get();

    return view('backend.picker.return_stock_task', compact('pickers'));
}




public function refurbishedProduct($pickerId)
{
    $picker = Picker::findOrFail($pickerId);

    if ($picker) {
        $product = $picker->product;
        $rackLocation = $product->rack->location;

        // Update the quantity in the quantities table
        $quantity = Quantity::where('product_id', $product->id)->first();
        $quantity->remaining_quantity += $picker->quantity;
        $quantity->sold_item_quantity -= $picker->quantity;
        $quantity->save();

        // Update the weight in the weights table
        $weight = Weight::where('product_id', $product->id)->first();
        $weight->weight_of_product += $product->weight_per_item * $picker->quantity;
        $weight->save();

        // Update the occupied_weight in the rack_locations table
        $rack = Rack::where('id', $product->rack_id)->first();
        $rack->occupied += $product->weight_per_item * $picker->quantity;
        $rack->save();

        // Set the picker status to "Reracked"
        $picker->status = 'Refurbished';
        $picker->report = 'Product is in rack';
        $picker->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Product successfully reracked.');
    }

    // Redirect back with error message if picker not found
    return redirect()->back()->with('error', 'Picker not found.');
}


}
