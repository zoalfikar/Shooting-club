<?php

namespace App\Http\Controllers;

use App\Models\MenuSection;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Http\Requests\MenuItemRequest;
use Illuminate\Support\Facades\Validator;

class Menu extends Controller
{
    public function showFormNewSection(Request $req)
    {
        if ($req->ajax()) {
            return response( getAjaxResponse('frontend.resturant.menu.menuSections.newMenuSection',[]));
        }
        return view('frontend.resturant.menu.menuSections.newMenuSection');
    }
    public function addNewMenuSection(Request $req)
    {
        $newSection = MenuSection::create($req->only(["name","description","active","options"]));
        if ($req->ajax()) {
            return response()->json(["message"=>"تم إدخال نوع جديد بنجاح"]);
        }
        redirect()->back()->with("message","تم إدخال نوع جديد بنجاح");
    }
    public function showFormNewItem(Request $req)
    {
        $sections = MenuSection::all();
        if ($req->ajax()) {
            return response( getAjaxResponse('frontend.resturant.menu.menuItems.newMenuItem',["sections"=>$sections]));
        }
        return view('frontend.resturant.menu.menuItems.newMenuItem' , compact("sections"));
    }
    public function addNewMenuitem(MenuItemRequest $req)
    {
        $vars = [];
        if ($req->input("pace")) {
            $vars = $req->only(["title","description","unit","active","section","price","pace","fragmentable"]);
        }
        else {
            $vars = $req->only(["title","description","unit","active","section","price","fragmentable"]);
        }
        $newMenuItem = MenuItem::create($vars);
        if ($req->ajax()) {
            return response()->json(["message"=>"تم إدخال مادة جديدة الى القائمة بنجاح"]);
        }
        redirect()->back()->with("message","تم إدخال مادة جديدة الى القائمة بنجاح");
    }

    public function addNewMenuitems(Request $req)
    {
        $allItems = $req->items;
        $validator = Validator::make($req->only(['items']), [
            'items' => ['array', 'required'],
        ]);
        if($validator->fails()){
            return response()->json(["errors"=> $validator->messages()], 422);
        }
        $rules=[
                'title' => ['required'],
                'section' => ['required','exists:menu_sections,id'],
                'unit' => ['required'],
                'price' => 'required|numeric',
                'fragmentable' => 'required',
                'active'=>'required'
        ];
        for ($i=0; $i < count($allItems) ; $i++) {
            $tempArray = $allItems[$i];
            $itemValidated = Validator::make($tempArray,$rules );
            if($itemValidated->fails()){
                return response()->json(["errors" =>$itemValidated->messages(),"erroreInitem"=>$allItems[$i]["uniqeNumber"]], 422);
            }
        }
        for ($i=0; $i < count($allItems) ; $i++) { 
            unset($allItems[$i]["uniqeNumber"]);
            unset($allItems[$i]["sectionName"]);
        }
        $newTable =MenuItem::insert($allItems);
        if ($req->ajax()) {
            return response()->json(["message"=>"تم إدخال".count($allItems)." مادة جديدة الى القائمة بنجاح"]);
        }
    }
}
