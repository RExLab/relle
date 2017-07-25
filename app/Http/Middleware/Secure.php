<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Request;

class Secure {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        /*
        if (!$request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }
       /* if ($request->header('x-forwarded-proto') <> 'https') {
            return redirect()->secure($request->getRequestUri());
        }*/
        return $next($request);
    }

}
