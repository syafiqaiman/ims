<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\Company;
use App\Models\User;
use App\Models\Rack;
use App\Models\Restock;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function ProductList(Request $request)
{
    // get the authenticated user
    $user = auth()->user();

    // check if the authenticated user is an admin (role 1)
    if ($user->role == 1) {
        // if admin, get all products from the database
        $list = DB::table('products')
        ->join('quantities', 'products.id', '=', 'quantities.product_id')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->join('rack_locations', 'products.rack_id', '=', 'rack_locations.id')
        ->join('weights', 'products.id', '=', 'weights.product_id')
        ->select('products.id','rack_locations.location_code', 'companies.company_name', 'products.product_name', 'products.product_desc', 'products.item_per_carton', 'products.carton_quantity', 'quantities.total_quantity', 'quantities.remaining_quantity', 'products.weight_per_item', 'products.weight_per_carton', 'weights.weight_of_product', 'products.product_dimensions', 'products.product_image', 'products.date_to_be_stored')
        ->get();


    } else {
        // if not admin, get products owned by the user
        if ($user->role == 3) {
            // if the user is of role 3, get products owned by the user with role 3
            $list = DB::table('products')
                ->join('quantities', 'products.id', '=', 'quantities.product_id')
                ->join('companies', 'products.company_id', '=', 'companies.id')
                ->join('weights', 'products.id', '=', 'weights.product_id')
                ->select('products.id','weights.weight_of_product', 'companies.company_name', 'products.product_name', 'products.product_desc', 'products.item_per_carton', 'products.carton_quantity', 'quantities.total_quantity', 'quantities.remaining_quantity', 'products.weight_per_item', 'products.weight_per_carton', 'products.product_dimensions', 'products.product_image', 'products.date_to_be_stored')
                ->where('products.user_id', $user->id)
                ->get();
        } else {
            // if the user is not an admin or of role 3, get products owned by the user
            $list = DB::table('products')->where('user_id', $user->id)->get();
        }
    }

    // return the view with the list of products
    return view('backend.product.list_product', compact('list'));
}

    
public function getUsers(Request $request)
{
    $company = Company::find($request->company_id);
    $users = $company->users;

    return response()->json($users);
}


    /**
     * Show the form for creating a new resource.
     */
    public function ProductAdd(Request $request)
    {
     // Get all companies
    $companies = Company::all();
    $racks = Rack::all();
    // Get the selected company's ID
    $company_id = $request->input('company');

    // Get the users associated with the selected company
    $users = DB::table('users')
        ->join('companies', 'users.id', '=', 'companies.user_id')
        ->where('companies.id', $company_id)
        ->select('users.id', 'users.name')
        ->get();

    // Get all products
    $allProducts = DB::table('products')->get();

    // Return the view with the companies, users, and products
    return view('backend.product.create_product', compact('companies', 'users', 'allProducts','racks'));
    }
    

    
    /**
     * Store a newly created resource in storage.
     */
    public function ProductInsert(Request $request)
{

    // Calculate the total quantity
    $total_quantity = $request->carton_quantity * $request->item_per_carton;
    $total_weight = $total_quantity * $request->weight_per_item;
    $rack_id = $request->rack_id;
    
     // Check if the total weight exceeds the limit of 200
     if ($total_weight > 200) {
        return redirect()->back()->with('error', 'Total weight exceeds limit of 200. Please adjust your inputs.')->withInput();
    }

    // Get the rack capacity and occupied weight
$rack_data = DB::table('rack_locations')
->where('id', $rack_id)
->select('capacity', 'occupied')
->first();

$rack_capacity = $rack_data->capacity;
$occupied_weight = $rack_data->occupied;

// Calculate the remaining capacity
$remaining_capacity = $rack_capacity - $occupied_weight;


    $validatedData = $request->validate([
        'company_id' => 'required',
        'product_name' => 'required|string|max:255',
        'product_desc' => 'required|string',
        'weight_per_item' => 'required|numeric',
        'weight_per_carton' => 'required|numeric',
        'product_dimensions' => 'required|string|max:255',
        'date_to_be_stored' => 'required|date',
        'carton_quantity' => 'required|integer',
        'item_per_carton' => 'required|integer',
        'product_image' => 'required|image|max:2048',
        'rack_id' => 'required'
    ]);

    $company = DB::table('companies')
        ->where('id', $request->company_id)
        ->first();

    $data = [
        'user_id' => $company->user_id,
        'company_id' => $request->company_id,
        'product_name' => $request->product_name,
        'product_desc' => $request->product_desc,
        'item_per_carton' => $request->item_per_carton,
        'carton_quantity' => $request->carton_quantity,
        'weight_per_item' => $request->weight_per_item,
        'weight_per_carton' => $request->weight_per_carton,
        'product_dimensions' => $request->product_dimensions,
        'rack_id' => $request->rack_id,
        'date_to_be_stored' => $request->date_to_be_stored,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    if ($request->hasFile('product_image')) {
        $file = $request->file('product_image');
        $filename = date('YmdHi') . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/Image', $filename);
        $data['product_image'] = $filename;

        // Move the file to the desired folder
        Storage::move('public/'.$filename, 'public/Image/'.$filename);
    }


// Check if the remaining capacity is less than the weight of the new product
if ($remaining_capacity < $total_weight) {
    return redirect()->back()->with('error', 'Rack capacity exceeded. Remaining capacity: '.$remaining_capacity.'. Please adjust your inputs.')->withInput();
} else {
    // Insert data into the products table
    $product_id = DB::table('products')->insertGetId($data);

    if ($product_id) {
        // Insert data into the quantity table
        DB::table('quantities')->insert([
            'product_id' => $product_id,
            'total_quantity' => $total_quantity,
            'sold_carton_quantity' => 0,
            'sold_item_quantity' => 0,
            'remaining_quantity' => $total_quantity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert data into the weights table
        DB::table('weights')->insert([
            'product_id' => $product_id,
            'weight_of_product' => $total_weight,
            'rack_id' => $data['rack_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Get the total weight of products in the current rack
        $total_weight_in_rack = DB::table('weights')
            ->join('products', 'weights.product_id', '=', 'products.id')
            ->where('products.rack_id', $rack_id)
            ->sum('weight_of_product');

        // Update rack_locations table with the occupied weight
        DB::table('rack_locations')
            ->where('id', $rack_id)
            ->update(['occupied' => $total_weight_in_rack]);

        return redirect()->route('product.index')->with('success','Product added successfully');
    } else {
        $notification = ['message' => 'Error', 'alert-type' => 'error'];
        return redirect()->route('product.index')->with($notification);
    }

    }
}

    

    public function ProductEdit($id)
    {
        $edit = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.id', 'products.company_id', 'companies.id AS company_id', 'companies.company_name', 'product_name', 'product_desc', 'product_image', 'product_dimensions','date_to_be_stored', 'weight_per_item', 'weight_per_carton')
            ->where('products.id', $id)
            ->first();
    
        $companies = Company::all();
    
        return view('backend.product.edit_product', compact('edit', 'companies'));
    }
    

public function ProductUpdate(Request $request, $id)
{
    $validatedData = $request->validate([
        'company_id' => 'required',
        'product_name' => 'required|string|max:255',
        'product_desc' => 'required|string',
        'weight_per_item' => 'required|numeric',
        'weight_per_carton' => 'required|numeric',
        'product_dimensions' => 'required|string|max:255',
        'date_to_be_stored' => 'required|date',
        'product_image' => 'image|max:2048'
    ]);

    $data = [
        'user_id' => auth()->user()->id,
        'company_id' => $request->company_id,
        'product_name' => $request->product_name,
        'product_desc' => $request->product_desc,
        'weight_per_item' => $request->weight_per_item,
        'weight_per_carton' => $request->weight_per_carton,
        'product_dimensions' => $request->product_dimensions,
        'date_to_be_stored' => $request->date_to_be_stored,
        'updated_at' => now(),
    ];

    // Check if image is uploaded
    if ($request->hasFile('product_image')) {
        $file = $request->file('product_image');
        $filename = date('YmdHi') . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/Image', $filename);
        $data['product_image'] = $filename;
        
        // Move the file to the desired folder
        Storage::move('public/'.$filename, 'public/Image/'.$filename);
    }

    $update = DB::table('products')->where('id', $id)->update($data);

    if ($update) {
        return Redirect()->route('product.index')->with('success','Product Updated Successfully!');                     
    } else {
        $notification = array(
            'message' => 'error',
            'alert-type' => 'error'
        );
        return Redirect()->route('product.index')->with($notification);
    }
}

    

public function ProductDelete($id)
{
    $product = Product::findOrFail($id);

    $rack = $product->rack;
    $rackId = $rack->id;

    $newOccupied = DB::table('weights')
    ->join('rack_locations', 'rack_locations.id', '=', 'weights.rack_id')
    ->where('rack_locations.id', '=', $rackId)
    ->where('weights.product_id', '!=', $id) // exclude the product being deleted
    ->sum('weights.weight_of_product');


DB::table('rack_locations')
    ->where('id', '=', $rackId)
    ->update(['occupied' => $newOccupied]);


    if ($product->delete()) {
        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } else {
        $notification = array(
            'message' => 'Error',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }
}




      public function getProducts($company_id)
{
    $products = Product::where('company_id', $company_id)->pluck('product_name', 'id');
    return response()->json($products);
}


//Customer Side For Product Adding

public function RestockForm(Request $request)
{
    // Get the authenticated user's ID
    $user_id = auth()->user()->id;

    // Get the authenticated user with their associated companies and products
    $user = User::with(['companies.products'])->find($user_id);

    // Get the authenticated user's company
    $company = $user->companies->first();

    // Get the products of the authenticated user's company
    $products = $company->products;

    // Return the view with the user's company and products
    return view('backend.product.restock_form', compact('company', 'products','user'));
}



//view chosen item to be restocked
public function RestockItem($id)
{
    $user_id = auth()->user()->id;

    $restock = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->join('rack_locations', 'products.rack_id', '=', 'rack_locations.id')
        ->select('products.id', 'products.company_id','rack_locations.id AS rack_id', 'companies.id AS company_id', 'companies.company_name', 'product_name', 'product_desc', 'product_image', 'product_dimensions','date_to_be_stored', 'weight_per_item', 'weight_per_carton')
        ->where('products.id', $id)
        ->where('companies.user_id', $user_id) // Add condition to check if the company belongs to the user
        ->first();

    $companies = Company::all();

    if (!$restock) {
        // Product not found or does not belong to the user's company
        return redirect()->back()->with('error', 'Invalid product.');
    }

    return view('backend.product.restock_form_test', compact('restock', 'companies'));
}



public function SendRequestProduct(Request $request)
{
    $total_quantity = $request->carton_quantity * $request->item_per_carton;
    $total_weight = $total_quantity * $request->weight_per_item;

    // Check if the total weight exceeds the limit of 200
    if ($total_weight > 200) {
        return redirect()->back()->with('error', 'Total weight exceeds the limit of 200. Please adjust your inputs.')->withInput();
    }

    // Get the user's ID
    $user_id = auth()->user()->id;

    $restock = DB::table('restock_request')
    ->join('products', 'restock_request.product_id', '=', 'products.id')
    ->select('restock_request.*', 'products.product_name', 'products.product_desc', 'products.weight_per_item')
    ->where('restock_request.user_id', $user_id)
    ->get();

    // Insert data into the restock_request table
    DB::table('restock_request')->insert([
        'total_weight' => $total_weight,
        'product_id' => $request->product_id,
        'rack_id' => $request->rack_id,
        'status' => 'Under Review',
        'user_id' => $user_id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    return redirect()->route('showstatus')->with('success','Request has been send');
}

public function showRestockRequests()
{
    $user_id = auth()->user()->id;

    $restock = DB::table('restock_request')
        ->join('products', 'restock_request.product_id', '=', 'products.id')
        ->select('restock_request.*', 'products.product_name', 'products.product_desc', 'products.weight_per_item')
        ->where('restock_request.user_id', $user_id)
        ->get();

    return view('backend.product.restock_status_customer', compact('restock'));
}

public function reviewRestockRequest()
{
    $user_id = auth()->user()->id;

    $restock = DB::table('restock_request')
        ->join('products', 'restock_request.product_id', '=', 'products.id')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('restock_request.*', 'products.product_name','companies.company_name', 'products.product_desc', 'products.weight_per_item','products.weight_per_carton','products.product_image')
        ->get();

    return view('backend.product.review_restock_request', compact('restock'));
}

public function RemoveRequest($id)
{

    $restock = Restock::findOrFail($id);

    // Update the status to "Rejected"
    $restock->status = 'Rejected';
    $restock->save();

    $notification = array(
        'message' => 'Request Rejected Successfully',
        'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
}

}


