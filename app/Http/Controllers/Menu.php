<?php

namespace App\Http\Controllers;

use App\Models\MenuSection;
use Illuminate\Http\Request;

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
}
