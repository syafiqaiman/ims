<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    // get the authenticated user
    $user = auth()->user();

    
    $productsCount = Product::count();
    $ordersCount = Order::count();
    $usersCount = User::count();
    
    return view('home', compact('productsCount', 'ordersCount', 'usersCount'));


    }

    
}
