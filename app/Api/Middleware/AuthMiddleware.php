<?php

/**
 * Created by PhpStorm.
 * User: DevKang
 * Date: 2017/8/26
 * Time: 21:00
 */
namespace App\Api\Middleware;

class AuthMiddleware
{

    public function noAuthenticate($message = 'token无效') {
        return response()->json(['code' => 401, 'message' => $message] , 200);
    }
}