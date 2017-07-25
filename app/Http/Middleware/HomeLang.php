<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use URL;
use Request;

class HomeLang {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        
        if(!Session::has('lang')){
            App::setLocale(Request::server('HTTP_ACCEPT_LANGUAGE')[0].Request::server('HTTP_ACCEPT_LANGUAGE')[1]);
        }
            return $next($request);
    }
}
    