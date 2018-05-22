<?php
/**
 * Created by PhpStorm.
 * User: DevKang
 * Date: 2017/7/14
 * Time: 14:19
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AllRequestLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        DB::enableQueryLog();
        $response = $next($request);
        return $response;
    }

    public function terminate($request, $response)
    {
        \Log::info('app.requests', ['request' => $request]);
        \Log::info('app.dbQueryLogs', ['dbQueryLog' => DB::getQueryLog()]);
        \Log::info('app.responses', ['response' => $response]);


    }
}