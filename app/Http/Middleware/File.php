<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use File;

class ShowFile {
    if (File::isFile($file)) {

        $file = File::get($file);
        $response = Response::make($file, 200);
        // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)
        $response->header('Content-Type', 'application/pdf');

        return $response;
    }

}