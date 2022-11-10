<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Resturant;
use App\Http\Middleware\UnAuth;
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
    $object = (object) [
        'hallNumber' => 1,
        'hallName' => "الصالة الاولى",
        'active' => 1,
        'maxCapacity' => 50,
      ];
    //   addSetHallInRedis($object);
    // deleteHallInRedis($object->hallNumber);
    //   dd(Redis::hgetall('hall:' . 1 .':table:'. 1));
      dd((getHallTablesFromRedis(3))[0]->active);
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
// dd( Redis::hget('client:2','id'));

});
Route::get('boards/{hallNumber}', function ($hallNumber)
{
    $tables = getHallTablesFromRedis($hallNumber);
    return response()->json([
        'tables' => $tables
    ]);
});

Route::get('/dev', function (Request $req) {
    if ($req->ajax()) {
        $sections = view('boards')->renderSections();
        return response(["extendedScripts"=>$sections["scripts"] , "content"=>$sections["content"],"extendedStyles"=>$sections["styles"]]);
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
    Route::get('/show-new-hall-form', [Resturant::class,'showFormNewHall']);
    Route::post('/add-new-hall', [Resturant::class,'addNewHall']);

});
Route::middleware('unauthenticate')->group(function () {
    Route::get('/show-registeration', [AuthController::class,'showRegister']);
    Route::post('/register', [AuthController::class,'register']);
    Route::get('/show-login', [AuthController::class,'showLogin']);
    Route::post('/login', [AuthController::class,'login']);
});






