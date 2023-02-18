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
    public function showFormEditSections(Request $req)
    {
        $sections = MenuSection::all();
        if ($req->ajax()) {
            return response( getAjaxResponse('frontend.resturant.menu.menuSections.EditMenuSections',["sections"=>$sections]));
        }
        return view('frontend.resturant.menu.menuSections.EditMenuSections',compact('sections'));
    }
    public function getMenuSection(Request $req)
    {
        $section = MenuSection::where('id',$req->id)->with('items')->first();
        if ($req->ajax()) {
            return response()->json(['section'=>$section]);
        }
    }
    public function updateMenuSection(Request $req)
    {
        $section = MenuSection::find($req->id);
        $section->name = $req->name;
        $section->options = $req->options;
        $section->active = $req->active;
        $section->description = $req->description;
        $section->update();
        return response()->json(['message'=>"تم التعديل بنجاح"]);
    }
    public function deleteMenuSection(Request $req)
    {
        $section = MenuSection::find($req->id);
        $section->delete();
        return response()->json(['message'=>"تم الحذف بنجاح"]);

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
    public function showFormEditItems(Request $req)
    {
        $sections = MenuSection::all();
        if ($req->ajax()) {
            return response( getAjaxResponse('frontend.resturant.menu.menuItems.EditMenuItems',["sections"=>$sections]));
        }
        return view('frontend.resturant.menu.menuItems.EditMenuItems',compact('sections'));
    }
    public function getMenuItems()
    {
        $sections = MenuSection::with('items')->get();
        // dd($sections[0]->items());
        return response()->json(['sections'=>$sections]);
    }
    public function updateMenuItem(Request $req)
    {
        $item = MenuItem::find($req->id);
        $item->title = $req->title;
        $item->price = $req->price;
        $item->unit = $req->unit;
        $item->pace = $req->pace;
        $item->fragmentable = $req->fragmentable;
        $item->active = $req->active;
        $item->description = $req->description;
        $item->update();
        return response()->json(["message"=>"تم التعديل بنجاح"]);

    }
    public function deleteMenuItem(Request $req)
    {
        $item = MenuItem::find($req->id);
        $item->delete();
        return response()->json(["message"=>"تم الحذف بنجاح"]);
    }
}
