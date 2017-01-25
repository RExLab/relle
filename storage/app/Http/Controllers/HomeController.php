<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Labs;

class HomeController extends Controller {

    public function index() {

        $labs = Labs::all();
        return view('home', compact('labs'));
    }

}
