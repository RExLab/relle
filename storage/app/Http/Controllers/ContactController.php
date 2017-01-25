<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App;
use Input;


//use App\Http\Requests\CreateLabFormRequest;

/**
 * Labs Controller
 *
 * The Labs Controller class is responsible for handling requests to the Labs database, in addition to managing the Labs views.
 * 
 * @category Controllers
 * @package App\Http\Controllers
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @version 1.0
 * @author José Simão <josepedrosimao@gmail.com>
 */
class LabsController extends Controller {

    /**
     * @return \Illuminate\View\View
     */
    public function send() {
        $input = Input::all();


        Mail::send('mail.reset_' . App::getLocale(), $data, function($message) {
            $message->to(session('data')['email'], session('data')['firstname'], session('data')['lastname'])->subject(trans('login.forgot'));
        });


        $errors->add('reset', trans('message.trans'));
        return redirect()->back()->withErrors($errors);

        return redirect('login')->withErrors(['sent' => trans('message.sent')]);
        Session::pull('data');
        $errors->add('email', trans('message.email'));
        return redirect()->back()->withErrors($errors);
    }
}
