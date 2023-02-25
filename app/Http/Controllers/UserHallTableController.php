<?php

namespace App\Http\Controllers;

use App\Models\Hall;
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
                $waiters = User::where('role' , 'waiter')->where('created_at' ,'>=' ,  Carbon::now()->subHour()->toDateString())->get();
                break;
            case 'day':
                $waiters = User::where('role' , 'waiter')->where('created_at' ,'>=' ,  Carbon::now()->subDay()->toDateString())->get();
                break;
            case 'week':
                $waiters = User::where('role' , 'waiter')->where('created_at' ,'>=' ,  Carbon::now()->subWeek()->toDateString())->get();
            break;
            case 'month':
                $waiters = User::where('role' , 'waiter')->where('created_at' ,'>=' ,  Carbon::now()->subMonth()->toDateString())->get();
            break;
            case 'year':
                $waiters = User::where('role' , 'waiter')->where('created_at' ,'>=' ,  Carbon::now()->subYear()->toDateString())->get();
            break;
            default:
                $waiters = User::where('role' , 'waiter')->get();
            break;
        }
        return response()->json(['waiters'=>$waiters]);
    }
    public function getWaitersByName(Request $req)
    {
        $waiters = User::where('role' , 'waiter')->where('name'  ,  $req->filterName)->get();
        return response()->json(['waiters'=>$waiters]);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserHallTable  $userHallTable
     * @return \Illuminate\Http\Response
     */
    public function show(UserHallTable $userHallTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserHallTable  $userHallTable
     * @return \Illuminate\Http\Response
     */
    public function edit(UserHallTable $userHallTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserHallTable  $userHallTable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserHallTable $userHallTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserHallTable  $userHallTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserHallTable $userHallTable)
    {
        //
    }
}
