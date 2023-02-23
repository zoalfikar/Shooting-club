<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Menu;
use App\Http\Controllers\Resturant;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UnAuth;
use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Http\Middleware\Acountant;
use App\Http\Middleware\Waiter;

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
    
    
    setTableOrders(1,1,'');
    setTableOrders(1,2,'');
    setTableOrders(1,3,'');
    setTableOrders(1,5,'');
    setTableOrders(1,4,'');
    setTableOrders(1,6,'');
    
});



Route::middleware('authenticate')->group(function () {
    Route::get('/vue/{vue_capture?}', function () {
        return view('boards');
    })->where('vue_capture', '[\/\w\.-]*');
    Route::get('/logout', [AuthController::class,'logout']);
    Route::get('/resturant', function (Request $req) {
        if ($req->ajax()) {
            return response( getAjaxResponse('boards',[]));
        }
        return view('boards');
    });
    
    
    // tables
    Route::get('halls', function ()
    {
        $halls = getHalls();
        return response()->json([
            'halls' => $halls
        ]);
    });
    Route::get('boards/{hallNumber}', function ($hallNumber)
    {
        $tables = getHallTables($hallNumber);
        return response()->json([
            'tables' => $tables
        ]);
    });
    Route::middleware(['acountant'])->group(function () {
        Route::get('/', function () {
            return view('appLayouts.app');
            
        });
        Route::get('/show-new-table-form', [Resturant::class,'showFormNewTable']);
        Route::get('/show-update-tables-form', [Resturant::class,'showFormUpdateTables']);
        Route::post('/add-new-table', [Resturant::class,'addNewTable']);
        Route::post('/add-many-new-tables', [Resturant::class,'addManyNewTable']);
        Route::post('/update-tables', [Resturant::class,'updateTables']);
        Route::post('/delete-tables', [Resturant::class,'deleteTables']);
        Route::get('/show-new-hall-form', [Resturant::class,'showFormNewHall']);
        Route::post('/add-new-hall', [Resturant::class,'addNewHall']);
        Route::get('/show-update-hall-form', [Resturant::class,'showFormUpdteaHall']);
        Route::get('/get-hall-data/{hallNumber}', [Resturant::class,'getHallData']);
        Route::post('/update-hall', [Resturant::class,'updateHall']);
        Route::post('/delete-hall', [Resturant::class,'deleteHall']);
        ///// sections
        Route::get('/show-new-section-form', [Menu::class,'showFormNewSection']);
        Route::post('/add-new-menu-section', [Menu::class,'addNewMenuSection']);
        Route::get('/show-edit-sections-form', [Menu::class,'showFormEditSections']);
        Route::get('/get-menu-section', [Menu::class,'getMenuSection']);
        Route::post('/update-menu-section', [Menu::class,'updateMenuSection']);
        Route::post('/delete-menu-section', [Menu::class,'deleteMenuSection']);
        Route::get('/show-new-item-form', [Menu::class,'showFormNewItem']);
        Route::post('/add-new-menu-item', [Menu::class,'addNewMenuitem']);
        Route::post('/add-new-menu-items', [Menu::class,'addNewMenuitems']);
        Route::get('/show-edit-items-form', [Menu::class,'showFormEditItems']);
        Route::post('/update-menu-item', [Menu::class,'updateMenuItem']);
        Route::post('/delete-menu-item', [Menu::class,'deleteMenuItem']);
        Route::match(['get', 'post'], '/users/all', [UserController::class ,'editUsers']);
        Route::resource('users', UserController::class);
    });
    Route::post('/set-table-info/{hall}/{table}', [Resturant::class,'setInfo']);
    Route::post('/set-table-status/{hall}/{table}', [Resturant::class,'setStatus']);
    Route::post('/set-table-orders/{hall}/{table}', [Resturant::class,'setOrders']);
    Route::get('/get-menu-items', [Menu::class,'getMenuItems']);
});
Route::middleware('unauthenticate')->group(function () {
    Route::get('/show-registeration', [AuthController::class,'showRegister']);
    Route::post('/register', [AuthController::class,'register']);
    Route::get('/show-login', [AuthController::class,'showLogin']);
    Route::post('/login', [AuthController::class,'login']);
});






