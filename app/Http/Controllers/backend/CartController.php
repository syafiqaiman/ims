<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Company;
use App\Models\Product;
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
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // get the authenticated user
    $user = auth()->user();

    // check if the authenticated user is an admin (role 1)
    if ($user->role == 1) {
        // if admin, get all products from the database
        $list = DB::table('products')
            ->join('quantities', 'products.id', '=', 'quantities.product_id')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.id', 'companies.company_name', 'products.product_name', 'products.item_per_carton', 'quantities.remaining_quantity', 'products.product_image')
            ->get();
    } else {
        // if not admin, get products owned by the user
        $list = DB::table('products')->where('user_id', $user->id)->get();
    }

    // return the view with the list of products and the cart data
    return view('backend.carts.cart_index', compact('list', 'cart', 'total'));
}

    
/*
public function deductProduct(Request $request, $id) 
{
    $product = Product::findOrFail($id);
    
    // Validate input
    $validatedData = $request->validate([
        'quantity' => 'required|numeric|min:1',
    ]);

    // Get the quantity to be deducted based on the input
    $quantity = $validatedData['quantity'];
    $num_cartons = ceil($quantity / $product->item_per_carton);
    $num_items = $quantity % $product->item_per_carton;
    $quantity_to_deduct = $num_cartons * $product->carton_quantity + $num_items;
    
    // Check if the quantity is available
    if ($quantity_to_deduct > $product->remaining_quantity) {
        return redirect()->back()->with('error', 'Not enough stock!');
    }
    
    // Deduct the quantity from the remaining quantity
    $product->remaining_quantity -= $quantity_to_deduct;
    $product->sold_carton_quantity += $num_cartons;
    $product->sold_item_quantity += $num_items;
    $product->save();
    
    // Add the item to the cart
    $cart = Cart::where('product_id', $product->id)->first();
    if ($cart) {
        $cart->quantity += $quantity;
        $cart->total_quantity += $quantity_to_deduct;
        $cart->save();
    } else {
        $cart = new Cart();
        $cart->product_id = $product->id;
        $cart->quantity = $quantity;
        $cart->carton_quantity = $num_cartons;
        $cart->item_quantity = $num_items;
        $cart->total_quantity = $quantity_to_deduct;
        $cart->save();
    }
    
    // Create a new order
    $order = new Order();
    $order->user_id = auth()->user()->id;
    $order->product_id = $product->id;
    $order->quantity = $quantity;
    $order->save();
    
    // Update the quantity in the quantities table
    $quantityObj = Quantity::where('product_id', $product->id)->first();
    $quantityObj->total_quantity -= $quantity_to_deduct;
    $quantityObj->sold_carton_quantity += $num_cartons;
    $quantityObj->sold_item_quantity += $num_items;
    $quantityObj->remaining_quantity -= $quantity_to_deduct;
    $quantityObj->save();
    
    return redirect()->back()->with('success', 'Product added to cart!');
}

*/


public function addToCart(Request $request, $id) 
{
    $product = Product::findOrFail($id);
    
    // Validate input
    $validatedData = $request->validate([
        'quantity' => 'required|numeric|min:1',
    ]);

    // Get the quantity to be deducted based on the input
    $quantity = $validatedData['quantity'];
    $num_cartons = ceil($quantity / $product->item_per_carton);
    $num_items = $quantity % $product->item_per_carton;
    $quantity_to_deduct = $num_cartons * $product->carton_quantity + $num_items;
    
    // Check if the quantity is available
    if ($quantity_to_deduct > $product->remaining_quantity) {
        return redirect()->back()->with('error', 'Not enough stock!');
    }
    
    // Add the item to the cart
    $cart = session()->get('cart', []);
    $cart[$product->id] = [
        'name' => $product->product_name,
        'quantity' => $quantity,
        'price' => $product->price,
        'image' => $product->product_image
    ];
    session()->put('cart', $cart);
    
    // Create a new order
    $order = new Order();
    $order->user_id = auth()->user()->id;
    $order->product_id = $product->id;
    $order->quantity = $quantity;
    $order->save();
    
    return redirect()->back()->with('success', 'Product added to cart!');
}

public function checkout() 
{
    // Get the cart items
    $cart = session()->get('cart', []);
    
    // Deduct the items from the remaining quantity and update the product
    foreach ($cart as $id => $item) {
        $product = Product::findOrFail($id);
        $quantity_to_deduct = $item['quantity'];
        $num_cartons = ceil($quantity_to_deduct / $product->item_per_carton);
        $num_items = $quantity_to_deduct % $product->item_per_carton;
        $quantity_deducted = $num_cartons * $product->carton_quantity + $num_items;
        $product->remaining_quantity -= $quantity_deducted;
        $product->sold_carton_quantity += $num_cartons;
        $product->sold_item_quantity += $num_items;
        $product->save();
    }
    
    // Create a new order for each cart item
    foreach ($cart as $id => $item) {
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->product_id = $id;
        $order->quantity = $item['quantity'];
        $order->save();
    }
    
    // Clear the cart
    session()->forget('cart');
    
    return redirect()->back()->with('success', 'Checkout successful!');
}


public function index()
{
    $cart = session()->get('cart', []);
    $cart_data = [];
    foreach ($cart as $id => $item) {
        $product = Product::findOrFail($id);
        $cart_data[] = [
            'id' => $id,
            'name' => $item['name'],
            'quantity' => $item['quantity'],
            'image' => $item['image'],
            'remaining_quantity' => $product->remaining_quantity,
        ];
    }
    return view('backend.carts.cart_index', compact('cart_data'));
}

public function update(Request $request, $id)
{
    $cart = session()->get('cart', []);
    $product = Product::findOrFail($id);
    $validatedData = $request->validate([
        'quantity' => 'required|numeric|min:1',
    ]);
    $quantity = $validatedData['quantity'];
    $num_cartons = ceil($quantity / $product->item_per_carton);
    $num_items = $quantity % $product->item_per_carton;
    $quantity_to_deduct = $num_cartons * $product->carton_quantity + $num_items;
    if ($quantity_to_deduct > $product->remaining_quantity) {
        return redirect()->back()->with('error', 'Not enough stock!');
    }
    $prev_quantity = $cart[$id]['quantity'];
    $prev_num_cartons = ceil($prev_quantity / $product->item_per_carton);
    $prev_num_items = $prev_quantity % $product->item_per_carton;
    $prev_quantity_to_deduct = $prev_num_cartons * $product->carton_quantity + $prev_num_items;
    $product->remaining_quantity += $prev_quantity_to_deduct;
    $product->sold_carton_quantity -= $prev_num_cartons;
    $product->sold_item_quantity -= $prev_num_items;
    $product->remaining_quantity -= $quantity_to_deduct;
    $product->sold_carton_quantity += $num_cartons;
    $product->sold_item_quantity += $num_items;
    $product->save();
    $cart[$id]['quantity'] = $quantity;
    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Cart updated!');
}

public function cartRemove($id)
{
    $cart = session()->get('cart', []);
    $product = Product::findOrFail($id);
    $prev_quantity = $cart[$id]['quantity'];
    $prev_num_cartons = ceil($prev_quantity / $product->item_per_carton);
    $prev_num_items = $prev_quantity % $product->item_per_carton;
    $prev_quantity_to_deduct = $prev_num_cartons * $product->carton_quantity + $prev_num_items;
    $product->remaining_quantity += $prev_quantity_to_deduct;
    $product->sold_carton_quantity -= $prev_num_cartons;
    $product->sold_item_quantity -= $prev_num_items;
    $product->save();
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
