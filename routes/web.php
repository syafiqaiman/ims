<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Controllers\backend\UsermanagementController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\DeliveryController;
use App\Http\Controllers\backend\QuantityController;
use App\Http\Controllers\backend\PickerController;
use App\Http\Controllers\backend\CartController;
use App\Http\Controllers\backend\CompanyController;
use App\Http\Controllers\backend\RackController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\InvoiceController;




Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// User management
Route::get('user_list', [UsermanagementController::class, 'UserList'])->name('user.index');
Route::get('/edit_user/{id}', [UsermanagementController::class, 'UserEdit']);
Route::post('/update_user/{id}', [UsermanagementController::class, 'UserUpdate']);
Route::get('/delete_user/{id}', [UsermanagementController::class, 'UserDelete']);

// Admin side product management
Route::get('list_product', [ProductController::class, 'ProductList'])->name('product.index');
Route::get('/add_product', [ProductController::class, 'ProductAdd'])->name('productadd');
Route::post('/insert_product', [ProductController::class, 'ProductInsert']);
Route::get('/edit_product/{id}', [ProductController::class, 'ProductEdit']);
Route::post('/update_product/{id}', [ProductController::class, 'ProductUpdate']);
Route::get('/delete_product/{id}', [ProductController::class, 'ProductDelete']);

// Customer side product restock
Route::get('/restock_form', [ProductController::class, 'RestockForm'])->name('restockform');
Route::get('/restock_form/{id}', [ProductController::class, 'RestockItem'])->name('restock');
Route::post('/send_request_restock', [ProductController::class, 'SendRequestProduct'])->name('requestproduct');
Route::get('/request_restock_status', [ProductController::class, 'showRestockRequests'])->name('showstatus');
Route::get('/review_request', [ProductController::class, 'reviewRestockRequest'])->name('reviewrequest');
Route::get('remove_request/{id}', [ProductController::class, 'RemoveRequest']);
Route::get('approve_request/{id}', [ProductController::class, 'approveRequest']);
Route::get('/customer_add_product', [ProductController::class, 'CustomerAddProductForm'])->name('customerproductadd');
Route::post('/request_product', [ProductController::class, 'storeProductRequest'])->name('productrequest');
Route::get('/product_request_list', [ProductController::class, 'viewRequestProductList'])->name('viewrequestproduct');
Route::get('/check_new_product', [ProductController::class, 'adminCheckNewProductRequest'])->name('checknewproduct');
Route::post('/check_new_product/{id}/approve', [ProductController::class, 'approveProductRequest'])->name('approveProductRequest');
Route::get('/check_new_product/{id}/reject', [ProductController::class, 'rejectProductRequest'])->name('rejectProductRequest');
Route::get('/remove-rejected-request/{id}', [ProductController::class, 'removeRequestRestockCust'])->name('removeRejectedRequest');

// Delivery
Route::get('/delivery/delivery_form', [DeliveryController::class, 'deliveryFormCust'])->name('deliveryform');
Route::post('/delivery/form_sent', [DeliveryController::class, 'storeDelivery'])->name('delivery.submit');

// Company
Route::get('/company/getUsers', [CompanyController::class, 'getUsers'])->name('company.getUsers');
Route::get('detail_company', [CompanyController::class, 'index'])->name('company.index');
Route::get('/add_company', [CompanyController::class, 'create'])->name('company.create');
Route::post('/insert_company', [CompanyController::class, 'insert'])->name('company.insert');
Route::get('/companies/{id}/edit', [CompanyController::class, 'edit'])->name('company.edit');
Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('company.update');
Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');
Route::get('/company_list', [CompanyController::class, 'showAll'])->name('companylist');

// Quantity
Route::get('quantity_list', [QuantityController::class, 'ProductQuantityList'])->name('quantity.index');
Route::get('my_stock_level', [QuantityController::class, 'MyStockLevel'])->name('mystocklevel');

// Picker task
Route::get('picker_task', [PickerController::class, 'PickerTaskList'])->name('pickertask');
Route::post('/picker/confirm-collection/{id}/{quantity}', [PickerController::class, 'confirmCollection'])->name('picker.confirm');
Route::get('/picker/history',  [PickerController::class, 'history'])->name('picker.history');
Route::get('/picker_status',  [PickerController::class, 'AdminView'])->name('picker.viewstatus');

// Cart
Route::get('cart_index', [CartController::class, 'ItemList'])->name('quantity.index');
Route::get('/cart_view', [CartController::class, 'ItemList'])->name('quantitycart');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'cartRemove'])->name('cart.remove');
Route::post('/assign', [CartController::class, 'assign'])->name('assign.index');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart_clear', [CartController::class, 'clear'])->name('cart.clear');

// Rack
Route::get('/racks', [RackController::class, 'RackList'])->name('rack.list');

// Orders
Route::get('/orders/{companyId}', [OrderController::class, 'orderList'])->name('orderList');
Route::get('/invoice/{order_no}', [OrderController::class, 'generateInvoice'])->name('backend.invoice.generate');
Route::get('/invoice/{order_no}', [OrderController::class, 'show'])->name('orderShow');

// Invoice
Route::get('invoice/{id}/download', [InvoiceController::class, 'download'])->name('invoice.download');

// Floor
Route::get('/floors', [App\Http\Controllers\backend\FloorController::class, 'index'])->name('floor.index');       // Get listing of the floor list

// PDF Report Monthly
Route::get('/report', [App\Http\Controllers\backend\PDFReportController::class, 'index'])->name('report.index');

// Product Report Monthly
Route::get('/product-report/{id}', [App\Http\Controllers\backend\ProductReportController::class, 'index'])->name('product-report.index');