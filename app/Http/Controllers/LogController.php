<?php

namespace App\Http\Controllers;

class LogController extends Controller {

    public function all() {
        return view('log.all');
    }
}