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

        if (isset($req['hallNumberChanged'])) {
           return $this->getTableNumber($req['hallNumber']);
        }
        if ($req->ajax()) {
            $sections = view('frontend.resturant.tables.newTable',compact('TableNumber','hallNumbers'))->renderSections();
            return response(["extendedScripts"=>$sections["scripts"] , "content"=>$sections["content"]]);
        }
        return view('frontend.resturant.tables.newTable',compact('TableNumber','hallNumbers'));
    }
    public function addNewTable(TableRequest $req)
    {
        Table::create($req->only(['tableNumber','hallNumber','maxCapacity','active']));
        return redirect()->back();
    }

    protected function getTableNumber($hallNumber)
    {
        $TableNumber = getAvailableTableNumber($hallNumber);
        return response(["TableNumber"=>$TableNumber]);
    }
}
