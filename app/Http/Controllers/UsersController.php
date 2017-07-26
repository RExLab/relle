<?php

namespace App\Http\Controllers;

use App;
use App\User;
use App\Http\Requests;
use Request;
use DB;
use App\Http\Controllers\Controller;
use Image;
use Input;
use Validator;
use Auth;
use Route;
use File;
use URL;
use Redirect;

class UsersController extends Controller {

    public function all() {
        $users = DB::table('users')
                ->orderBy('username')
                ->paginate(10);

        return view("users.all", compact('users'));
    }

    public function create() {
        return view("users.create");
    }

    public function store() {
        $input = Input::all();

        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required|alphaNum|min:5',
            'repeat' => 'required|same:password|alphaNum|min:5',
            'type' => 'required'
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
        } else {


            //Image handling
            if (!empty($input['avatar'])) {
                $tmp_path = $input['avatar']->getRealPath();
                $extension = $input['avatar']->getClientOriginalExtension();

                $path = '/img/users/' . uniqid() . '.' . $extension;
                Image::make($tmp_path)->save(base_path() . '/public' . $path);
                //Image::make($tmp_path)->resize(240, 180)->save(base_path().'/public'.$path);
            } else {
                $path = '/img/default.gif';
            }
            $input['avatar'] = $path;
            $input['password'] = bcrypt($input['password']);
            
            $user = new User();
            $user->save($input); 
            
            User::where('username','')->delete();
            /*
             * Inserting on Moodle
             */
            $moodle = 'INSERT INTO mdl_user (auth, confirmed, policyagreed, mnethostid, username, password, firstname, lastname, email)' .
                    "VALUES ('manual', '1', '1', '1','" . $input['username'] . "', '" . $input['password'] . "', '" . $input['firstname'] . "', '" . $input['lastname'] . "', '" . $input['email'] . "')";

            moodle_db($moodle);

            return redirect('users');
        }
    }

    public function edit() {
        $users = Auth::user();
        return view("users.edit", compact('users'));
    }

    public function doEdit() {
        $input = Input::all();

        $rules = [
            'email' => 'required|email',
            'firstname' => 'required',
            'lastname' => 'required',
            'type' => 'required'
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return redirect(url(URL::previous()))->withInput()->withErrors($validator);
        } else {
            if (empty($input['avatar'])) {
                $input['avatar'] = Auth::user()->avatar;
            } else {
                $tmp_path = $input['avatar']->getRealPath();
                $extension = $input['avatar']->getClientOriginalExtension();

                $path = '/img/users/' . uniqid() . '.' . $extension;
                Image::make($tmp_path)->save(base_path() . '/public' . $path);
                $input['avatar'] = $path;
            }
            $input['password'] = bcrypt($input['password']);
            $user = User::find($input['id']);
            User::find($input['id'])->update($input);

            $moodle = "UPDATE mdl_user SET "
                    . "password = '" . $input['password'] . "', "
                    . "firstname = '" . $input['firstname'] . "', "
                    . "lastname = '" . $input['lastname'] . "', "
                    . "email = '" . $input['email'] . "' "
                    . "WHERE username = '" . $user['username'] . "'";
          
            moodle_db($moodle);

            return redirect('users');
        }
    }

    public function editOther() {
        $users = User::find(Route::getCurrentRoute()->parameters()['id']);
        return view("users.edit", compact('users'));
    }

    public function delete() {
        $id = Auth::user()->id;
        return view('users.delete', compact('id'));
    }

    public function deleteOther() {
        /*
         * TODO: implement soft deleting
         */
        $id = Route::getCurrentRoute()->parameters()['id'];
        return view('users.delete', compact('id'));
    }

    public function doDelete() {
        /*
         * TODO: implement soft deleting
         */
        $req = Input::all();
        $user = User::find($req['id']);
        if(!strpos($user->avatar, 'default'))
            File::delete(public_path() . $user->avatar);
        $user->delete();

        $moodle = "DELETE FROM mdl_user "
                . "WHERE username = '" . $user['username'] . "'";

        moodle_db($moodle);

        if ($req['id'] == Auth::user()->id) {
            Auth::logout();
            return redirect('/');
        } else {
            return redirect('users');
        }
    }

    public function signUp() {
        return view('users.signup');
    }

    public function doSignUp() {
        $input = Input::all();
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required|alphaNum|min:5',
            'repeat' => 'required|same:password|alphaNum|min:5',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
             return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
        } else {
            $input['type'] = 'user';

            //Image handling
            if (!empty($input['avatar'])) {
                $tmp_path = $input['avatar']->getRealPath();
                $extension = $input['avatar']->getClientOriginalExtension();

                $path = '/img/users/' . uniqid() . '.' . $extension;
                Image::make($tmp_path)->save(base_path() . '/public' . $path);
                //Image::make($tmp_path)->resize(240, 180)->save(base_path().'/public'.$path);
            } else {
                $path = '/img/default.gif';
            }
            $input['avatar'] = $path;
            $input['password'] = bcrypt($input['password']);

            User::create($input);
            
              /*
             * Inserting on Moodle
             */
            $moodle = 'INSERT INTO mdl_user (auth, confirmed, policyagreed, mnethostid, username, password, firstname, lastname, email)' .
                    "VALUES ('manual', '1', '1', '1','" . $input['username'] . "', '" . $input['password'] . "', '" . $input['firstname'] . "', '" . $input['lastname'] . "', '" . $input['email'] . "')";

            moodle_db($moodle);

            return redirect('dashboard');
        }
        
    }
    
    function bulk(){
        $users = User::all();
        return view('users.bulk', compact('users'));
    }
    
    function admin(){
        $input = Input::all();
        $users = explode(',',$input['users']);
        
        foreach($users as $user){
            User::where('username', $user)
                    ->where('type', '<>', 'admin')
                    ->update(['type'=>'admin']);
        }
    }
    
    function teacher(){
        $input = Input::all();
        $users = explode(',',$input['users']);

        foreach($users as $user){
            User::where('username', $user)
                    ->where('type', '<>', 'teacher')
                    ->update(['type'=>'teacher']);
        }
    }
    function delete_bulk(){
        /*
         * TODO: implement soft deleting
         */
        $input = Input::all();
        if(count($input)>1)
            $users = explode(',',$input['users']);
        else
            $users = $input;
        
        foreach($users as $user){
            User::where('username', $user)
                    ->forceDelete();
            $moodle = "DELETE FROM mdl_user "
                . "WHERE username = '" . $user . "'";
            moodle_db($moodle);
        }
        
        
    }
    
    

}
