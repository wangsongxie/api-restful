<?php

namespace App;

use Carbon\Carbon;

class Sms extends BaseModel
{
    protected $table = "sms" ;

    const STATUS_NOT_VALID = 0 ;
    const STATUS_VALID = 1;
    const Register = 'register';
    const Login = 'login' ;
    const BIND = 'bind' ;
    const CHANGE_MOBILE = 'change_mobile';

    public function scopeValidate($query , $mobile , $type)
    {
        return $query->where([
            ['status' ,'=', self::STATUS_NOT_VALID] ,
            ['created_at' , '>' , Carbon::now()->subMinutes(30)] ,
            ['mobile' , '=' , $mobile] ,
            ['type' , '=' , $type ],
        ]);
    }
}
