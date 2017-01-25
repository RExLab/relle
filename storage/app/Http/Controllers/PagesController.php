<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class PagesController extends Controller {

    public function about() {

        return view('pages.about');
    }

    public function contact() {
        return view('pages.contact');
    }

    public function labs() {
        return view('labs.all');
    }

    public function dashboard() {
        return view('pages.dashboard');
    }

    public function login() {
        if (Auth::check() || session('guest')) {
            return redirect()->back();
        } else {
            return view('login.login');
        }
    }

    public function forgot() {
        return view('login.forgot');
    }

}
