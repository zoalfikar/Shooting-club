<?php

use App\Events\menuSectionAdded;
use App\Events\menuSectionDeleted;
use App\Events\menuSectionItemsUpdated;
use App\Events\menuSectionUpdated;
use App\Events\orderAdded;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Menu;
use App\Http\Controllers\Resturant;
use App\Http\Controllers\SalePointController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserHallTableController;
use App\Http\Middleware\UnAuth;
use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Http\Middleware\Acountant;
use App\Http\Middleware\Waiter;
use App\Models\MenuItem;
use App\Models\MenuSection;
use App\Models\salePointsBills;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserHallTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Scalar\MagicConst\Method;
use Symfony\Component\HttpFoundation\Response;

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

    $input = [
        'sale_point' => 2,
        'order' => [
            '1' => 'One',
            '2' => 3,
            '3' => 'Three'
        ],
        'sale_point_acountant'=>1,
        'acountant_name'=>'jkjk'
    ];

    $item = salePointsBills::create($input);

    dd($item->order);




    Redis::set('salePointSellertest:'. 1 .':salPoint:' , 1);
    Redis::set('salePointSellertest:'. 2 .':salPoint:' , 1);
    Redis::set('salePointSellertest:'. 3 .':salPoint:' , 1);
    Redis::set('salePointSellertest:'. 5 .':salPoint:' , 12);

    // Redis::hdel('salePointSellertest:*:salPoint:'. 1);
    $ks = Redis::keys('salePointSellertest:*:salPoint:');

    for ($i=0; $i <  count($ks) ; $i++) {
        if (Redis::get(str_replace('laravel_database_' ,'' , $ks[$i])) == 1) {
            Redis::del(str_replace('laravel_database_' ,'' , $ks[$i]));
        }
    }


    dd(Redis::keys('salePointSellertest:*'));

    // dd(Redis::get('salePointSellertest:'. 1 .':salPoint:' ),Redis::get('salePointSellertest:'. 2 .':salPoint:' ),Redis::get('salePointSellertest:'. 3 .':salPoint:' ));


    // event(new menuSectionItemsUpdated((object)["id"=>200000 ,"options"=>'both',"name"=>"dd"],[]));

    // event(new menuSectionDeleted((object)["id"=>200000 ,"options"=>'both',"name"=>"dd"]));
    // setSalePointOrder(2, (object)["id"=>1 ,"options"=>'both',"name"=>"dd"] );
    // setSalePointSeller(3,3);
    // setSalePointSeller(4,3);
    // setSalePointSeller(5,3);
    // setSalePointSeller(13,3);
    // setSalePointSeller(1111,3);
    // setSalePointSeller(3,3);
    // setSalePointSeller(3,3);
    // setSalePointSeller(3,3);
    // setSalePointSeller(4,3);
    // dd(getAllSalePointSellers(3));
});



Route::middleware('authenticate')->group(function () {
    Route::get('/vue/{vue_capture?}', function () {
        return view('boards');
    })->where('vue_capture', '[\/\w\.-]*');

    Route::get('/role', function () {
        return response()->json(["role"=>Auth::user()->role]);
    })->where('vue_capture', '[\/\w\.-]*');
    Route::get('/logout', [AuthController::class,'logout']);




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
    Route::middleware('acountant')->group(function () {
        Route::get('/', function () {
            return view('appLayouts.app');
        });

        //setting
        Route::get('/setting', function (Request $req) {
            if ($req->ajax()) {
                return getAjaxResponse('frontend.setting' , []);
            }
            return view('frontend.setting');

        });
        Route::get('/get-facility-name', function(){
            $name=(Setting::where('name','facility')->first())->value;
            return response()->json(["name"=>$name]) ;
        });
        Route::post('/save-facility-name', function(Request $req){
            $facilityName= Setting::where('name','facility')->first();
            $facilityName->value = $req->newName;
            $facilityName->update();
            return response()->json(["done"=>true]) ;
        });
        Route::post('/save-logo', function(Request $req){
            if ($req->hasFile('logo')) {
                $file=  $req->file('logo');
                $path= 'images/logo.png';
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file->move(public_path('images'),'logo.png');
                return response()->json(["done"=>true]) ;
            }
            return response()->json(["done"=>true]) ;
        });
        //sale-point  /get-salePoint-data
        Route::get('/show-new-sale-point-form', [SalePointController::class ,'newSalePoint']);
        Route::post('/add-new-sale-point-form', [SalePointController::class ,'addSalePoint']);
        Route::get('/show-edit-sale-point-form', [SalePointController::class ,'editSalePoint']);
        Route::post('/update-sale-point', [SalePointController::class ,'updateSalePoint']);
        Route::post('/delete-sale-point', [SalePointController::class ,'deleteSalePoint']);
        Route::get('/all-sale-points', [SalePointController::class ,'getSalePonits']);
        // resturant
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
        Route::get('/show-waiter-area-form', [UserHallTableController::class,'index']);
        Route::get('/show-seller-area-form', [UserHallTableController::class,'index2']);
        Route::get('/show-hall-acountant-area-form', [UserHallTableController::class,'index3']);
        Route::post('/set-user-hall-tables', [UserHallTableController::class,'setWaiterHallTables']);
        Route::get('/get-waiters-by-date', [UserHallTableController::class,'getWaitersByDate']);
        Route::get('/get-waiters-by-name', [UserHallTableController::class,'getWaitersByName']);
        Route::get('/get-tables-by-waiters-number', [UserHallTableController::class,'getTablesByWaitersNumber']);
        Route::get('get-all-sale-point-sellers/{id}', [SalePointController::class ,'getAllSalePointSellers']);
        Route::get('get-all-hall-acountants/{id}', [SalePointController::class ,'getAllHallAcountants']);
        Route::post('set-sale-point-seller', [SalePointController::class ,'setSalePointSeller']);
        Route::post('set-hall-acountant', [SalePointController::class ,'setHallAcountant']);

    });

    Route::withoutMiddleware('waiter')->group(function () {
        Route::get('/sale-points', function (Request $req) {
            if ($req->ajax()) {
                return getAjaxResponse('frontend.salePoint.index' , []);
            }
            return view('frontend.salePoint.index');

        });
        Route::get('/get-sale-point-', [SalePointController::class ,'getSalePonit']);
        Route::get('/get-salePoint-data/{id}', [SalePointController::class ,'getSalePointData']);
        Route::get('/get-sale-point-menu', [SalePointController::class ,'getSalePonitMenu']);
        Route::get('/sale-point-orders', [SalePointController::class ,'getOrders']);
        Route::post('/set-sale-point-order/{id}', [SalePointController::class ,'setOrder']);
        Route::post('/delete-sale-point-order', [SalePointController::class ,'deleteOrder']);
        Route::post('set-sale-point-settings/{id}', [SalePointController::class ,'setSettings']);
        Route::post('/delete-paid-sp-orders/{id}', [SalePointController::class ,'deletePaidOrders']);
        Route::get('/get-sale-point/{id}', [SalePointController::class ,'getSalePonit']);
        Route::get('/get-seller-sale-point', [SalePointController::class ,'getSellerSalePoint']);

    });
    Route::withoutMiddleware('salePoint')->group(function () {
        Route::get('/resturant', function (Request $req) {
            if ($req->ajax()) {
                return response( getAjaxResponse('boards',[]));
            }
            return view('boards');
        });
        Route::get('/get-hall-acountant', [SalePointController::class ,'getHallAcountant']);
        Route::get('/get-waiter-hall-tables', [UserHallTableController::class,'getWaiterHallTables']);
        Route::post('/set-table-info/{hall}/{table}', [Resturant::class,'setInfo']);
        Route::post('/set-table-status/{hall}/{table}', [Resturant::class,'setStatus']);
        Route::post('/set-table-orders/{hall}/{table}', [Resturant::class,'setOrders']);
    });
    Route::get('/get-menu-items', [Menu::class,'getMenuItems']);
});
Route::middleware('unauthenticate')->group(function () {
    Route::get('/show-login', [AuthController::class,'showLogin']);
    Route::post('/login', [AuthController::class,'login']);
});






