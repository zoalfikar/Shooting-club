<?php

namespace App\Http\Controllers;

use App\Http\Requests\HallRequest;
use App\Http\Requests\TableRequest;
use App\Models\Hall;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Resturant extends Controller
{
    public function showFormNewTable($hallNumber = 1 , Request $req)
    {
        $TableNumber = getAvailableTableNumber($hallNumber);
        $hallNumbers = Hall::all()->pluck('hallNumber')->toArray();

        if (isset($req['hallNumberChanged'])) {
           return $this->getTableNumber($req['hallNumber']);
        }
        if ($req->ajax()) {
            return response( getAjaxResponse('frontend.resturant.tables.newTable',['TableNumber'=>$TableNumber,'hallNumbers'=>$hallNumbers]));
        }
        return view('frontend.resturant.tables.newTable',compact('TableNumber','hallNumbers'));
    }
    public function addNewTable(TableRequest $req)
    {
        DB::beginTransaction();
        try {
            $newTable =Table::create($req->only(['tableNumber','hallNumber','maxCapacity','active']));
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        addSetTableInRedis($newTable->hallNumber,$newTable);
        return redirect()->back();
    }

    protected function getTableNumber($hallNumber)
    {
        $TableNumber = getAvailableTableNumber($hallNumber);
        return response(["TableNumber"=>$TableNumber]);
    }
    public function showFormNewHall($hallNumber = 1 , Request $req)
    {
        $hallNumber = getAvailableHallNumber();
        if ($req->expectsJson()) {
            return response( getAjaxResponse('frontend.resturant.halls.newHall',['hallNumber'=>$hallNumber]));
        }
        return view('frontend.resturant.halls.newHall',compact('hallNumber'));
    }
    public function addNewHall(HallRequest $req)
    {
        DB::beginTransaction();
        try {
            $newHall = Hall::create($req->only(['hallNumber','hallName','maxCapacity','active']));
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        addSetHallInRedis($newHall);
        // if ($req->ajax()) {
        //     return response()->json();
        // }
        return redirect()->back();
    }
}
