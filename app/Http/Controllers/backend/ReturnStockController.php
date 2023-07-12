<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Product;
use App\Models\ReturnStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


public function storeReturnStock(Request $request)
{
    // Validate the input data
    $validatedData = $request->validate([
        'company_id' => 'required',
        'address' => 'required',
        'phone_number' => 'required',
        'email' => 'required|email',
        'product_id.*' => 'required',
        'quantity.*' => 'required|numeric|min:1',
        'remark.*' => 'nullable|string',
        'status.*' => 'required|in:Dispose,Refurbish', // Added status validation
    ]);

    // Generate a unique PO number for the return_no column
    $returnNo = $this->generateRONumber();

    // Create the return stock record
    $returnStock = ReturnStock::create([
        'user_id' => auth()->user()->id,
        'company_id' => $validatedData['company_id'],
        'address' => $validatedData['address'],
        'phone_number' => $validatedData['phone_number'],
        'email' => $validatedData['email'],
        'return_no' => $returnNo,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Handle the product data
    $productData = [];

    // Loop through the product details, remarks, and statuses
    foreach ($validatedData['product_id'] as $index => $productId) {
        $productData[] = [
            'product_id' => $productId,
            'quantity' => $validatedData['quantity'][$index],
            'remark' => $validatedData['remark'][$index] ?? null,
            'status' => $validatedData['status'][$index], // Added status
        ];
    }

    // Attach the product data to the return stock record
    $returnStock->products()->attach($productData);

    // Redirect or respond with a success message
    return redirect()->back()->with('success', 'Return stock information has been successfully saved.');
}

public function returnStockList()
{

    
    if (auth()->user()->role == 1) {
        $returnStockList = ReturnStock::all();
    } else {
        $returnStockList = ReturnStock::where('user_id', auth()->user()->id)->get();
    }

    $returnStockList->load('products:product_name');

    
    return view('backend.return_stock.return_stock_status_cust', compact('returnStockList'));
}
}
