<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;

class ReturnStockController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function CustReturnStockForm(Request $request)
{
    // Get the user's ID
    $user_id = auth()->user()->id;

    // Get the user's company
    $company = Company::where('user_id', $user_id)->first();

    // Get the user's product
    $products = Product::where('user_id', $user_id)->get();

    // Get all companies
    $companies = Company::where('id', $company->id)->get();

    // Return the view with the company and companies
    return view('backend.return_stock.return_stock_form', compact('company', 'companies','products'));
}

private function generateRONumber()
{
    // Get the current timestamp
    $timestamp = time();

    // Generate a unique identifier based on the timestamp
    $identifier = substr($timestamp, -6); // Example: Use the last 6 digits of the timestamp

    // Construct the PO number with a prefix and the identifier
    $ro_number = 'RO-' . $identifier;

    // Return the PO number
    return $ro_number;
}
}
