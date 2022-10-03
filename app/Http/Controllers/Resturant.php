<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Models\Hall;
use App\Models\Table;
use Illuminate\Http\Request;

class Resturant extends Controller
{
    public function showFormNewTable($hallNumber = 1 , Request $req)
    {
        $TableNumber = getAvailableTableNumber($hallNumber);
        $hallNumbers = Hall::all()->pluck('hallNumber')->toArray();

        if ($req->expectsJson()) {
            $TableNumber = getAvailableTableNumber($req['hallNumber']);
            return response(["TableNumber"=>$TableNumber]);
        }

        return view('frontend.resturant.tables.newTable',compact('TableNumber','hallNumbers'));
    }
    public function addNewTable(TableRequest $req)
    {
        Table::create($req->only(['tableNumber','hallNumber','maxCapacity','active']));
        return redirect()->back();
    }
}
