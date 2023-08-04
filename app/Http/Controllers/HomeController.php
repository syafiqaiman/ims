<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\ReturnStock;

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

    //For Admin

    $productsCount = Product::count();
    $ordersCount = Order::count();
    $usersCount = User::count();

    //For Picker

    $completedOrdersCount = Order::where('user_id', $user->id)->distinct('order_no')->count();



    //For Customer

    $userProductsCount = Product::where('user_id', $user->id)->count();
    $completedReturnStocksCount = ReturnStock::where('user_id', $user->id)
    ->where('receive_status', 'Received')
    ->distinct('return_no')
    ->count();


    return view('home', compact('productsCount', 'ordersCount', 'usersCount','userProductsCount', 'completedOrdersCount', 'completedReturnStocksCount'));


    }

    
}
