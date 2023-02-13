<?php

namespace App\Http\Controllers;

use App\Models\MenuSection;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Http\Requests\MenuItemRequest;
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
            return response()->json(["message"=>"تم إدخال عنصر جديد الى القائمة بنجاح"]);
        }
        redirect()->back()->with("message","تم إدخال عنصر جديد الى القائمة بنجاح");
    }
}
