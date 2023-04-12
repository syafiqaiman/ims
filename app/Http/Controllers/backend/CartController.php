<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Company;
use App\Models\Product;
use App\Models\Quantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{

    public function create()
{
    $companies = Company::all();
    $products = [];

    if (request()->has('company_id')) {
        $products = Product::where('company_id', request('company_id'))->get();
    }

    return view('backend.carts.cart_view_company', compact('companies', 'products'));
}

    
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'product_id' => 'required|exists:products,id',
        'carton_quantity' => 'required|integer|min:0',
        'item_per_carton' => 'required|integer|min:0',
        'quantity' => 'required|integer|min:0',
    ]);

    $product = Product::findOrFail($validatedData['product_id']);
    $quantity = Quantity::findOrFail($product->quantity_id);

    $carton_quantity = $validatedData['carton_quantity'];
    $item_per_carton = $validatedData['item_per_carton'];
    $item_quantity = $validatedData['quantity'];
    $total_quantity = $carton_quantity * $item_per_carton + $item_quantity;

    if ($product->remaining_quantity < $total_quantity) {
        return back()->withErrors(['quantity' => 'Insufficient stock']);
    }

    $product->remaining_quantity -= $total_quantity;
    $product->save();

    $cart = new Cart;
    $cart->product_id = $product->id;
    $cart->carton_quantity = $carton_quantity;
    $cart->item_quantity = $item_quantity;
    $cart->total_quantity = $total_quantity;
    $cart->save();

    return redirect()->route('carts.index');
}




}
