<?php

use App\Models\Hall;
use App\Models\Order;
use App\Models\Table;
use App\Models\UserHallTable;
use Illuminate\Support\Carbon;
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
if (! function_exists('setTablesInfo')) {
    function setTablesInfo($hallNumber, $tables , $info){
        foreach ($tables as  $table) {
            Redis::hmset('hall:' . $hallNumber.':table:'.$table, "customerInfo", serialize($info));
        }
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
if (! function_exists('getSalePointOrders')) {
    function getSalePointOrders($salPointId){
        // dd(Redis::get('salePoint:' . $salPointId .':order:803a3848-60c0-438d-8b01-5bfeecf27e39'));
        // dd(Redis::mGet(['salePoint:' . $salPointId .':order:803a3848-60c0-438d-8b01-5bfeecf27e39']));
        $keys = Redis::KEYS('salePoint:' . $salPointId .':order:*');
        for ($i=0; $i < count($keys) ; $i++) { 
            $keys[$i] = str_replace('laravel_database_','',$keys[$i]);
        }
        $orders = Redis::mGet($keys);
        for ($i=0; $i < count($orders) ; $i++) { 
            $orders[$i] = unserialize($orders[$i]);
        }
        usort($orders,function ($a , $b)
        {
            if (!$a) {
                return -1 ; 
            }
            if (!$b) {
                return 1 ; 
            }
            $ad = new DateTime($a->created_at);
            $bd = new DateTime($b->created_at);
          
            if ($ad == $bd) {
              return 0;
            }
          
            return $ad < $bd ? -1 : 1; 
        });
        return $orders;

    }
}
if (! function_exists('setSalePointOrder')) {
    function setSalePointOrder($salPointId, $order ){
        Redis::set('salePoint:' . $salPointId .':order:'. $order->id, serialize($order));
        return unserialize(Redis::get('salePoint:' . $salPointId .':order:'. $order->id));
    }
    // [
    //     'id'=>$order['id'],
    //     'status' =>  $order['status'],
    //     'orders' => serialize($order['orders']) ,
    //     'customerName' =>  $order['customerName'],
    //     'created_at' => $oldOrder ? $order['created_at'] : Carbon::now()->format('y-m-d g:i A'),
    //     'updated_at' =>  $oldOrder ? Carbon::now()->format('y-m-d g:i A') : null,
    // ]
}
if (! function_exists('deleteSalePointOrder')) {
    function deleteSalePointOrder($salPointId, $order){
        Redis::del('salePoint:' . $salPointId .':order:'. $order);
        return $order ;
    }
}
if (! function_exists('setSalePointSeller')) {
    function setSalePointSeller($id, $salPoint){
        Redis::set('salePointSeller:' . $id .':salPoint:' , $salPoint);
    }
}
if (! function_exists('getSellerSalePoint')) {
    function getSellerSalePoint($id){
      return  Redis::get('salePointSeller:' . $id .':salPoint:');
    }
}
if (! function_exists('delSalePointSeller')) {
    function delSalePointSeller($id){
        if (Redis::exists('salePointSeller:' . $id .':salPoint:'))
        {
            Redis::del('salePointSeller:' . $id .':salPoint:');
        }
    }
}
if (! function_exists('getAllSalePointSellers')) {
    function getAllSalePointSellers($id){
        $keys = Redis::KEYS('salePointSeller:*');
        $sellers = [];
        foreach ($keys as $key) {
            if (Redis::get(str_replace('laravel_database_' ,'' ,$key )) == $id) {
                array_push($sellers,intval(substr($key, strpos($key ,'salePointSeller:')+strlen("salePointSeller:"),strpos($key ,':salPoint'))));
            }
        }
        return $sellers;
    }
}