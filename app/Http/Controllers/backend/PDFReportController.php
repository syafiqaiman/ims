<?php
 
namespace App\Http\Controllers\backend;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use PDF;

use App\Models\Product;
use App\Models\Company;
use App\Models\User;
use App\Models\Rack;
use App\Models\Floor;
use App\Models\Restock;
use App\Models\ProductRequest;
 
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
            $data = DB::table('products')
                ->join('quantities', 'products.id', '=', 'quantities.product_id')
                ->join('companies', 'products.company_id', '=', 'companies.id')
                ->join('weights', 'products.id', '=', 'weights.product_id')
                ->join('product_request', 'companies.id', '=', 'product_request.company_id')
                ->select('products.id','weights.weight_of_product','product_request.product_price', 'companies.company_name', 'companies.address', 'companies.email', 'companies.phone_number', 'products.product_name', 'products.product_desc', 'products.item_per_carton', 'products.carton_quantity', 'quantities.total_quantity', 'quantities.remaining_quantity', 'products.weight_per_item', 'products.weight_per_carton', 'products.product_dimensions', 'products.product_image', 'products.date_to_be_stored')
                ->where('products.user_id', $user->id)
                ->distinct()
                ->get();
        }

        return view('backend.report.PDFReport', compact('data'));

        //$pdf = PDF::loadView('backend.report.PDFReport', compact('data'));

        //return $pdf->stream('report.pdf');                // This line generate an error 126 (Software incompatibility with M1 Mac models)
    }
}
