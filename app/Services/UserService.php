<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/24
 * Time: 10:52
 */
namespace App\Services ;


use App\UserIdentify;
use Illuminate\Support\Facades\Auth;

class UserService
{


    public static function verifyUser( array $info )
    {
        $info ['is_valid'] = UserIdentify::IN_VALID ;
        $has = Auth::user()->identify()->first() ;
        if($has)
        {
            return false;
        }
        return Auth::user()->identify()->create($info);
    }


}
