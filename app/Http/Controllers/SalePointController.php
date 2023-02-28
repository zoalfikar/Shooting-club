<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalePointController extends Controller
{
    public function newSalePoint(Request $req)
    {
        if ($req->ajax()) {
            return getAjaxResponse('frontend.salePoint.new' , []);
        }
        return view('frontend.salePoint.new');
    }
    public function getOrders()
    {
        $orders =getSalePointOrders(1);
        return response()->json(['orders'=>$orders]);
    }
    public function setOrder(Request $req)
    {
        
       $order = setSalePointOrder(1,$req->order);
       return response()->json(['order'=>$order]);

    }
    public function deleteOrder()
    {

    }
}
