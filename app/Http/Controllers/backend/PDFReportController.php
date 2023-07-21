<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use PDF;
use Carbon\Carbon;

use App\Models\Product;
use App\Models\Company;
use App\Models\User;
use App\Models\Rack;
use App\Models\Floor;
use App\Models\Restock;
use App\Models\ProductRequest;
use App\Models\Order;
use App\Models\Quantity;

class PDFReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();

        if ($user->role == 3) {
            // If the user is of role 3, get products owned by the user with role 3

            // Get the start and end dates of the desired month
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();

            $data = DB::table('products')
                ->join('quantities', 'products.id', '=', 'quantities.product_id')
                ->join('companies', 'products.company_id', '=', 'companies.id')
                ->join('weights', 'products.id', '=', 'weights.product_id')
                ->join('product_request', 'companies.id', '=', 'product_request.company_id')
                ->select(
                    'products.id',
                    'weights.weight_of_product',
                    'product_request.product_price',
                    'companies.company_name',
                    'companies.address',
                    'companies.email',
                    'companies.phone_number',
                    'products.product_name',
                    'products.product_desc',
                    'products.item_per_carton',
                    'products.carton_quantity',
                    'quantities.total_quantity',
                    'quantities.remaining_quantity',
                    'products.weight_per_item',
                    'products.weight_per_carton',
                    'products.product_dimensions',
                    'products.product_image',
                    'products.date_to_be_stored',
                    'quantities.sold_carton_quantity',
                    'quantities.sold_item_quantity'
                )
                ->where('products.user_id', $user->id)
                ->whereDate('quantities.created_at', '>=', $startDate)
                ->whereDate('quantities.created_at', '<=', $endDate)
                ->distinct()
                ->get();

            // Calculate the revenue for each product
            $data = $data->map(function ($item) {
                $salesVolume = $item->sold_carton_quantity + $item->sold_item_quantity;
                $revenue = $salesVolume * $item->product_price;
                $item->revenue = $revenue;
                return $item;
            });

            // Get the total sales volume
            $totalSalesVolume = $data->sum(function ($item) {
                return $item->sold_carton_quantity + $item->sold_item_quantity;
            });

            // Calculate the total revenue
            $totalRevenue = $data->sum('revenue');

            // Retrieve the beginning inventory count
            $beginningInventory = DB::table('quantities')
                ->whereDate('created_at', '>=', now()->startOfMonth())
                ->orderBy('created_at')
                ->value('total_quantity');

            // Retrieve the ending inventory count
            $endingInventory = DB::table('quantities')
                ->whereDate('created_at', '<=', now()->endOfMonth())
                ->orderByDesc('created_at')
                ->value('total_quantity');

            // Get the total capacity of the warehouse
            $totalCapacity = DB::table('rack_locations')->sum('capacity');

            // Get the current occupied capacity of the warehouse
            $occupiedCapacity = DB::table('rack_locations')->sum('occupied');

            // Calculate the utilization rate
            $utilizationRate = ($occupiedCapacity / $totalCapacity) * 100;

            // Round the utilization rate to two decimal places
            $utilizationRate = round($utilizationRate, 2);

            // Retrieve the number of orders fulfilled during the month
            $ordersFulfilled = DB::table('orders')
                ->where('user_id', $user->id)
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count();

            // Retrieve the top-selling products based on inventory movement
            $topSellingProducts = DB::table('products')
                ->join('quantities', 'products.id', '=', 'quantities.product_id')
                ->select('products.product_name', 'quantities.sold_carton_quantity', 'quantities.sold_item_quantity')
                ->where('products.user_id', $user->id)
                ->orderByRaw('(quantities.sold_carton_quantity + quantities.sold_item_quantity) DESC')
                ->take(1) // Adjust the number as per your requirement
                ->get()
                ->toArray(); // Convert the collection to an array

            // Retrieve the low-selling products based on inventory movement
            $lowSellingProducts = DB::table('products')
                ->join('quantities', 'products.id', '=', 'quantities.product_id')
                ->select('products.product_name', 'quantities.sold_carton_quantity', 'quantities.sold_item_quantity')
                ->where('products.user_id', $user->id)
                ->orderByRaw('(quantities.sold_carton_quantity + quantities.sold_item_quantity) ASC')
                ->take(1) // Adjust the number as per your requirement
                ->get()
                ->toArray(); // Convert the collection to an array
        }

        return view('backend.report.PDFReport', compact('startDate', 'endDate', 'data', 'totalSalesVolume', 'totalRevenue', 'beginningInventory', 'endingInventory', 'occupiedCapacity', 'totalCapacity', 'utilizationRate', 'ordersFulfilled', 'topSellingProducts', 'lowSellingProducts'));


        //$pdf = PDF::loadView('backend.report.PDFReport', compact('data'));

        //return $pdf->stream('report.pdf');                // This line generate an error 126 (Software incompatibility with M1 Mac models)
    }
}