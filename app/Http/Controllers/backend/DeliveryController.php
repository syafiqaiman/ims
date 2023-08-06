<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Delivery;
use App\Models\Weight;
use App\Models\Rack;
use App\Models\Floor;
use App\Models\Quantity;
use App\Models\Picker;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

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
        $delivery->user_id = auth()->user()->id;
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
        $delivery->status = 'Pending';
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
        $deliveryOrdersList = Delivery::with(['products'])->get();
        $users = User::all();

        return view('backend.delivery.delivery_order_receive', compact('deliveryOrdersList', 'users', 'pickers'));
    }

    public function assignTaskDO(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'delivery_id' => 'required',
            'product_id' => 'required|array',
            'quantity' => 'required|array',
        ]);

        $userId = $validatedData['user_id'];
        $deliveryId = $validatedData['delivery_id'];
        $productIds = $validatedData['product_id'];
        $quantities = $validatedData['quantity'];

        $cart = []; // Initialize an array to hold cart items for further processing

        foreach ($productIds as $index => $productId) {
            $cart[$productId] = [
                'quantity' => $quantities[$index],
            ];
        }

        foreach ($cart as $id => $item) {
            $quantity_to_deduct = $item['quantity'];

            $quantity = Quantity::where('product_id', $id)->firstOrFail();
            $product = Product::findOrFail($quantity->product_id);
            $num_cartons = floor($quantity_to_deduct / $product->item_per_carton);
            $num_items = $quantity_to_deduct % $product->item_per_carton;
            $quantity_deducted = $num_cartons * $product->item_per_carton + $num_items;

            if ($quantity->remaining_quantity < $quantity_deducted) {
                return redirect()->back()->with('error', 'Not enough stock!');
            }

            $quantity->remaining_quantity -= $quantity_deducted;
            $quantity->sold_carton_quantity += $num_cartons;
            $quantity->sold_item_quantity += $num_items; // Remove the calculation here
            $quantity->save();

            $total_weight = $product->weight_per_item * $quantity_deducted;
            $rack = Rack::where('id', $product->rack_id)->firstOrFail();
            $rack->occupied = max(0, $rack->occupied - $total_weight);
            $rack->save();
            $floors = Floor::where('id', $product->floor_id)->firstOrFail();
            $floors->occupied = max(0, $floors->occupied - $total_weight);
            $floors->save();

            $weight = Weight::where('product_id', $product->id)->firstOrFail();
            $weight->weight_of_product -= $total_weight;
            $weight->save();

            $picker = new Picker();
            $picker->user_id = $userId;
            $picker->product_id = $id;
            $picker->rack_id = $rack->id; // Adjust this based on your structure
            $picker->floor_id = $floors->id; // Adjust this based on your structure
            $picker->quantity = $item['quantity'];
            $picker->status = 'Pending';
            $picker->order_no = $deliveryId;
            $picker->save();
        }


         // Update the status of the delivery to Received
         $delivery = Delivery::findOrFail($deliveryId);
         $delivery->status = 'Received';
         $delivery->save();

        return redirect()->back()->with('success', 'Order placed and products assigned successfully!');
    }

    // public function assignTaskDO(Request $request)
    // {
    //     //return response()->json($request, 200);

    //     $validatedData = $request->validate([
    //         'user_id' => 'required',
    //         'delivery_id' => 'required',
    //         'product_id' => 'required|array',
    //         'quantity' => 'required|array',
    //     ]);

    //     $userId = $validatedData['user_id'];
    //     $deliveryId = $validatedData['delivery_id'];
    //     $productIds = $validatedData['product_id'];
    //     $quantities = $validatedData['quantity'];

    //     $cart = []; // Initialize an array to hold cart items for further processing

    //     foreach ($productIds as $index => $productId) {
    //         $cart[$productId] = [
    //             'quantity' => $quantities[$index],
    //         ];
    //     }

    //     foreach ($cart as $id => $item) {
    //         $quantity_to_deduct = $item['quantity'];

    //         $quantity = Quantity::where('product_id', $id)->firstOrFail();
    //         $product = Product::findOrFail($quantity->product_id);
    //         $num_cartons = floor($quantity_to_deduct / $product->item_per_carton);
    //         $num_items = $quantity_to_deduct % $product->item_per_carton;
    //         $quantity_deducted = $num_cartons * $product->item_per_carton + $num_items;

    //         if ($quantity->remaining_quantity < $quantity_deducted) {
    //             return redirect()->back()->with('error', 'Not enough stock!');
    //         }

    //         $quantity->remaining_quantity -= $quantity_deducted;
    //         $quantity->sold_carton_quantity += $num_cartons;
    //         $quantity->sold_item_quantity += $num_items; // Remove the calculation here
    //         $quantity->save();

    //         $total_weight = $product->weight_per_item * $quantity_deducted;

    //         $rack = Rack::where('id', $product->rack_id)->firstOrFail();

    //         $floor = Floor::where('id', $product->floor_id)->firstOrFail();

    //         if ($rack != null) {
    //             $rack->occupied = max(0, $rack->occupied - $total_weight);
    //             $rack->save();

    //         } else if ($floor != null) {

    //         } else {
    //             return redirect()->back()->with('error', 'Product rack/floor location is invalid.');
    //         }

    //         $weight = Weight::where('product_id', $product->id)->firstOrFail();
    //         $weight->weight_of_product -= $total_weight;
    //         $weight->save();

    //         $picker = new Picker();
    //         $picker->user_id = $userId;
    //         $picker->product_id = $id;
    //         $picker->rack_id = $rack->id ?? null; // Adjust this based on your structure
    //         $picker->floor_id = $floor->id ?? null; // Adjust this based on your structure
    //         // $picker->rack_id = $product->rack_id ?? null; // Adjust this based on your structure
    //         // $picker->floor_id = $product->floor_id ?? null; // Adjust this based on your structure
    //         // $picker->rack_id = $rack ?? $floor->firstWhere('product_id', $id)->rack_id;
    //         // $picker->floor_id = $floor ?? $rack->firstWhere('product_id', $id)->floor_id;
    //         $picker->quantity = $item['quantity'];
    //         $picker->status = 'Pending';
    //         $picker->order_no = $deliveryId;
    //         $picker->save();
    //     }

    //     //Update the status of the delivery to Received
    //     $delivery = Delivery::findOrFail($deliveryId);
    //     $delivery->status = 'Received';
    //     $delivery->save();

    //     // Perform any other necessary actions

    //     return redirect()->back()->with('success', 'Order placed and products assigned successfully!');
    // }


}