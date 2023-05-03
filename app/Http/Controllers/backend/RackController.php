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
use App\Models\Rack;

class RackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function RackList(Request $request)
    {
        // get the authenticated user
        $user = auth()->user();

        // check if the authenticated user is an admin (role 1)
        if ($user->role == 1) {
            // if admin, get all products from the database
            $racking = DB::table('rack_locations')
                ->join('products', 'rack_locations.id', '=', 'products.rack_id')
                ->join('companies', 'products.company_id', '=', 'companies.id')
                ->join('quantities', 'products.id', '=', 'quantities.id')
                ->select('rack_locations.location_code', 'products.product_name', 'companies.company_name', 'rack_locations.capacity', 'quantities.remaining_quantity', 'products.id')
                ->get();
        } else {
            // if not admin, get products owned by the user
            $racking = DB::table('rack_locations')->where('user_id', $user->id)->get();
        }

        // return the view with the list of products
        return view('backend.rack.list_rack', compact('racking'));
    }
}
