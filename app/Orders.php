<?php

namespace App;


class Orders extends BaseModel
{
    protected $table = "orders";

    // 0已提交，1已支付,2已发货，3已收货，4已评价，5订单取消，6发起退货，7已退货
    const STATUS_SUBMIT = 0 ;
    const STATUS_HASPAY = 1 ;
    const STATUS_HASSHIPPING = 2 ;
    const STATUS_HASGET = 3 ;
    const STATUS_HASCOMMENT = 4 ;
    const STATUS_CANCEL = 5 ;
    const STATUS_HASBACK = 6 ;
    const STATUS_HAS_BACK_OVER = 7 ;

    // 0未支付,1正在支付，2支付成功，3支付失败
    const PAY_NOTPAY = 0 ;
    const PAY_PAYING = 1 ;
    const PAY_SUCCESS = 2 ;
    const PAY_FAIL = 3 ;

    // 配送方式0外地，1同城，2自提
    const SHIPPING_OTHER = 0 ;
    const SHIPPING_CITY = 1 ;
    const SHIPPING_SELF = 2 ;




    public function dog()
    {
        return $this->hasMany(OrderDog::class , 'order_id',"id");
    }

    public function orderDog()
    {
        return $this->hasOne(OrderDog::class,'order_id','id');
    }

}
