<?php

namespace App\Http\Controllers;

use Input;
use Cache;
use Carbon\Carbon;

class ArduinoController extends Controller {

    function download() {
        echo $_POST['code']; 
        $filename = $_POST['file'];
        if (!headers_sent()) {
            header("Content-type: text/plain");
            header("Content-Disposition: attachment; filename=".$filename);
            
        }
    }

    function upload() {

        $tmp_path = Input::file()[0]->getRealPath();
        $name = Input::file()[0]->getClientOriginalName();
        $final_name = pathinfo($name, PATHINFO_FILENAME) . '.ino';
        $code = [
            "code" => file_get_contents($tmp_path),
            'name' => $final_name
        ];
        //$expiresAt = Carbon::now()->addMinutes(10);
        //Cache::put('code', $file, $expiresAt);

        echo json_encode($code);
    }

    function run() {
        
    }

}
