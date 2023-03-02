<?php

namespace App\Http\Controllers;

use App\Models\SalePoint;
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
    public function addSalePoint(Request $req)
    {
        $data = $req->only(['name' , 'maxEmployeesNumber' , 'salePointName']);
        if (!$data['name']) {
            $count = count(SalePoint::all()) +1 ;
            $newName = 'نقطة البيع رقم'.$count;
            $data['name'] = $newName ;
        }
        $salePoint =SalePoint::create($data);
        return response()->json(["message"=>'تم إدخال نقطة بيع جديد']);
    }
    public function editSalePoint(Request $req)
    {
        $salePoints = SalePoint::all();
        if ($req->ajax()) {
            return getAjaxResponse('frontend.salePoint.edit' , ['salePoints'=>$salePoints]);
        }
        return view('frontend.salePoint.edit',compact('salePoints'));
    }
    public function getSalePointData($id)
    {
        $salePoint = SalePoint::find($id);
        return response()->json(['salePoint'=>$salePoint]);
    }
    public function updateSalePoint(Request $req)
    {
        $SP  = SalePoint::find($req->id);
        if (!$req->name) {
            $count = count(SalePoint::all()) +1 ;
            $newName = 'نقطة البيع رقم'.$count;
            $SP->name = $newName;
        }
        else{
            $SP->name = $req->name;
        }
        $SP->maxEmployeesNumber = $req->maxEmployeesNumber ;
        $SP->active = $req->active ;
        $SP->update();
        return response()->json(["message"=>'تم العديل بنجاح' , 'name' => $SP->name ]);
    }
    public function deleteSalePoint(Request $req)
    {
        $SP  = SalePoint::find($req->id);
        $SP->delete();
        $this->renameSalePoints();
        return response()->json(["message"=>'تم الحذف بنجاح' , 'salePoints'=>SalePoint::all()]);
    }
    public function getOrders()
    {
        $orders =getSalePointOrders(1);
        return response()->json(['orders'=>$orders]);
    }
    public function setOrder(Request $req)
    {
        $newOrder = json_decode($req->order);
        // dd($newOrder->created_at);
        if($newOrder->created_at) $newOrder->updated_at = Carbon::now()->format('y-m-d g:i A');
        else  $newOrder->created_at = Carbon::now()->format('y-m-d g:i A');
       $order = setSalePointOrder(1,$newOrder);
       return response()->json(['order'=>$order]);

    }
    public function deleteOrder(Request $req)
    {
        return response()->json((['id'=>deleteSalePointOrder(1,$req->id)]));
    }
    protected function renameSalePoints()
    {
        $SalePoints = SalePoint::orderBy('id', 'asc')->get();
        $pattern = "/نقطة البيع رقم/";
        foreach ($SalePoints as $key => $SalePoint) {
            if (preg_match($pattern, $SalePoint->name)) {
                $count = $key+1;
                $newName = 'نقطة البيع رقم'.$count;
                $SalePoint->name = $newName;
                $SalePoint->update();
            }
        }

    }
    public function getSellerSalePoint(Request $req)
    {
        return response()->json(['salePoint'=>getSellerSalePoint($req->userId)]);
    }
    public function getAllSalePointSellers($id)
    {
        # code...
    }
}
