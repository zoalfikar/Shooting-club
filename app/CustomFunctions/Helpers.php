<?php

use App\Models\Hall;
use App\Models\Order;
use App\Models\Table;
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
        $halls = Hall::all();
        return $halls;
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
                    'customerInfo'=> '',
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
                    'customerInfo'=> '',
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
        $tables = Table::where('hallNumber',$hallNumber)->get()->toArray();
        foreach ($tables as $table) {
            $tableStatus= Redis::hgetall('hall:' . $hallNumber .':table:'. $table['tableNumber']);
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

