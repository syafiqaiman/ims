<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Company;
use App\Models\Product;
use App\Models\Picker;
use App\Models\Rack;
use App\Models\Weight;
use App\Models\Order;
use App\Models\Quantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{

   

    public function ItemList(Request $request)
{
    $cart = session()->get('cart', []);
    $total = 0;
    foreach ($cart as $item) 
    {
    $total += $item['quantity'];
    }


    // get the authenticated user
    $user = auth()->user();

    // check if the authenticated user is an admin (role 1)
    if ($user->role == 1) {
        // if admin, get all products and users info from the database
        $users = DB::table('users')->get();
        $list = DB::table('products')
            ->join('quantities', 'products.id', '=', 'quantities.product_id')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->join('rack_locations', 'products.rack_id', '=', 'rack_locations.id')
            ->select('products.id', 'companies.company_name', 'rack_locations.location_code','products.product_name', 'products.item_per_carton', 'quantities.remaining_quantity', 'products.product_image','products.weight_per_item')
            ->get();
    } else {
        // if not admin, get products owned by the user
        $list = DB::table('products')->where('user_id', $user->id)->get();
    }

    // return the view with the list of products and the cart data
    return view('backend.carts.cart_index', compact('list', 'cart', 'users' ,'total'));
}


public function addToCart(Request $request, $id) 
{
    $product = Product::findOrFail($id);
    $rack = Rack::findOrFail($id);
    
    // Validate input
    $validatedData = $request->validate([
        'quantity' => 'required|numeric|min:1',
    ]);

    // Get the quantity to be deducted based on the input
    $quantity = $validatedData['quantity'];
    $num_cartons = floor($quantity / $product->item_per_carton);
    $num_items = $quantity % $product->item_per_carton;
    $quantity_deducted = $num_cartons * $product->item_per_carton + $num_items;
    
    // Check if the quantity is available
    if ($product->remaining_quantity > $quantity_deducted) {
    return redirect()->back()->with('error', 'Not enough stock!');
    }

    
    // Add the item to the cart
    $cart = session()->get('cart', []);
    $cart[$product->id] = [
        'name' => $product->product_name,
        'quantity' => $quantity,
        'rack' => $rack->rack_id,
        'image' => $product->product_image
    ];
    session()->put('cart', $cart);
    
    return redirect()->back()->with('success', 'Product added to cart!');
}


public function update(Request $request, $id)
    {
        $quantity = $request->input('quantity');
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully!');
        }

        return redirect()->back();
    }


    public function assign(Request $request) 
    {
        // Get the cart items
        $cart = session()->get('cart', []);
        
        // Deduct the items from the remaining quantity and update the product and quantity
        foreach ($cart as $id => $item) {
            $quantity_to_deduct = $item['quantity'];
            
            $quantity = Quantity::where('product_id', $id)->firstOrFail();
            $product = Product::findOrFail($quantity->product_id);
            $num_cartons = floor($quantity_to_deduct / $product->item_per_carton);
            $num_items = $quantity_to_deduct % $product->item_per_carton;
            $quantity_deducted = $num_cartons * $product->item_per_carton + $num_items;
            
            // Check if the quantity is available
            if ($quantity->remaining_quantity < $quantity_deducted) {
                return redirect()->back()->with('error', 'Not enough stock!');
            }
            
            $quantity->remaining_quantity -= $quantity_deducted;
            $quantity->sold_carton_quantity += $num_cartons;
            $quantity->sold_item_quantity += $num_items;
            $quantity->save();
    
            // Calculate the total weight of the items and deduct it from the rack's occupied amount
            
            $total_weight = $product->weight_per_item * $quantity_deducted;
            $rack = Rack::where('id', $product->rack_id)->firstOrFail();
            $rack->occupied = max(0, $rack->occupied - $total_weight);
            $rack->save();

            $weight = Weight::where('product_id', $product->id)->firstOrFail();
            $weight->weight_of_product -= $total_weight;
            $weight->save();
    
        }
        
        
        // Get the selected user ID
        $user_id = $request->input('user_id');
        
        // Store the assigned products and quantity in the pickers table
        foreach ($cart as $id => $item) {
            $picker = new Picker();
            $picker->user_id = $user_id;
            $picker->product_id = $id;
            $picker->rack_id = $product->rack_id;
            $picker->quantity = $item['quantity'];
            $picker->status = 'Pending'; 
            $picker->save();
        }
        
        // Clear the cart
        session()->forget('cart');
        
        return redirect()->back()->with('success', 'Order placed and products assigned successfully!');
    }
    

    


public function cartRemove($id)
{
    $cart = session()->get('cart', []);

    // Remove the item from the cart
    unset($cart[$id]);
    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Product removed from cart!');
}



public function clear()
{
    session()->forget('cart');
    return redirect()->back()->with('success', 'Cart cleared!');
}


}
