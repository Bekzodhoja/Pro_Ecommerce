<?php

use App\Http\Controllers\AdminCantroller;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// home
Route::get('/redirect', [HomeController::class,'redirect'])->middleware('auth','verified');
Route::get('/product_details/{id}', [HomeController::class, 'product_details']);
Route::post('/add_cart/{id}',[HomeController::class,'add_cart']);
Route::get('/show_cart',[HomeController::class,'show_cart']);
Route::get('/remove_cart/{id}',[HomeController::class,'remove_cart']);
Route::get('/cash_order',[HomeController::class,'cash_order']);
Route::get('/stripe/{totalprice}',[HomeController::class,'stripe']);

Route::post('stripe/{totalprice}',[HomeController::class,'stripePost'])->name('stripe.post');



// admin
Route::get('/view_category', [AdminCantroller::class,'view_category']);
Route::post('/add_category', [AdminCantroller::class, 'add_category']);
Route::get('/delete_category/{id}', [AdminCantroller::class, 'delete_category']);
Route::get('/view_product', [AdminCantroller::class, 'view_product']);
Route::post('/add_product', [AdminCantroller::class, 'add_product']);
Route::get('/show_product', [AdminCantroller::class, 'show_product']);
Route::get('/delete_product/{id}', [AdminCantroller::class, 'delete_product']);
Route::get('/update_product/{id}', [AdminCantroller::class, 'update_product']);
Route::post('/update_product_confirm/{id}', [AdminCantroller::class, 'update_product_confirm']);
Route::get('/order',[AdminCantroller::class,'order']);
Route::get('/delivered/{id}',[AdminCantroller::class,'delivered']);
Route::get('/print_pdf/{id}',[AdminCantroller::class,'print_pdf']);
