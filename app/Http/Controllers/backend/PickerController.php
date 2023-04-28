<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Picker;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PickerController extends Controller
{
    public function PickerTaskList()
{
    $user = Auth::user();
    $pickers = Picker::where('user_id', $user->id)
                      ->orderBy('created_at', 'desc')
                      ->get();

    $allCollected = true; // Set to true by default
    foreach ($pickers as $picker) {
        $product = Product::find($picker->product_id);
        $picker->product_name = $product->name;
        if ($picker->status !== 'Collected') {
            $allCollected = false; // Set to false if any picker is not collected
        }
    }

    return view('backend.picker.picker_task', [
        'pickers' => $pickers,
        'allCollected' => $allCollected, // Pass the variable to the view
    ]);
}



public function confirmCollection(Request $request, $id, $quantity)
{
    // Get the picker
    $picker = Picker::find($id);

    // Update the status to "Collected"
    $picker->status = "Collected";
    $picker->save();

    // Find the associated product
    $product = Product::find($picker->product_id);

    // Create a new order
    $order = new Order();
    $order->product()->associate($product);
    $order->user_id = Auth::user()->id;
    $order->quantity = $picker->quantity;
    $order->save();

    // Redirect back with success message
    return redirect()->back()->with('success', 'Product collected and order created successfully.');
}


public function history()
{
    $user = Auth::user();
    
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




}
