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
use App\Http\Controllers\backend\FloorController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\InvoiceController;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\backend\ReturnStockController;
use App\Http\Controllers\backend\ReportController;
use App\Http\Controllers\backend\ProductReportController;




Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// User management
Route::get('/user_list', [UsermanagementController::class, 'UserList'])->name('user.index');
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
Route::get('/mystatus_new_product', [ProductController::class, 'showAddRequestStatus'])->name('addnewproductcust');
Route::get('/mystatus_new_product/{id}', [ProductController::class, 'CancelNewAddRequestCust'])->name('CustRemovenewproduct');
Route::post('/check_new_product/{id}/approve', [ProductController::class, 'approveProductRequest'])->name('approveProductRequest');
Route::get('/check_new_product/{id}/reject', [ProductController::class, 'rejectProductRequest'])->name('rejectProductRequest');
Route::get('/cancel-reorder-request/{id}', [ProductController::class, 'CancelReorderRequestCust'])->name('cancelReorderRequest');

// Delivery
Route::get('/delivery_form', [DeliveryController::class, 'deliveryFormCust'])->name('deliveryform');
Route::post('/delivery/form_sent', [DeliveryController::class, 'storeDelivery'])->name('delivery.submit');
Route::get('/delivery_order_list', [DeliveryController::class, 'deliveryOrderList'])->name('deliveryOrderList');
Route::post('/assign-task-do', [DeliveryController::class, 'assignTaskDO'])->name('delivery.assignPicker');

//Return Stock
Route::get('return-stock-form', [ReturnStockController::class, 'CustReturnStockForm'])->name('returnstockform');
Route::post('return-stock-submit', [ReturnStockController::class, 'storeReturnStock'])->name('return-stock.store');
Route::get('return-stock-status', [ReturnStockController::class, 'returnStockList'])->name('returnstockstatus');
Route::get('receive-return-stock', [ReturnStockController::class, 'returnStockListAdmin'])->name('receivereturnstock');
Route::post('assign-task-ro', [ReturnStockController::class, 'assignTask'])->name('assign.RO.task');

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
Route::get('history',  [PickerController::class, 'history'])->name('picker.history');
Route::get('/picker_status',  [PickerController::class, 'AdminView'])->name('picker.viewstatus');
Route::post('/rerack-product/{pickerId}', [PickerController::class, 'rerackProductAdmin'])->name('rerackProductAdmin');
Route::post('/rerack-product-picker/{pickerId}', [PickerController::class, 'rerackProductPicker'])->name('rerackProductPicker');
Route::post('/dispose-product/{pickerId}', [PickerController::class, 'disposeProductAdmin'])->name('disposeProductAdmin');
Route::post('/dispose-product-picker/{pickerId}', [PickerController::class, 'disposeProductPicker'])->name('disposeProductPicker');
Route::get('/picker-tasks-count', [SidebarController::class, 'getCountPickerTasks'])->name('picker_tasks_count');
Route::get('/picker-return-count', [SidebarController::class, 'getCountPickerReturn'])->name('picker_return_count');
Route::get('/return-order-task', [PickerController::class, 'returnOrderTask'])->name('return_stock_task');
Route::post('/refurbish-product-task/{pickerId}', [PickerController::class, 'refurbishedProduct'])->name('refurbishedProduct');


// Cart
Route::get('cart_index', [CartController::class, 'ItemList'])->name('cartquantity.index');
Route::get('/cart_view', [CartController::class, 'ItemList'])->name('quantitycart');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'cartRemove'])->name('cart.remove');
Route::post('/assign', [CartController::class, 'assign'])->name('assign.index');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart_clear', [CartController::class, 'clear'])->name('cart.clear');

// Rack
Route::get('/racks', [RackController::class, 'RackList'])->name('rack.list');

// Floor
Route::get('/floors', [FloorController::class, 'index'])->name('floor.list');

// Orders
Route::get('/orders/{companyId}', [OrderController::class, 'orderList'])->name('orderList');
Route::get('/invoice/{order_no}', [OrderController::class, 'generateInvoice'])->name('backend.invoice.generate');
Route::get('/invoice/{order_no}', [OrderController::class, 'show'])->name('orderShow');

// Invoice
Route::get('invoice/{id}/download', [InvoiceController::class, 'download'])->name('invoice.download');

// PDF Report Monthly
Route::get('/report', [ReportController::class, 'showReport'])->name('showReport');
Route::get('/report-create', [ReportController::class, 'generateReport'])->name('generateReport');

// Product Report Monthly
Route::get('/product-report/{id}', [ProductReportController::class, 'index'])->name('product-report.index');

// Weekly Report for admin
Route::get('weekly-report', [ReportController::class, 'showWeeklyReport'])->name('showWeeklyReport');
Route::get('generate-weekly-report', [ReportController::class, 'generateWeeklyReports'])->name('generateWeeklyReports');
Route::get('weekly-report', [ReportController::class, 'showWeeklyReport'])->name('showWeeklyReport');
Route::get('generate-weekly-report', [ReportController::class, 'generateWeeklyReports'])->name('generateWeeklyReports');