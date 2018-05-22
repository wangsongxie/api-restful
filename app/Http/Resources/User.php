<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'  => $this->id ,
            'nickname' => $this->nickname ,
            'contact' => $this->contact ,
            'mobile'  => $this->mobile ,
            'provincce_id' => $this->province_id ,
            'city_id' => $this->city_id ,
            'area_id' => $this->area_id ,
            'shop_desc' => $this->shop_desc ,
            'headimgurl' => $this->headimgurl ,
            'sell_type' => $this->sell_type ,
            'qq_name' => $this->qq_name ,
            'qq_headimgurl' => $this->qq_headimgurl ,
            'qq_openid' => $this->qq_openid ,
            'wx_name' => $this->wx_name ,
            'wx_headimgurl' => $this->wx_headimgurl ,
            "wx_openid" => $this->wx_openid ,
            "real_name" => $this->real_name ,
            "alipay" => $this->alipay ,
            "wechat" => $this->wechat ,
            "name" => $this->name ,
            "email" => $this->email ,
            "token" => $this->token ,
        ];
    }
}
