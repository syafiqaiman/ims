<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Company;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('user_list', [App\Http\Controllers\backend\UsermanagementController::class,'UserList'])->name('user.index');
Route::get('/edit_user/{id}', [App\Http\Controllers\backend\UsermanagementController::class,'UserEdit']);
Route::post('/update_user/{id}', [App\Http\Controllers\backend\UsermanagementController::class,'UserUpdate']);
Route::get('/delete_user/{id}', [App\Http\Controllers\backend\UsermanagementController::class,'UserDelete']);

Route::get('list_product', [App\Http\Controllers\backend\ProductController::class,'ProductList'])->name('product.index');
Route::get('/add_product',[App\Http\Controllers\backend\ProductController::class,'ProductAdd'])->name('productadd');
Route::post('/insert_product', [App\Http\Controllers\backend\ProductController::class,'ProductInsert']);
Route::get('/edit_product/{id}', [App\Http\Controllers\backend\ProductController::class,'ProductEdit']);
Route::post('/update_product/{id}', [App\Http\Controllers\backend\ProductController::class,'ProductUpdate']);
Route::get('/delete_product/{id}', [App\Http\Controllers\backend\ProductController::class,'ProductDelete']);

Route::get('/company/getUsers', function (Request $request) {
    $company = Company::find($request->company_id);
    $users = $company ? $company->getUsers() : [];
    return response()->json($users);
})->name('company.getUsers');


Route::get('quantity_list', [App\Http\Controllers\backend\QuantityController::class, 'ProductQuantityList'])->name('quantity.index');


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


    Route::get('/racks', [App\Http\Controllers\backend\RackController::class, 'RackList'])->name('rack.list'); 
    //Route::group(['middleware' => ['auth']], function () {


