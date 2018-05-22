<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 16:00
 */
namespace App\Repsitories ;

use App\Dog;
use App\UserIdentify;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

class ShopResitory extends Repository
{
    public function model()
    {
        return UserIdentify::class ;
    }

    public function getShopList($city_id = null)
    {
        $shop = $this->model->with(['dogs' => function($query) {
            $query->limit(3);
            $query->with(['dogInfo'=> function($query){
                $query->select(['dog_id', 'thumb']);
            }]);
        }])->select("user_id",'logo', 'stars', "sell_type","shop_name","address",'trade_num');
        if(is_null($city_id))
        {
            $list = $shop->paginate(10);
        }
        else{
            $list = $shop->where("city_id","{$city_id}")->paginate(10);
        }

        return $list ;
    }

    public function getShopIndex($id , $new , $price = null)
    {
        $query = $this->model->shop()->where("id",$id);
        $query->orderBy('id',$new);
        if(!is_null($price))
        {
            $query = $query->orderBy("buyout_price",$price);
        }
        $shop = $query->select("id","sell_type","shop_name","address","lon","lat","province_id","city_id","area_id","shipping_price")->first();
        if(is_null($shop))
        {
            return $shop ;
        }
        $shop->dogs = Dog::where('shop_id', $shop->id)->onsell()->select("id","title","buyout_price","market_price")->paginate(10) ;
        return $shop;
    }

    public function getShopOnSell($cate_id = null , $time = 'desc', $price = null)
    {
        $query = Dog::where('user_id' , \Auth::user()->id);
        if(!is_null($cate_id))
        {
            $query = $query->where('cate_id' , $cate_id);
        }
        if(!is_null($price))
        {
            $query = $query->orderBy('buyout_price', $price);
        }
        $dogs = $query->onsell()->with(['dogInfo' => function ($query){
            $query->select(['dog_id', 'thumb']);
        }])->orderBy("id", $time)->paginate(10);
        return $dogs ;
    }


}
