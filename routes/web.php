<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Company;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('user_list', [App\Http\Controllers\backend\UsermanagementController::class,'UserList'])->name('user.index');
Route::get('/edit_user/{id}', [App\Http\Controllers\backend\UsermanagementController::class,'UserEdit']);
Route::post('/update_user/{id}', [App\Http\Controllers\backend\UsermanagementController::class,'UserUpdate']);
Route::get('/delete_user/{id}', [App\Http\Controllers\backend\UsermanagementController::class,'UserDelete']);
//admin side
Route::get('list_product', [App\Http\Controllers\backend\ProductController::class,'ProductList'])->name('product.index');
Route::get('/add_product',[App\Http\Controllers\backend\ProductController::class,'ProductAdd'])->name('productadd');
Route::post('/insert_product', [App\Http\Controllers\backend\ProductController::class,'ProductInsert']);
Route::get('/edit_product/{id}', [App\Http\Controllers\backend\ProductController::class,'ProductEdit']);
Route::post('/update_product/{id}', [App\Http\Controllers\backend\ProductController::class,'ProductUpdate']);
Route::get('/delete_product/{id}', [App\Http\Controllers\backend\ProductController::class,'ProductDelete']);
//below is customer side
Route::get('/restock_form',[App\Http\Controllers\backend\ProductController::class,'RestockForm'])->name('restockform');
Route::get('/restock_form/{id}',[App\Http\Controllers\backend\ProductController::class,'RestockItem'])->name('restock');
Route::post('/send_request_restock',[App\Http\Controllers\backend\ProductController::class,'SendRequestProduct'])->name('requestproduct');
Route::get('/request_restock_status',[App\Http\Controllers\backend\ProductController::class,'showRestockRequests'])->name('showstatus');
Route::get('/review_request',[App\Http\Controllers\backend\ProductController::class,'reviewRestockRequest'])->name('reviewrequest');
Route::get('remove_request/{id}', [App\Http\Controllers\backend\ProductController::class,'RemoveRequest']);
Route::get('approve_request/{id}', [App\Http\Controllers\backend\ProductController::class,'approveRequest']);
Route::get('/customer_add_product',[App\Http\Controllers\backend\ProductController::class,'CustomerAddProductForm'])->name('customerproductadd');
Route::post('/request_product',[App\Http\Controllers\backend\ProductController::class,'storeProductRequest'])->name('productrequest');
Route::get('/product_request_list', [App\Http\Controllers\backend\ProductController::class, 'viewRequestProductList'])->name('viewrequestproduct');
Route::get('/check_new_product',[App\Http\Controllers\backend\ProductController::class,'adminCheckNewProductRequest'])->name('checknewproduct');
Route::post('/check_new_product/{id}/approve',[App\Http\Controllers\backend\ProductController::class,'approveProductRequest'])->name('approveProductRequest');
Route::get('/check_new_product/{id}/reject',[App\Http\Controllers\backend\ProductController::class,'rejectProductRequest'])->name('rejectProductRequest');


//Delivery
Route::get('/delivery/delivery_form',[App\Http\Controllers\backend\DeliveryController::class,'deliveryFormCust'])->name('deliveryform');



Route::get('/company/getUsers', function (Request $request) {
    $company = Company::find($request->company_id);
    $users = $company ? $company->getUsers() : [];
    return response()->json($users);
})->name('company.getUsers');


Route::get('quantity_list', [App\Http\Controllers\backend\QuantityController::class, 'ProductQuantityList'])->name('quantity.index');
Route::get('my_stock_level', [App\Http\Controllers\backend\QuantityController::class, 'MyStockLevel'])->name('mystocklevel');

Route::get('picker_task', [App\Http\Controllers\backend\PickerController::class, 'PickerTaskList'])->name('pickertask');
Route::post('/picker/confirm-collection/{id}/{quantity}', [App\Http\Controllers\backend\PickerController::class, 'confirmCollection'])->name('picker.confirm');
Route::get('/picker/history',  [App\Http\Controllers\backend\PickerController::class, 'history'])->name('picker.history');
Route::get('/picker_status',  [App\Http\Controllers\backend\PickerController::class, 'AdminView'])->name('picker.viewstatus');

Route::get('cart_index', [App\Http\Controllers\backend\CartController::class, 'ItemList'])->name('quantity.index');
Route::get('/cart_view', [App\Http\Controllers\backend\CartController::class, 'ItemList'])->name('quantitycart');
Route::post('/cart/add/{id}', [App\Http\Controllers\backend\CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove/{id}', [App\Http\Controllers\backend\CartController::class, 'cartRemove'])->name('cart.remove');
Route::post('/assign', [App\Http\Controllers\backend\CartController::class, 'assign'])->name('assign.index');
Route::post('/cart/update/{id}', [App\Http\Controllers\backend\CartController::class, 'update'])->name('cart.update');
Route::post('/cart_clear', [App\Http\Controllers\backend\CartController::class, 'clear'])->name('cart.clear');

    Route::get('detail_company', [App\Http\Controllers\backend\CompanyController::class, 'index'])->name('company.index');
    Route::get('/add_company', [App\Http\Controllers\backend\CompanyController::class, 'create'])->name('company.create');
    Route::post('/insert_company', [App\Http\Controllers\backend\CompanyController::class, 'insert'])->name('company.insert');
    Route::get('/companies/{id}/edit', [App\Http\Controllers\backend\CompanyController::class, 'edit'])->name('company.edit');
    Route::put('/companies/{id}', [App\Http\Controllers\backend\CompanyController::class, 'update'])->name('company.update');
    Route::delete('/companies/{id}', [App\Http\Controllers\backend\CompanyController::class, 'destroy'])->name('company.destroy');
    Route::get('/company_list', [App\Http\Controllers\backend\CompanyController::class, 'showAll'])->name('companylist');

    Route::get('/racks', [App\Http\Controllers\backend\RackController::class, 'RackList'])->name('rack.list'); 
    //Route::group(['middleware' => ['auth']], function () {

    Route::get('/orders/{companyId}', [App\Http\Controllers\backend\OrderController::class, 'orderList'])->name('orderList');
    Route::get('/invoice/{order_no}', [App\Http\Controllers\backend\OrderController::class, 'generateInvoice'])->name('backend.invoice.generate');
    Route::get('/invoice/{order_no}', [App\Http\Controllers\backend\OrderController::class, 'show'])->name('orderShow');
    Route::get('invoice/{id}/download', [App\Http\Controllers\backend\InvoiceController::class, 'download'])->name('invoice.download');