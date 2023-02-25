<?php

use App\Models\Hall;
use App\Models\Order;
use App\Models\Table;
use App\Models\UserHallTable;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\Redis;

if (! function_exists('getAjaxResponse')) {
    function getAjaxResponse($viewName,$vars)
    {

        $sections = view($viewName,$vars)->renderSections();
        return ["extendedScripts"=>array_key_exists("scripts",$sections) ? $sections["scripts"] : null  , "content"=>array_key_exists("content",$sections) ? $sections["content"] : null , "extendedStyles"=>array_key_exists("styles",$sections) ?$sections["styles"] : null];
    }
}
if (! function_exists('getAvailableTableNumber')) {
    function getAvailableTableNumber($hallNumber)
    {
       return Table::where('hallNumber',$hallNumber)->max('tableNumber') + 1;
    }
}
if (! function_exists('getAvailableHallNumber')) {
    function getAvailableHallNumber()
    {
       return Hall::max('hallNumber') + 1;
    }
}
if (! function_exists('getHalls')) {
    function getHalls(){
        if (Auth::user()->role == 'waiter') {
            $waiterInfo = UserHallTable::select('hall')->where("user_id" , Auth::id() )->first();
            $halls = Hall::where('hallNumber',$waiterInfo->hall)->get();
            return $halls;
        }
        else{
            return $halls = Hall::all();
        }
    }
}
if (! function_exists('deleteHallTablesFromRedis')) {
    function deleteHallTablesFromRedis($hallNumber){
        $tables =Table::where('hallNumber' , $hallNumber)->get();
        foreach ($tables as $table) {
            deleteTableFromRedis($table->hallNumber,$table->tableNumber);
        }
    }
}
if (! function_exists('addSetTableInRedis')) {
    function addSetTableInRedis($hallNumber,$table)
    {
         $rangeExpended = false;
         if ($table->tableNumber >= getOrderRange($hallNumber)) {
            $rangeExpended = true;
         }
        Redis::pipeline(function ($pipe) use ($hallNumber ,$table)
        {
                $order=setTableOrder($table,'');
                $pipe->hmset('hall:' . $hallNumber .':table:'. $table->tableNumber,[
                    'customerInfo'=>'',
                    'status' =>  '',
                    'orders' =>  '',
                    'order' =>  $order,

                ]);
        });
        if ( $rangeExpended) {
            resetOrderRange($hallNumber);
        }

    }
}
if (! function_exists('addSetManyTablesInRedis')) {
    function addSetManyTablesInRedis($hallNumber,$tables)
    {

        Redis::pipeline(function ($pipe) use ($hallNumber ,$tables) {
            for ($i=0; $i < count($tables) ; $i++) {
                $pipe->hmset('hall:' . intval($hallNumber) .':table:'. intval($tables[$i]["tableNumber"]),[
                    'customerInfo'=>'',
                    'status' =>  '',
                    'orders' =>  '',
                    'order' =>  0,
                ]);
            }
        });
        resetOrderRange(intval($hallNumber));
    }
}
if (! function_exists('deleteTableFromRedis')) {
    function deleteTableFromRedis($hallNumber,$tableNumber)
    {
        Redis::del('hall:' . $hallNumber .':table:'. $tableNumber);
    }
}
if (! function_exists('getHallTables')) {
    function getHallTables($hallNumber){
        $reslt = [];
        if (Auth::user()->role == 'waiter') {
            $waiterTables = UserHallTable::select('tables')->where('user_id',Auth::id())->pluck('tables')->toArray();
            // dd($waiterTables);
            $tables = Table::whereIn('tableNumber',$waiterTables[0])->where('hallNumber',$hallNumber)->get()->toArray();
        }else {
            $tables = Table::where('hallNumber',$hallNumber)->get()->toArray();
        }
        foreach ($tables as $table) {
            $tableStatus= Redis::hgetall('hall:' . $hallNumber .':table:'. $table['tableNumber']);
            $tableStatus['orders'] = unserialize($tableStatus['orders']);
            $tableStatus['customerInfo'] = unserialize($tableStatus['customerInfo']);
            $table=(object)(array_merge($table,(array)$tableStatus));
            array_push( $reslt,$table);
        }
        return $reslt;
    }
}
if (! function_exists('getOrderRange')) {
    function getOrderRange($hallNumber){
        $count = Table::where('hallNumber',$hallNumber)->get();
        return pow(10,strlen((count($count))));
    }
}
if (! function_exists('setTableOrder')) {
    function setTableOrder($table,$status){
        switch ($status) {
            case '':
              return getOrderRange($table->hallNumber)+$table->tableNumber;
              break;
            case 'active':
            return  2*getOrderRange($table->hallNumber)+$table->tableNumber;
              break;
            case 'taken':
            return  3*getOrderRange($table->hallNumber)+$table->tableNumber;
              break;
          }
    }
}
if (! function_exists('setTableOrderAll')) {
    function setTableOrderAll($table,$status , $orderRange){
        switch ($status) {
            case '':
              return $orderRange+$table->tableNumber;
              break;
            case 'active':
            return  2*$orderRange+$table->tableNumber;
              break;
            case 'taken':
            return  3*$orderRange+$table->tableNumber;
              break;
          }
    }
}
if (! function_exists('resetOrderRange')) {
    function resetOrderRange($hallNumber){
        $tables =Table::where('hallNumber' , $hallNumber)->get();
        $orderRange =  getOrderRange($hallNumber);

        foreach ($tables as $table) {
            $tableInfo=Redis::hgetall('hall:' . $hallNumber.':table:'.$table->tableNumber);
            // dd($tableInfo);
            $newOrder=setTableOrderAll($table,$tableInfo['status'],$orderRange );
            Redis::hmset('hall:' . $hallNumber.':table:'.$table['tableNumber'], "order", $newOrder);
        }
    }
}
if (! function_exists('setTableInfo')) {
    function setTableInfo($hallNumber, $table , $info){
        $info=serialize($info);
        Redis::hmset('hall:' . $hallNumber.':table:'.$table, "customerInfo", $info);
    }
}
if (! function_exists('getTableInfo')) {
    function getTableInfo($hallNumber, $table){
        $info= Redis::hget('hall:' . $hallNumber.':table:'.$table, "customerInfo");
        return $info=unserialize($info);
    }
}
if (! function_exists('setTableOrders')) {
    function setTableOrders($hallNumber, $table , $orders){
        $orders=serialize($orders);
        Redis::hmset('hall:' . $hallNumber.':table:'.$table, "orders", $orders);
    }
}
if (! function_exists('getTableOrders')) {
    function getTableOrders($hallNumber, $table){
        $orders= Redis::hget('hall:' . $hallNumber.':table:'.$table, "orders");
        $orders=unserialize($orders);
        if (!$orders) {
            return $orders=[];
        }
        return $orders;
    }
}
if (! function_exists('setTableStatus')) {
    function setTableStatus($hallNumber, $table , $status){
        Redis::hmset('hall:' . $hallNumber.':table:'.$table, "status", $status);
    }
}
if (! function_exists('getTableStatus')) {
    function getTableStatus($hallNumber, $table){
        $status= Redis::hget('hall:' . $hallNumber.':table:'.$table, "status");
        return $status;
    }
}
if (! function_exists('changeTableOrder')) {
    function changeTableOrder($hallNumber, $table , $order){
        Redis::hmset('hall:' . $hallNumber.':table:'.$table, "order", $order);
    }
}
if (! function_exists('changeTableStatus')) {
    function changeTableStatus($hallNumber, $table , $status){
        setTableStatus($hallNumber , $table , $status);
        $tableHall = Table::where('hallNumber' , $hallNumber)->where('tableNumber',$table)->first();
        $order=setTableOrder($tableHall, $status);
        changeTableOrder($hallNumber , $table , $order);
        return true;
    }
}
if (! function_exists('setTableOrderNoStatusRelative')) {
    function setTableOrderNoStatusRelative($hallNumber, $table , $order){
        changeTableOrder($hallNumber , $table , $order);
    }
}