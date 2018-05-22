<?php

namespace App\Http\Middleware;

use Closure;

class TrimStringDelField
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
        $all = $request->all();
        foreach ($all as $key => $val)
        {
            if($val === '')
            {
                $request->request->remove($key);
            }
        }
        return $next($request);
    }
}
