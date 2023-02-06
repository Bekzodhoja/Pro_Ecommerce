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
Route::get('/redirect', [HomeController::class,'redirect']);




// admin
Route::get('/view_category', [AdminCantroller::class,'view_category']);
Route::post('add_category', [AdminCantroller::class, 'add_category']);
Route::get('/delete_category/{id}', [AdminCantroller::class, 'delete_category']);