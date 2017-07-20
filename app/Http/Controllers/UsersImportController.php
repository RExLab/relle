<?php

namespace App\Http\Controllers;

use App;
use App\User;
use Excel;
use ExcelFile;
use Input;
use DB;
use PDO;
use Config;

class UsersImportController extends Controller {

    public function show() {
        return view('users.import');
    }

    public function import() {

        $form = Input::all();
        $file = $form['file']->getRealPath();
        Config::set('Excel::csv.delimiter', ';');
        Config::set('Excel::csv.lineEnding', '\n');
        Excel::load($file, function($reader) {

            $user = new User();

            $results = $reader->get()->toArray();

            foreach ($results as $input) {
                if (!empty($input['username'])) {
                    unset($input['0']);
                    /*
                      $course='';
                      $course_val='';
                      $group='';
                      $group_val='';
                      if(array_key_exists('course1', $input)){
                      $course = ', course1';
                      $course_val = $input['course1'];
                      unset($input['course1']);
                      }

                      if(array_key_exists('group1', $input)){
                      $group = ', group1';
                      $group_val = $input['group1'];
                      unset($input['group1']);
                      }
                     */
                    //print_r($input); die;

                    User::create($input);

                    /*
                     * $input['password'] = bcrypt($input['password']);

                      $moodle = 'INSERT INTO mdl_user (auth, confirmed, policyagreed, mnethostid, username, password, firstname, lastname, email'. $course . $group . ')' .
                      "VALUES ('manual', '1', '1', '1','" . $input['username'] . "', '" . $input['password'] . "', '" . $input['firstname'] . "', '" . $input['lastname'] . "', '" . $input['email'] . "')";

                      moodle_db($moodle);
                     * */
                }
            }
        });
        User::where('username', '=', '')->delete();
        return redirect('/users');
    }

    function export() {
        $users = DB::table('users')->get();

        Excel::create('Users', function($excel) {

            $excel->sheet('Users', function($sheet) {
                DB::setFetchMode(PDO::FETCH_ASSOC);
                $users = DB::table('users')
                        ->select(
                                'username', 'email', 'firstname', 'lastname', 'password', 'organization', 'country', 'type'
                        )
                        ->get();
                $sheet->fromArray($users);
            });
        })->export('csv');
    }

    function export_bulk() {

        Excel::create('Users', function($excel) {
            $excel->sheet('Users', function($sheet) {
                
                $input = Input::all();
                $users = explode(',', $input['users']);

                DB::setFetchMode(PDO::FETCH_ASSOC);
                $query = 'SELECT username, email, firstname, lastname ,password, organization,country, type FROM users WHERE';
                $n = count($users);
                if ($n == 1) {
                    $query.=' username = "' . $users[$i] . '"';
                } else {
                    for ($i = 0; $i < $n; $i++) {
                        if ($i < $n - 1) {
                            $query.=' username = "' . $users[$i] . '" OR';
                        } else {
                            $query.=' username = "' . $users[$i] . '"';
                        }
                    }
                }

                $data = DB::select($query);
                $sheet->fromArray($data);
            });
        })->download('csv');
    }

}
