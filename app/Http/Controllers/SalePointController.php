<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        $newOrder = json_decode($req->order);
        if( $newOrder->created_at) $newOrder->updated_at = Carbon::now()->format('y-m-d g:i A');
        else  $newOrder->created_at = Carbon::now()->format('y-m-d g:i A');
       $order = setSalePointOrder(1,$newOrder);
       return response()->json(['order'=>$order]);

    }
    public function deleteOrder()
    {

    }
}
