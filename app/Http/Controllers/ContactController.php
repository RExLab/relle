<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App;
use Input;
use Mail;
use Session;
use Illuminate\Support\MessageBag;

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
class ContactController extends Controller {

    /**
     * @return \Illuminate\View\View
     */
    public function send() {
        $errors = new MessageBag;

        try {
            $data = Input::all();
            Session::put('data', $data);

            Mail::send('mail.contact', $data, function($message) {
                $message->to('rexlabufsc@gmail.com', session('data')['name'])->subject('Contato RELLE ' . session('data')['name']);
            });
            
        } catch (Exception $e) {
            $errors->add('error', trans('message.contact_error'));
            return redirect()->back()->withErrors($errors);
        }
        Session::pull('data');
        return redirect('contact')->withErrors(['sent' => trans('message.contact_sent')]);
    }

}
