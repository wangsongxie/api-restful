<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        "id",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'created_at', 'updated_at'
    ];


    protected $dates = [
        'birthday' , 'first_keep_pets_time',
    ];





    public function getJWTIdentifier()
    {
        return $this->id ;
    }

    public function getJWTCustomClaims()
    {
        return [
            'id' => $this->id ,
            'password'  => $this->password ,
        ];
    }

    public function scopeQqopenid($query ,$openid)
    {
        return $query->where(['qq_openid' => $openid]);
    }

    public function scopeWxopenid($query , $openid)
    {
        return $query->where(['wx_openid' => $openid]);
    }

    public function scopeMobile($query , $mobile)
    {
        return $query->where(['mobile' => $mobile]);
    }

    public function findForPassport($username) {
        return $this->where('mobile', $username)->first();
    }

    public function identify()
    {
        return $this->hasOne(UserIdentify::class , 'user_id','id');
    }

    public function address()
    {
        return $this->hasMany(Address::class , 'user_id','id');
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'id');
    }
}
