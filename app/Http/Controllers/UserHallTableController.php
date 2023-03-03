<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\SalePoint;
use App\Models\Table;
use App\Models\User;
use App\Models\UserHallTable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserHallTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $waiters = User::where('role','waiter')->get();
        $halls = Hall::all();
        if ($req->ajax()) {
            return response( getAjaxResponse('frontend.users.waiterWorkArea',['waiters'=>$waiters,'halls'=>$halls]));
        }
        return view('frontend.users.waiterWorkArea',compact(['waiters','halls']));
    }
    public function getWaiterHallTables(Request $req)
    {
        $information = UserHallTable::where('user_id',$req->userId)->first();
        return response()->json(["information"=>$information]);
    }
    public function setWaiterHallTables(Request $req)
    {
        $waiter = UserHallTable::where('user_id',$req->user_id)->first();
        $waiter->hall = $req->hallToSet;
        $waiter->tables = $req->tablesToSet;
        $waiter->save();
        return response()->json(["message"=>"تم تهيئة النادل بنجاح"]);
    }
    public function getWaitersByDate(Request $req)
    {
        $date= strtolower($req->filterDate);
        switch ($date) {
            case 'hour':
                isset($req->forSeller) ?
                $sellers = User::where('role' , 'salePoint')->where('created_at' ,'>=' ,  Carbon::now()->subHour()->toDateString())->get()
                :
                $waiters = User::where('role' , 'waiter')->where('created_at' ,'>=' ,  Carbon::now()->subHour()->toDateString())->get() ;
                break;
            case 'day':
                isset($req->forSeller) ?
                $sellers = User::where('role' , 'salePoint')->where('created_at' ,'>=' ,  Carbon::now()->subDay()->toDateString())->get()
                :
                $waiters = User::where('role' , 'waiter')->where('created_at' ,'>=' ,  Carbon::now()->subDay()->toDateString())->get();
                break;
            case 'week':
                isset($req->forSeller) ?
                $sellers = User::where('role' , 'salePoint')->where('created_at' ,'>=' ,  Carbon::now()->subWeek()->toDateString())->get()
                :
                $waiters = User::where('role' , 'waiter')->where('created_at' ,'>=' ,  Carbon::now()->subWeek()->toDateString())->get();
            break;
            case 'month':
                isset($req->forSeller) ?
                $sellers = User::where('role' , 'salePoint')->where('created_at' ,'>=' ,  Carbon::now()->subMonth()->toDateString())->get()
                :
                $waiters = User::where('role' , 'waiter')->where('created_at' ,'>=' ,  Carbon::now()->subMonth()->toDateString())->get();
            break;
            case 'year':
                isset($req->forSeller) ?
                $sellers = User::where('role' , 'salePoint')->where('created_at' ,'>=' ,  Carbon::now()->subYear()->toDateString())->get()
                :
                $waiters = User::where('role' , 'waiter')->where('created_at' ,'>=' ,  Carbon::now()->subYear()->toDateString())->get();
            break;
            default:
                isset($req->forSeller) ?
                $sellers = User::where('role' , 'salePoint')->get()
                :
                $waiters = User::where('role' , 'waiter')->get();
            break;
        }
        if (isset($req->forSeller) )
            return response()->json(['sellers'=>$sellers]);
        else
            return response()->json(['waiters'=>$waiters]);
    }
    public function getWaitersByName(Request $req)
    {
        if (isset($req->forAllUsers))
        {
            if (!$req->filterName) {
                return response()->json(['users'=>User::all()]);
            }
            else{

                return response()->json(['users'=>User::where('name'  ,  $req->filterName)->get()]);
            }
        }
        else
        { 
            isset($req->forSeller) ? 
            $sellers = User::where('role' , 'salePoint')->where('name'  ,  $req->filterName)->get()
            :
            $waiters = User::where('role' , 'waiter')->where('name'  ,  $req->filterName)->get();
            if (isset($req->forSeller)) 
                return response()->json(['sellers'=>$sellers]);
            else
                return response()->json(['waiters'=>$waiters]);
        }
    }
    public function getTablesByWaitersNumber(Request $req)
    {
        $result = [];
        $userHallTables = UserHallTable::select('tables')->pluck('tables')->toArray();
        $tables = Table::where('hallNumber' , $req->hallNumber)->get();
        foreach ($tables as  $table) {
            $numberOfwaiter = 0;
            for ($i=0; $i < count($userHallTables); $i++) { 
                if (in_array((string) $table->tableNumber,$userHallTables[$i])) {
                    $numberOfwaiter++;
                }
                if ($numberOfwaiter >= $req->waiterNumber) {
                    array_push($result,$table);
                    break;
                }
            }
        }
        return response()->json(['tables'=>$result]);
    }
    public function index2(Request $req)
    {
        $sellers = User::where('role','salePoint')->get();
        $salePoints = SalePoint::all();
        if ($req->ajax()) {
            return response( getAjaxResponse('frontend.users.sellerWorkArea',['sellers'=>$sellers,'salePoints'=>$salePoints]));
        }
        return view('frontend.users.sellerWorkArea',compact(['sellers','salePoints']));
    }



}
