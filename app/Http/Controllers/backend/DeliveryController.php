<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Delivery;
use App\Models\Picker;
use App\Models\User;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function deliveryFormCust()
    {
        // Retrieve products owned by the user
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->get();

        return view('backend.delivery.delivery_form', ['products' => $products]);
    }

    private function generateDONumber()
    {
        // Get the current timestamp
        $timestamp = time();

        // Generate a unique identifier based on the timestamp
        $identifier = substr($timestamp, -6); // Example: Use the last 6 digits of the timestamp

        // Construct the DO number with a prefix and the identifier
        $do_number = 'DO-' . $identifier;

        // Return the DO number
        return $do_number;
    }

    public function storeDelivery(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'sender_name' => 'required',
            'sender_address' => 'required',
            'sender_postcode' => 'required',
            'sender_state' => 'required',
            'sender_phone' => 'required',
            'receiver_name' => 'required',
            'receiver_address' => 'required',
            'receiver_postcode' => 'required',
            'receiver_state' => 'required',
            'receiver_phone' => 'required',
            'product_id.*' => 'required',
            'quantity.*' => 'required|numeric|min:1',
        ]);
    
        // Generate a unique PO number for the order_no column
        $orderNo = $this->generateDONumber();
    
        // Create a new delivery record
        $delivery = new Delivery;
        $delivery->order_no = $orderNo;
        $delivery->sender_name = $validatedData['sender_name'];
        $delivery->sender_address = $validatedData['sender_address'];
        $delivery->sender_postcode = $validatedData['sender_postcode'];
        $delivery->sender_state = $validatedData['sender_state'];
        $delivery->sender_phone = $validatedData['sender_phone'];
        $delivery->receiver_name = $validatedData['receiver_name'];
        $delivery->receiver_address = $validatedData['receiver_address'];
        $delivery->receiver_postcode = $validatedData['receiver_postcode'];
        $delivery->receiver_state = $validatedData['receiver_state'];
        $delivery->receiver_phone = $validatedData['receiver_phone'];
        $delivery->save();
    
        // Handle the product data
        $productIds = $request->input('product_id', []);
        $quantities = $request->input('quantity', []);
    
        // Insert the product data into the pivot table (assuming a many-to-many relationship)
        foreach ($productIds as $index => $productId) {
            $delivery->products()->attach($productId, ['quantity' => $quantities[$index]]);
        }
    
        // Redirect or respond with a success message
        return redirect()->back()->with('success', 'Delivery information has been successfully saved.');
    }
    

    public function deliveryOrderList()
    {
        $pickers = Picker::all();
        $deliveryOrdersList = Delivery::with(['products', 'pickers'])->get();
        $users = User::all();

        return view('backend.delivery.delivery_order_list', compact('deliveryOrdersList', 'users', 'pickers'));
    }


}