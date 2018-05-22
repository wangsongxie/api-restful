<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserInfo extends BaseModel
{
   protected $table = 'user_info';

    protected $hidden = ['id', 'qq_openid', 'wx_openid', 'created_at', 'updated_at', 'deleted_at'];
}
