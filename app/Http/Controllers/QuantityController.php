<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Quantity;
use App\Models\Company;
use App\Models\Cart;




class QuantityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CompanyList()
    {
        $companies = Company::select('company_id')->distinct()->pluck('company');
        $products = Product::with('quantity')->get();
        return view('backend.quantity.list_quantity', compact('companies', 'products'));
    }

    public function addToCart(Request $request, $id)
{
    $quantity = Quantity::find($request->quantity_id);
    $quantity->sold_carton_quantity += $request->carton_quantity;
    $quantity->sold_item_quantity += $request->item_quantity;
    $quantity->remaining_quantity -= $request->total_quantity;
    $quantity->save();

    // add the product to the cart table
    $product = Product::find($id);
    $cart = new Cart();
    $cart->user_id = auth()->user()->id;
    $cart->product_id = $product->id;
    $cart->quantity_id = $quantity->id;
    $cart->carton_quantity = $request->carton_quantity;
    $cart->item_quantity = $request->item_quantity;
    $cart->total_quantity = $request->total_quantity;
    $cart->save();


    return redirect()->back()->with('success', 'Product added to cart successfully');
}


    public function sellProduct(Request $request, $productId)
{
    // Get the quantity data for the product
    $quantity = DB::table('quantity')->where('product_id', $productId)->first();

    // Calculate the total number of items sold
    $soldItems = ($request->carton_quantity * $quantity->item_quantity) + $request->item_quantity;

    // Update the quantity table
    DB::table('quantity')->where('product_id', $productId)->update([
        'sold_carton_quantity' => $quantity->sold_carton_quantity + $request->carton_quantity,
        'sold_item_quantity' => $quantity->sold_item_quantity + $request->item_quantity,
        'remaining_quantity' => $quantity->remaining_quantity - $soldItems,
    ]);

    // Redirect to the product page
    return redirect()->route('product.show', $productId)->with('success', 'Product sold successfully');
}

}
