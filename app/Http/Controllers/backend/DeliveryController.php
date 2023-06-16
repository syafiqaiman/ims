<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Delivery;

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

    private function generatePONumber()
    {
        // Get the current timestamp
        $timestamp = time();

        // Generate a unique identifier based on the timestamp
        $identifier = substr($timestamp, -6); // Example: Use the last 6 digits of the timestamp

        // Construct the PO number with a prefix and the identifier
        $po_number = 'PO-' . $identifier;

        // Return the PO number
        return $po_number;
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
            'product_name.*' => 'required',
            'quantity.*' => 'required|numeric|min:1',
        ]);

        // Generate a unique PO number for the order_no column
        $orderNo = $this->generatePONumber();

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
        $products = $request->input('product_name', []);
        $quantities = $request->input('quantity', []);

        // Insert the product data into the pivot table (assuming a many-to-many relationship)
        foreach ($products as $index => $product) {
            // Find the product by name and get the corresponding product_id
            $product = Product::where('product_name', $product)->first();
            if ($product) {
                $product_id = $product->id;
                $delivery->products()->attach($product_id, ['quantity' => $quantities[$index]]);
            }
        }

        // Redirect or respond with a success message
        return redirect()->back()->with('success', 'Delivery information has been successfully saved.');
    }
}
