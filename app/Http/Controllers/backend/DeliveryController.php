<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function deliveryFormCust()
    {
        return view('backend.delivery.delivery_form');
    }
}
