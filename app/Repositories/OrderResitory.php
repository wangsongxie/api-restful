<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/1
 * Time: 11:30
 */

namespace App\Repsitories;


use App\Orders;
use Bosnadev\Repositories\Eloquent\Repository;

class OrderResitory extends Repository
{
    public function model()
    {
        return Orders::class ;
    }

    public function getDetail($order_no)
    {
        $order = Orders::where([
            'order_no' => $order_no
        ])->with('orderDog')->first();
        return $order ;
    }
}
