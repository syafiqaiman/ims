<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Picker;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\Quantity;
use App\Models\Weight;
use App\Models\Order;
use App\Models\Rack;
use App\Models\Floor;
use App\Models\Floor;
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
            $floor_location = Floor::where('id', $product->floor_id)->first();

            $picker->location_code = $rack_location->location_code ?? null; // Get the location_code from the rack_location
            $picker->location_codes = $floor_location->location_codes ?? null; // Get the location_codes from the floor_location
        
            // Access the order_no from the delivery associated with the picker
            $delivery = Delivery::find($picker->order_no);
    
            if ($delivery) {
                $picker->order_no = $delivery->order_no;
            } else {
                // Handle case when corresponding delivery record is not found
                $picker->order_no = 'Not Found'; // Set a placeholder value
            }
    
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
            $order->rack_id = $picker->rack_id ?? null;
            $order->floor_id = $picker->floor_id ?? null;
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
        
        // Update status of pickers
        $pickers = Picker::where('user_id', $user->id)
                          ->where('status', 'Collected')
                          ->update(['status' => 'Packing']);
    
        // Retrieve orders and associated delivery order numbers
        $orders = Order::with('product', 'delivery') // Load the 'delivery' relationship
                       ->join('products', 'orders.product_id', '=', 'products.id')
                       ->join('delivery', 'orders.order_no', '=', 'delivery.id')
                       ->where('orders.user_id', $user->id)
                       ->orderBy('created_at', 'desc')
                       ->select('orders.id', 'orders.user_id', 'orders.product_id', 'orders.quantity', 'orders.order_no','delivery.order_no', 'orders.created_at', 'orders.updated_at', 'products.product_name')
                       ->get()
                       ->groupBy(function($order) {
                            return $order->created_at->format('d-m-Y');
                       });
                       
        // Retrieve delivery order numbers for each picker entry
        $pickerOrders = Picker::where('user_id', $user->id)
                               ->pluck('order_no')
                               ->toArray();
    
        $dates = $orders->keys();
    
        return view('backend.picker.picker_history', [
            'orders' => $orders,
            'dates' => $dates,
            'pickerOrders' => $pickerOrders,
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




}
