<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Dog extends BaseModel
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at'
    ];

    protected $table = "dogs";

    // 性别
    const SEX_MALE = 0 ;
    const SEX_FEMALE = 1 ;

    //品级
    const GRARE_PETS = 0 ; // 宠物级
    const GRATE_BLOOD = 1 ; // 血统级

    // 体型 .
    const BODYSIZE_SMALL = 0 ; // 小
    const BODYSIZE_MEDIUM = 1 ; // 中
    const BODYSIZE_BIG = 2 ; //大

    public function category()
    {
        return $this->belongsTo(DogsCategory::class,"cate_id","id");
    }


    /**
     * @return bool
     */
    public function isPresell()
    {
        return $this->is_presell == 1 ;
    }

    public function files()
    {
        return $this->hasMany(DogFile::class,"dog_id","id");
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id','id');
    }

    public function categoryInfo()
    {
        return $this->belongsTo(DogsCategory::class , 'cate_id','id');
    }
    public function userInfo()
    {
        return $this->belongsTo(UserInfo::class , 'user_id','user_id');
    }
    public function shopInfo()
    {
        return $this->belongsTo(UserIdentify::class , 'user_id','user_id');
    }

    public function dogInfo()
    {
        return $this->hasOne(DogInfo::class, 'dog_id', 'id');
    }

    public function scopeOnsell($query)
    {
        return $query->where("is_sell", true);
    }
}
