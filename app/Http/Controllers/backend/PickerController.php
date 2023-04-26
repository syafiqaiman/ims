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
        $pickers = Picker::where('user_id', $user->id)->get();
    
        foreach ($pickers as $picker) {
            $product = Product::find($picker->product_id);
            $picker->product_name = $product->name;
        }
    
        return view('backend.picker.picker_task', ['pickers' => $pickers]);
    }

    public function confirmCollection(Request $request, $id, $quantity)
{
    // Get the picker
    $picker = Picker::find($id);

    // Update the status to "Collected"
    $picker->status = "Collected";
    $picker->save();

    // Create a new order
    $order = new Order();
    $order->product_id = $picker->product_id;
    $order->user_id = Auth::user()->id;
    $order->quantity = $picker->quantity;
    $order->save();

    // Redirect back with success message
    return redirect()->back()->with('success', 'Product collected and order created successfully.');
}

}
