<?php

namespace App\Http\Controllers;

use GeoIP;
use App\Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use App;
use DB;
use Excel;
use PDO;
class LogController extends Controller {

    public function all() {
        $logs = DB::table('logs')
                ->orderBy('start', 'desc')
                ->paginate(10);
        return view('log.all')->with('logs', $logs);
    }

    public function get() {
        $location = GeoIP::getLocation($_SERVER["REMOTE_ADDR"]);
        return $location;
    }

    public function get1() {
        $location = GeoIP::getLocation($_SERVER["REMOTE_ADDR"]);
        print_r($location);
        die;
    }

    public function put() {
        $input = Input::all();
        $local = LogController::get();

                
        $city = "";
        
        if (empty($local['city'])){
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $local['lat'] . ',' . $local['lon'] . '&sensor=false',
            CURLOPT_USERAGENT => 'My user agent'
        ));
        $resp = curl_exec($curl);
        $res1 = (array) json_decode($resp);

        var_dump($local['lat']);
        var_dump($local['lon']);

        $res1 = (array) $res1['results'][0];

        $res1 = (array) $res1['address_components'][3];
        var_dump($res1['long_name']);

        curl_close($curl);
        $city = $res1['long_name'];
        }else{
            $city = $local['city'];
        }
                
        $client = get_browser(null, true);
        if (isMobile($_SERVER['HTTP_USER_AGENT'])) {
            $client['mobile'] = true;
        } else {
            $client['mobile'] = false;
        }
        $entry = [
            'lab_id' => $input['lab_id'],
            'user_id' => $input['user_id'],
            'ip' => $local['ip'],
            'os' => $client['platform'],
            'browser' => $client['browser'],
            'mobile' => $client['mobile'],
            'language' => App::getLocale(),
            'country' => $local['isoCode'],
            'city' => $city,
            'lon' => $local['lon'],
            'lat' => $local['lat']
        ];
        Log::create($entry);
        exit;
    }

    public function end() {
        echo ("<p>Laraiaiaaa!!</p>");

        $input = Input::all();

        $start = (array) DB::table('logs')->orderBy('start', 'desc')->take(1)->get()[0];

       $timezone  = -3;

        DB::table('logs')
                ->where('lab_id', $input['lab_id'])
                ->where('start', $start['start'])
                ->update(array('end' => gmdate("Y-m-j H:i:s", time() + 3600*($timezone+date("I")))));
        exit;
    }

    public function map() {
        $json = Log::select('lat', 'lon')
                        ->whereNotNull('lat')
                        ->whereNotNull('lon')
                        ->where('lat', '<>', '')
                        ->where('lon', '<>', '')
                        ->get()->toArray();
        $json = json_encode($json);
        echo $json;
    }
    
    function export() {
        Excel::create('Logs', function($excel) {
            $excel->sheet('Logs', function($sheet) {
                DB::setFetchMode(PDO::FETCH_ASSOC);
                $logs = DB::table('logs')->get();
                $sheet->fromArray($logs);
            });
        })->export('csv');
    }
}
