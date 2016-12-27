<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AjaxAuthenticate
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
        if (!$request->ajax() || !Auth::check()) {
            return response([
                'status' => 0,
                'error'  => [
                    'code'    => 401,
                    'message' => 'Authorized',
                ]
            ]);
        }

        return $next($request);
    }

}
