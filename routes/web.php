<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Resturant;
use App\Http\Middleware\UnAuth;
use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


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
//     }
// )->where('any', '.*');
Route::get('/vue/{vue_capture?}', function () {
    return view('boards');
   })->where('vue_capture', '[\/\w\.-]*');

Route::get('/test', function () {
    // $value =55;
    // dd($value <= Hall::where('hallNumber', 1)->pluck('maxCapacity')->first());
    // return $value == Hall::where('hallNumber', 1)->pluck('maxCapacity')->first();
    // $object = (object) [
    //     'tableNumber' => 10,
    //     'hallNumber' => 1,
    //     'active' => 1,
    //     'maxCapacity' => 50,
    //   ];
    session("s",'s');
    return "ok";
    //   $tableInfo=Redis::hgetall('hall:' . 1 .':table:'. 2);
    //   dd($tableInfo);
    //  dd(getHallsFromRedis());
    // Redis::hmset('hall:1' . ':tables:1', [
    //     'tableNumber' =>  999,
    //     'hallNumber' =>  1,
    //     'active' =>  1,
    //     'maxCapacity' => 1
    // ]);
// dd(Redis::hgetall('hall:1'.':table:1'));


    // addSetTableInRedis(1,$object);
    // dd(getOrderRange(1));
// dd(Redis::hgetall('hall:1'.':table:4'));
// setTableOrder($object,'');
// setTableOrder($object,'',"ddddd");
// deleteTableFromRedis(2,2);
    //   addSetHallInRedis($object);
    // deleteHallInRedis($object->hallNumber);
    //   dd(Redis::hgetall('hall:' . 1 .':table:'. 1));
    //   dd((getHallTablesFromRedis(3))[0]->active);
    // Redis::hmset('client:' . 1, [
    //     'id' => 1,
    //     'name' => 'zoalfikar alsaad',
    //     'email' => 'zzzzz',
    //     'address' => 'salhab'
    //     ]);
    //     Redis::hmset('client:' . 2, [
    //         'id' => 2,
    //         'name' => 'zzzzz',
    //         'email' => 'zzzzz',
    //         'address' => 'salhab'
    //         ]);
    //         $keys = Redis::keys('client:*');
    //         // dd(  Redis::hgetall("client:2"));

    //         // dd( $keys['1']);
    //         foreach ($keys as $key) {
    //             $key=str_replace('laravel_database_','',$key);
    //             // dd(  Redis::hgetall($key));
    //             $stored = Redis::hgetall($key);
    //             // $serialized = serialize($stored);
    //             // $myNewArray = unserialize($serialized);
    //             //  $stored =json_encode($stored);
    //             ($stored["id"]);
    //             // $stored =json_decode($stored);
    //             //  echo $stored->id;
    //             //  echo $stored->name;
    //             //  echo $stored->email;
    //             // echo $stored['name'];
    //         }
// Redis::hmset('hall:1'.':table:1', "order", 66);


});

// Route::get('/show-new-section-form', function ($hallNumber)
// {
//     $tables = getHallTablesFromRedis($hallNumber);
//     return response()->json([
//         'tables' => $tables
//     ]);
// });
Route::get('boards/{hallNumber}', function ($hallNumber)
{
    $tables = getHallTables($hallNumber);
    return response()->json([
        'tables' => $tables
    ]);
});
Route::get('halls', function ()
{
    $halls = getHalls();
    return response()->json([
        'halls' => $halls
    ]);
});
Route::get('/dev', function (Request $req) {
    if ($req->ajax()) {
        return response( getAjaxResponse('boards',[]));
    }
    return view('boards');

});


Route::middleware('authenticate')->group(function () {
    Route::get('/logout', [AuthController::class,'logout']);
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
});
Route::middleware('unauthenticate')->group(function () {
    Route::get('/show-registeration', [AuthController::class,'showRegister']);
    Route::post('/register', [AuthController::class,'register']);
    Route::get('/show-login', [AuthController::class,'showLogin']);
    Route::post('/login', [AuthController::class,'login']);
});






