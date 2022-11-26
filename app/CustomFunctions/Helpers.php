<?php

use App\Models\Hall;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Support\Facades\Redis;

if (! function_exists('getAjaxResponse')) {
    function getAjaxResponse($viewName,$vars)
    {

        $sections = view($viewName,$vars)->renderSections();
        return ["extendedScripts"=>$sections["scripts"] , "content"=>$sections["content"] , "extendedStyles"=>$sections["styles"]];
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

if (! function_exists('addSetHallInRedis')) {
    function addSetHallInRedis($hall)
    {
        Redis::hmset('halls:' . $hall->hallNumber, [
            'hallNumber' =>  $hall->hallNumber,
            'name' => $hall->hallName,
            'active' =>  $hall->active,
            'maxCapacity' => $hall->maxCapacity,
        ]);
    }
}
if (! function_exists('getHallsFromRedis')) {
    function getHallsFromRedis(){
        $halls = [];
        $keys = Redis::keys('halls:*');
        foreach ($keys as $key) {
            $key=str_replace('laravel_database_','',$key);
            $hall= Redis::hgetall($key);
            array_push( $halls,$hall);
        }
        return $halls;
    }
}
if (! function_exists('deleteHallFromRedis')) {
    function deleteHallInRedis($hallNumber)
    {
        Redis::del('halls:' . $hallNumber);
    }
}
if (! function_exists('addSetTableInRedis')) {
    function addSetTableInRedis($hallNumber,$table)
    {
         $rangeExpended = false;
         if ($table->tableNumber >= getOrderRange($hallNumber)) {
            $rangeExpended = true;
         }
        Redis::pipeline(function ($pipe) use ($hallNumber ,$table) {
                $pipe->hmset('hall:' . $hallNumber .':tables:'. $table->tableNumber, [
                    'tableNumber' =>  $table->tableNumber,
                    'hallNumber' =>  $table->hallNumber,
                    'active' =>  $table->active,
                    'maxCapacity' => $table->maxCapacity
                ]);

                $order=setTableOrder($table,'');
                $pipe->hmset('hall:' . $hallNumber .':table:'. $table->tableNumber,[
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
                $pipe->hmset('hall:' . $hallNumber .':tables:'. intval($tables[$i]["tableNumber"]), [
                    'tableNumber' =>  intval($tables[$i]["tableNumber"]),
                    'hallNumber' =>intval($hallNumber),
                    'active' =>  intval($tables[$i]["active"]),
                    'maxCapacity' => intval($tables[$i]["maxCapacity"])
                ]);
                $pipe->hmset('hall:' . intval($hallNumber) .':table:'. intval($tables[$i]["tableNumber"]),[
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
        Redis::del('hall:' . $hallNumber.':tables:'. $tableNumber);
        Redis::del('hall:' . $hallNumber .':table:'. $tableNumber.':status:');
        Redis::del('hall:' . $hallNumber .':table:'. $tableNumber.':orders:');
    }
}
if (! function_exists('getHallTablesFromRedis')) {
    function getHallTablesFromRedis($hallNumber){
        $tables = [];
        $keys = Redis::keys('hall:' . $hallNumber.':tables:*');
        foreach ($keys as $key) {
            $key=str_replace('laravel_database_','',$key);
            $tableMainInfo= Redis::hgetall($key);
            $tableStatus= Redis::hgetall('hall:' . $hallNumber .':table:'. $tableMainInfo['tableNumber']);
            $table=(object)(array_merge($tableMainInfo,$tableStatus));
            array_push( $tables,$table);
        }
        return $tables;
    }
}
if (! function_exists('getOrderRange')) {
    function getOrderRange($hallNumber){
        $count = Redis::keys('hall:' . $hallNumber.':tables:*');
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
if (! function_exists('resetOrderRange')) {
    function resetOrderRange($hallNumber){
        $keys =Redis::keys('hall:' . $hallNumber.':tables:*');
        foreach ($keys as $key) {
            $key=str_replace('laravel_database_','',$key);
            $table = Redis::hgetall($key);
            $tableInfo=Redis::hgetall('hall:' . $hallNumber.':table:'.$table['tableNumber']);
            $newOrder=setTableOrder((object)$table,$tableInfo['status']);
            Redis::hmset('hall:' . $hallNumber.':table:'.$table['tableNumber'], "order", $newOrder);
        }
    }
}

