<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Resturant;
use App\Http\Middleware\UnAuth;
use Illuminate\Http\Request;

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
// Route::get('/{any?}',
//     function () {
//         return view('appLayouts.app');
//     }
// )->where('any', '.*');
Route::get('/test', function () {
 return view('test');
});
Route::get('/dev', function (Request $req) {
    if ($req->ajax()) {
        $sections = view('boards')->renderSections();
        return response(["extendedScripts"=>$sections["scripts"] , "content"=>$sections["content"]]);
    }
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






