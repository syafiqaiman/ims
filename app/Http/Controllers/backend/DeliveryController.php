<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function deliveryFormCust()
    {
        // Retrieve products owned by the user
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->get();

        return view('backend.delivery.delivery_form', compact('products'));
    }
}
