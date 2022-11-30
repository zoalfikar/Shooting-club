<?php

namespace App\Http\Controllers;

use App\Http\Requests\HallRequest;
use App\Http\Requests\TableRequest;
use App\Models\Hall;
use App\Models\Table;
use App\Rules\AvailableHallNumber;
use App\Rules\AvailableTableNumber;
use App\Rules\MaxHallCapacity;
use App\Rules\TableHallRule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule ;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;

use function PHPUnit\Framework\throwException;

class Resturant extends Controller
{
    public function showFormNewTable($hallNumber = 1 , Request $req)
    {
        $TableNumber = getAvailableTableNumber($hallNumber);
        $initMaxCapacity = Hall::where('hallNumber',$hallNumber)->pluck("maxCapacity")->first();
        $maxTablesNumbers = $initMaxCapacity - $TableNumber +1;
        $hallNumbers = Hall::all()->pluck('hallNumber')->toArray();
        if (isset($req['hallNumberChanged'])) {
           return $this->getTableNumber($req['hallNumber']);
        }
        if ($req->ajax()) {
            return response( getAjaxResponse('frontend.resturant.tables.newTable',['TableNumber'=>$TableNumber,'hallNumbers'=>$hallNumbers,'maxTablesNumbers'=>$maxTablesNumbers]));
        }
        return view('frontend.resturant.tables.newTable',compact('TableNumber','hallNumbers','maxTablesNumbers'));
    }
    public function addNewTable(TableRequest $req)
    {

        DB::beginTransaction();
        try {
            $newTable =Table::create($req->only(['tableNumber','hallNumber','maxCapacity','active']));
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        addSetTableInRedis($newTable->hallNumber,$newTable);
        if ($req->ajax()) {
            return response()->json(["success"=>"تم ادخال الطاولة بنجاح","aviliableTableNumber"=>getAvailableTableNumber($req['hallNumber'])]);
        }
        return redirect()->back();
    }
    public function addManyNewTable(Request $req)
    {
        $validator = Validator::make($req->only(['manyTables','hallNumber']), [
                'manyTables' => ['array', 'required','min:1'],
                'hallNumber' => ['required','numeric', new TableHallRule()],
        ]);
        if($validator->fails()){
            return response()->json(["errors"=> $validator->messages()], 422);
        }
        $rules=[
            'tableNumber' => ['required','numeric', Rule::unique('tables')->where(fn ($query) => $query->where('hallNumber', $req->hallNumber)),new MaxHallCapacity($req->hallNumber)],
            'hallNumber' => ['required','numeric', new TableHallRule()],
            'maxCapacity' => 'required|numeric|min:1',
            'active'=>'required'
        ];
        $allTables=$req->manyTables;
        for ($i=0; $i < count($allTables) ; $i++) {
            if ($i==0) {
                $TNArray =[];
                $TNArray["tableNumber"]=$allTables[$i]["tableNumber"];
                $TNValidator=Validator::make($TNArray, [
                    'tableNumber' => [new AvailableTableNumber($req->hallNumber)],
                ]);
                if($TNValidator->fails()){
                    return response()->json(["errors" =>$TNValidator->messages(),"erroreInTable"=>$allTables[$i]], 422);
                }
            }
            if ($i != 0 && intval($allTables[$i]["tableNumber"])!=intval($allTables[$i-1]["tableNumber"])+1) {
                return response()->json(["errors" =>["tableNumber", "أرقام الطاولات متسلسلة"]], 422);
            }
            $array=[];
            $array["tableNumber"]=$allTables[$i]["tableNumber"];
            $array["hallNumber"]=$allTables[$i]["hallNumber"];
            $array["maxCapacity"]=$allTables[$i]["maxCapacity"];
            $array["active"]=$allTables[$i]["active"];
            $tableValidator = Validator::make($array,$rules );
            if($tableValidator->fails()){
                return response()->json(["errors" =>$tableValidator->messages(),"erroreInTable"=>$allTables[$i]], 422);
            }
        }
        DB::beginTransaction();
        try {
            $newTable =Table::insert($allTables);
            addSetManyTablesInRedis($req->hallNumber,$allTables);
            // $lastRedisTable = Redis::hget('hall:' . $req->hallNumber .':tables:'. $allTables[count($allTables)-1]);
            // if ($lastRedisTable->tableNumber  != $allTables[count($allTables)-1]["tableNumber"]) {
            //     throw new Exception("حدث خطأ اثناء الاتصال بقواعد البيانات , يرجى اعادة المحاولة");
            // }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        catch (Exception $e) {
            DB::rollback();
            return response()->json(["errors" =>$e->getMessage()], 422);
        }
        $TableNumber =  getAvailableTableNumber($req->hallNumber);

        return response()->json(["success"=>" تم إدخال"  .count($allTables)." طاولة بنجاح " ,"availableTableNumber"=>$TableNumber]);

     }



    protected function getTableNumber($hallNumber)
    {
        $TableNumber = getAvailableTableNumber($hallNumber);
        $initMaxCapacity = Hall::where('hallNumber',$hallNumber)->pluck("maxCapacity")->first();
        $maxTablesNumbers = $initMaxCapacity - $TableNumber +1;
        return response(["TableNumber"=>$TableNumber,'maxTablesNumbers'=>$maxTablesNumbers]);
    }
    public function showFormUpdateTables(Request $req)
    {
        $tables = Table::where('hallNumber',1)->get();
        $hallNumbers = Hall::all()->pluck('hallNumber')->toArray();
        if (isset($req['hallNumberChanged'])) {
            return $this->getHallTables($req['hallNumber']);
        }
        if ($req->ajax()) {
            return response( getAjaxResponse('frontend.resturant.tables.updateTables',['tables'=>$tables,'hallNumbers'=>$hallNumbers]));
        }
        return view('frontend.resturant.tables.updateTables',compact('tables','hallNumbers'));
    }
    public function updateTables(Request $req)
    {
        $requestValidator = Validator::make($req->only(['hallNumber','tables']),[
            'hallNumber' => ['required','numeric', new TableHallRule()],
            'tables'=> ['required','array']
        ]);
        if ($requestValidator->failed()) {
            return response()->json(["errors"=> $validator->messages()], 422);
        }
        $tables = $req["tables"];
        DB::beginTransaction();
        try {
            foreach ($tables as  $table) {
                Table::where('hallNumber', $req["hallNumber"])->where('tableNumber', $table['tableNumber'])->update(['maxCapacity' => $table["maxCapacity"] , 'active'=>$table["active"]]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["errors" =>$th->getMessage()], 422);
        }
        return response()->json(["message"=>"تم تعديل الطاولات بنجاح"]);
    }
    public function deleteTables(Request $req)
    {
        $requestValidator = Validator::make($req->only(['hallNumber','deletedTables']),[
            'hallNumber' => ['required','numeric', new TableHallRule()],
            'deletedTables'=> ['required','array']
        ]);
        if ($requestValidator->failed()) {
            return response()->json(["errors"=> $validator->messages()], 422);
        }
        $tables = $req["deletedTables"];
        rsort($tables);
        DB::beginTransaction();
        try {
            foreach ($tables as $key => $table) {
                if ($key!=0  && $tables[$key - 1] - $tables[$key] != 1) {
                    throw new Exception("يتم حذف الطاولات بشكل متسلسل");
                }
            }
            foreach ($tables as  $table) {
                deleteTableFromRedis($req['hallNumber'],$table);
            }
            Table::where('hallNumber',$req['hallNumber'])->whereIn('tableNumber',$tables)->delete();
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["errors" =>$th->getMessage()], 422);
        }
        return response()->json(["message"=>"تم حذف".count($tables)."بنجاح"]);
    }
    protected function getHallTables($hallNumber)
    {
        $tables = Table::where('hallNumber',$hallNumber)->get();
        return response(["tables"=>$tables]);
    }
    public function showFormNewHall($hallNumber = 1 , Request $req)
    {
        $hallNumber = getAvailableHallNumber();
        if ($req->expectsJson()) {
            return response( getAjaxResponse('frontend.resturant.halls.newHall',['hallNumber'=>$hallNumber]));
        }
        return view('frontend.resturant.halls.newHall',compact('hallNumber'));
    }
    public function addNewHall(HallRequest $req)
    {
        DB::beginTransaction();
        try {
            $newHall = Hall::create($req->only(['hallNumber','hallName','maxCapacity','active']));
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        // addSetHallInRedis($newHall);
        // if ($req->ajax()) {
        //     return response()->json();
        // }
        return redirect()->back();
    }
    public function showFormUpdteaHall(Request $req)
    {
        $halls = Hall::all();
        $aviliablHallNumber = getAvailableHallNumber();
        $updateHall = $aviliablHallNumber - 1 ;
        if ($req->expectsJson()) {
            return response( getAjaxResponse('frontend.resturant.halls.updateHall',['halls'=>$halls,'updateHall'=>$updateHall]));
        }
        return view('frontend.resturant.halls.updateHall',compact(['halls','updateHall']));
    }
    public function getHallData($hallNumber)
    {
        $hall = Hall::where('hallNumber',$hallNumber)->first();
        return response()->json(["hall"=>$hall]);
    }
    public function updateHall(Request $req)
    {
        $hall = Hall::where('hallNumber',$req->hallNumber)->first();
        $hall->active = $req->active;
        $hall->maxCapacity = $req->maxCapacity;
        $hall->hallName = $req->hallName;
        $hall->update();
        return response()->json(["message" => "تم تعديل الصالة رقم ".$hall->hallNumber." بنجاح "]);
    }
    public function deleteHall(Request $req)
    {
        $hall = Hall::where('hallNumber',$req->hallNumber)->first();
        deleteHallTablesFromRedis($req->hallNumber);
        $hall->delete();
        return response()->json(["message" => " تم حذف الصالة بنجاح" , "hallNumber" => $req->hallNumber - 1]);
    }

}
