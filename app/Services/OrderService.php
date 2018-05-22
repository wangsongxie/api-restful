<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/1
 * Time: 11:53
 */

namespace App\Services;


use App\Dog;
use App\DogFile;
use App\OrderDog;
use App\Orders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public static function checkAddress($address_id)
    {
        $address = Auth::user()->address()->find($address_id);
        return $address ?: false;
    }

    public static function checkDog($dog_id)
    {
        $dog = Dog::find($dog_id);
        return $dog ?: false;
    }

    public static function makeOrder($address, $dog, $shipping_type, $payment, $user)
    {
        while (true) {
            $shop = $dog->shopInfo();
            $order = new Orders();
            $orderDog = new OrderDog();
            $order->order_no = static::makeOrderNo();
            // 地址信息
            $order->region_id = $address->region_id;
            $order->address_id = $address->id;
            $order->shipping_type = $shipping_type;
            $order->consignee_name = $address->username;
            $order->consignee_mobile = $address->mobile;
            $order->consignee_address = $address->address;

            if ($shipping_type == Orders::SHIPPING_SELF) {
                $order->shipping_price = 0;
            } else {
                $order->shipping_price = $shop->value("shipping_price");
            }

            // 价格
            // 是否是预售
            if ($dog->is_presell == 1) {
                $order->origin_price = $dog->buyout_price;
                $order->is_pre = 1;
                $order->pre_price = $dog->presell_price;
                $order->total_price = $dog->buyout_price + $dog->presell_price + $order->shipping_price;
            } else {
                $order->origin_price = $dog->buyout_price;
                $order->total_price = $dog->buyout_price + $order->shipping_price;
                $order->is_pre = 0;
                $order->pre_price = 0;
            }

            $order->number = 1;
            $order->payment = $payment;
            $order->order_status = Orders::STATUS_SUBMIT;
            $order->pay_status = Orders::PAY_NOTPAY;
            $order->user_id = Auth::id();
            $orderDog->fill($dog->only(["birthday", "cate_id", "vaccine", "sex", "sterilization", "grade", "body_size", "insect", "health_ensure_days", "title", "buyout_price", "market_price", "shop_id", "is_presell"]));
            $thumb = $dog->files()->where('type', DogFile::PICTURE)->value("url");
            if (!$thumb) {
                $thumb = $dog->files()->value("url");
            }
            $orderDog->thumb = $thumb;
            $orderDog->dog_id = $dog->id;
            DB::beginTransaction();
            if ($order->save()) {
                $orderDog->order_id = $order->id;
                if ($orderDog->save()) {
                    DB::commit();
                    $res = true;
                    break;
                } else {
                    DB::rollBack();
                    $res = false;
                    break;
                }
            } else {
                DB::rollBack();
                $res = false;
                break;
            }
        }
        if ($res) {
            return $order;
        } else {
            return false;
        }
    }

    public static function makeOrderNo()
    {
        // 年-月-日-时分秒-uid-四位随机数
        $no = date("YmdHis", time()) . Auth::id() . rand(1111, 9999);
        return $no;
    }

    // 获取个人订单的状态统计数目
    public static function getOrderStatusCounts()
    {
        // 待付款
        $need_pay = Orders::where('user_id', Auth::id())->where('order_status', Orders::STATUS_SUBMIT)->count();
        // 待收货
        $need_confirm = Orders::where('user_id', Auth::id())->where('order_status', Orders::STATUS_HASSHIPPING)->count();
        // 待评价
        $need_comment = Orders::where('user_id', Auth::id())->where('order_status', Orders::STATUS_HASGET)->count();

        return ['need_pay' => $need_pay, 'need_confirm' => $need_confirm, 'need_comment' => $need_comment];
    }

    // 根据状态获取订单列表 
    public static function getOrderListByStatus($status = null)
    {
        $order = Orders::where('user_id', Auth::id())->with('orderDog');
        if (is_null($status)) {
            // 全部
            $list = $order->orderBy('id', 'desc')->paginate(10);
        } else {
            $list = $order->where('order_status', $status)->orderBy('id', 'desc')->paginate(10);
        }
        $list = $list->setCollection($list->getCollection()->makeVisible('created_at'));
        return $list;
    }

    public static function cancenOrder($order_no)
    {
        $order = Orders::where([
            'order_no' => $order_no
        ])->first();
        if ($order->order_status == Orders::STATUS_SUBMIT) {
            $order->order_status = Orders::STATUS_CANCEL;
            if ($order->save()) {
                return true;
            }
        }
        return false;
    }
}























