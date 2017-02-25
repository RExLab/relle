<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use App\User;
use App\Password;
use Validator;
use URL;

class PasswordController extends Controller {

    public function reset() {
        
        /*
         * Todo: password is not reseting
         */
        $input = Input::all();

        $rules = [
            'password' => 'required|min:5',
            'repeat' => 'required|min:5'
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return redirect(url(URL::previous()))->withErrors($validator);
        } else {
            $reset = Password::where('token', '=', $input['token'])->first();
            if ($reset) {
                try {
                    $reset = $reset->toArray();
                    $user = User::where('email', '=', $reset['email'])->update(['password' => bcrypt($input['password'])]);

                    $moodle = "UPDATE mdl_user SET "
                            . "password = '" . bcrypt($input['password']) . "' "
                            . "WHERE email = '" . $reset['email'] . "'";

                    moodle_db($moodle);
                    return redirect('login');
                } catch (Exception $e) {
                    echo $e->message;
                }
            } else {
                echo 'error';
            }
        }
    }

}
