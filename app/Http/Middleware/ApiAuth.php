<?php

namespace App\Http\Middleware;

use App\Api\Middleware\AuthMiddleware;
use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;

class ApiAuth extends AuthMiddleware
{

    public function handle(Request $request, Closure $next)
    {


        try {
            // 如果用户登陆后的所有请求没有jwt的token抛出异常
            $user = JWTAuth::toUser(JWTAuth::getToken());
            if (!$user) {
                return $this->noAuthenticate("token无效");
            }
        } catch (Exception $e) {
            return $this->noAuthenticate("token无效");
        }
        return $next($request);
    }

}
