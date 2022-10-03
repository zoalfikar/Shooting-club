<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Resturant;
use App\Http\Middleware\UnAuth;

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
Route::get('/test', function () {

});
Route::get('/dev', function () {
    return view('boards');

});


Route::middleware('authenticate')->group(function () {
    Route::get('/logout', [AuthController::class,'logout']);
    Route::get('/', function () {
        return view('appLayouts.app');

    });
    Route::get('/show-new-table-form', [Resturant::class,'showFormNewTable']);
    Route::post('/add-new-table', [Resturant::class,'addNewTable']);

});
Route::middleware('unauthenticate')->group(function () {
    Route::get('/show-registeration', [AuthController::class,'showRegister']);
    Route::post('/register', [AuthController::class,'register']);
    Route::get('/show-login', [AuthController::class,'showLogin']);
    Route::post('/login', [AuthController::class,'login']);
});






