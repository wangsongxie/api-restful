<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        /**
         * @var $response \Illuminate\Http\Response
         */
        $response =  $next($request);

        if($request->hasHeader("X-LOG-ID"))
        {
            DB::table("debug_log")->insert([
                "log_id" => $request->header("X-LOG-ID") ,
                "request" => json_encode($request->all()) ,
                "response" => $response->getContent(),
            ]);
        }

        return $response ;
    }
}
