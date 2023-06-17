<?php

namespace App\Http\Controllers;

use App\Events\salePointChanged;
use App\Events\salePointDeleted;
use App\Models\MenuItem;
use App\Models\MenuSection;
use App\Models\SalePoint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $salePoint =SalePoint::create($data);
            addSalePoint($salePoint->id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
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
        event(new salePointChanged($SP));
        return response()->json(["message"=>'تم العديل بنجاح' , 'name' => $SP->name ]);
    }
    public function deleteSalePoint(Request $req)
    {
        $SP  = SalePoint::find($req->id);
        event(new salePointDeleted($SP));
        deleteSalePoint($SP->id);
        $SP->delete();
        $this->renameSalePoints();
        return response()->json(["message"=>'تم الحذف بنجاح' , 'salePoints'=>SalePoint::all()]);
    }
    public function getSalePonitMenu()
    {
        $items = MenuSection::with('items')->where("options","both")->orWhere("options","free-point")->get();
        return response()->json(["items"=>$items]);
    }
    public function getSalePonits()
    {
        $salePoints = SalePoint::all();
        return response()->json(["salePoints"=>$salePoints]);
    }
    public function getSalePonit($id = null)
    {
        if($id == 'null' || $id == null) {$id = getSellerSalePoint(Auth::id());}
        $salePoint = SalePoint::find($id);
        $orders =getSalePointOrders($id);
        $setting = getSalePointSetting($id);
        return response()->json(["salePoint"=>$salePoint ,'orders'=>$orders , "setting"=>$setting]);
    }
    public function setOrder($id,Request $req)
    {
        $newOrder = json_decode($req->order);
        if($newOrder->created_at) $newOrder->updated_at = Carbon::now()->format('y-m-d g:i A');
        else  $newOrder->created_at = Carbon::now()->format('y-m-d g:i A');
       $order = setSalePointOrder($id,$newOrder);
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
    public function getHallAcountant(Request $req)
    {
        return response()->json(['salePoint'=>getHallAcounatnt($req->userId)]);
    }
    public function getAllSalePointSellers($id)
    {
        $ids = array_values(getAllSalePointSellers($id)) ;
        $sellers = User::where('role','salePoint')->whereIn('id',$ids)->get();
        return response()->json(['sellers'=>$sellers]);
    }
    public function getAllHallAcountants($id)
    {
        $ids = array_values(getAllHallAcounatnts($id)) ;
        $sellers = User::where('role','hallAcountant')->whereIn('id',$ids)->get();
        return response()->json(['sellers'=>$sellers]);
    }
    public function setSalePointSeller(Request $req)
    {
        setSalePointSeller($req->user_id, $req->salePoint);
        return response()->json(['message'=>'تم']);
    }
    public function setHallAcountant(Request $req)
    {
        setHallAcounatnt($req->user_id, $req->salePoint);
        return response()->json(['message'=>'تم']);
    }
    public function setSettings($id, Request $req)
    {
        setSalePointSetting($id, (object) ["deleteAfterPaid"=>$req->deleteAfterPaid,"paid"=>$req->paid]);
        return response()->json(['message'=>'تم']);
    }
    public function deletePaidOrders($id)
    {
        $orders =deleteSPPaidOrders($id);
        return response()->json(['orders'=>$orders]);
    }
}
