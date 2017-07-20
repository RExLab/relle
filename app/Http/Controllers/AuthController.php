<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Auth;
use Illuminate\Support\MessageBag;
use Mail;
use App\User;
use Session;
use Response;
use Redirect;
use DB;
use Route;
use App;


class AuthController extends Controller {

    public function login() {

        // create our user data for the authentication
        $userdata = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );
        // attempt to do the login
        if (Auth::attempt($userdata, (Input::get('remeberme') == 'on') ? true : false)) {
            $goto = Redirect::intended('/')->getTargetUrl();
            return Response::json(['goto' => $goto]); 
        } else {
            return Response::json(['errors' => ['password' => trans('message.login')]]);

            // validation not successful, send back to form 
            //return redirect('login')->withErrors($errors)->withInput(Input::except('password'));
        }
    }

    // }

    public function logout() {
        Auth::logout(); // log the user out of our application
        //keep language preferences
        $lang = session('lang');
        Session::flush();
        Session::put('lang', $lang);
        //logout moodle
        //return redirect('http://relle.ufsc.br/moodle/login/auth_logout.php'); 
        return view('login.logout'); 
    }

    public function forgot() {
        return view('login.forgot');
    }

    public function reset() {
        $token = Route::getCurrentRoute()->parameters();
        return view('login.reset')->with($token);
    }

    public function sendPass() {
        $input = Input::all();
        $user = User::where('email', '=', $input['email'])->first();
        $errors = new MessageBag;

        if ($user) {
            try {
                $user = $user->toArray();
                $data ['username'] = $user['username'];
                $data['token'] = $input['_token'];
                $data['firstname'] = $user['firstname'];
                $data['lastname'] = $user['lastname'];
                $data['email'] = $user['email'];
                Session::put('data', $data);

                Mail::send('mail.reset_' . App::getLocale(), $data, function($message) {
                    $message->to(session('data')['email'], session('data')['firstname'], session('data')['lastname'])->subject(trans('login.forgot'));
                });

                DB::insert('INSERT INTO password_resets (email, token, created_at) values '
                        . '("' . $data['email'] . '", "' . $data['token'] . '", "' . time() . '")');
            } catch (Exception $e) {
                $errors->add('reset', trans('message.trans'));
                return redirect()->back()->withErrors($errors);
            }
            Session::pull('data');
            return redirect('login')->withErrors(['sent' => trans('message.sent')]);
        } else {
            Session::pull('data');
            $errors->add('email', trans('message.email'));
            return redirect()->back()->withErrors($errors);
        }
    }

}
