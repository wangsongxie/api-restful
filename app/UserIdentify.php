<?php

namespace App;

class UserIdentify extends BaseModel
{
    protected $table = "user_identify";

    protected $hidden = [
        'id',
        'real_name',
        'id_card',
        'id_card_image',
        'mobile',
        'bank_name',
        'license_image_url',
        'bank_no',
        'lon',
        'lat',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $appends = [
        'comments_count'
    ];
    const TYPE_PERSONAL = '1'; // 个人

    const TYPE_SHOP = '2'; // 商家

    CONST TYPE_UNDEFINED = '0' ; // 未定义

    CONST IN_VALID = 0 ;

    CONST VALID = 1 ;

    public $dogs ;


    
    // 已认证 商家
    public function scopeShop($query)
    {
        return $query->where('is_valid',self::VALID)->where("sell_type",self::TYPE_SHOP);
    }
    //已认证个人 
    public function scopePersonal($query)
    {
        return $query->where('is_valid',self::VALID)->where("sell_type",self::TYPE_PERSONAL);
    }

    public function dogs()
    {
        return $this->hasMany(Dog::class , "user_id","user_id");
    }

    public function getCommentsCountAttribute()
    {
        return 0;
    }
}
