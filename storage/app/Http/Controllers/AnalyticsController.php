<?php

namespace App\Http\Controllers;

use DB;
use App;
use App\Labs;
use App\Http\Controllers\Controller;

/**
 * The Analytics Controller class is responsible for handling the analisys and representation from log data.
 * 
 * @category Labs
 * @package App\Http\Controllers
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @version 1.0
 * @author Lucas Mellos <josepedrosimao@gmail.com>
 */
class AnalyticsController extends Controller {

    public $colors = array("#F7464A", "#46BFBD", "#FDB45C", "#9D9B7F", "#7D4F6D", "#584A5E", "#29A329", "#66FFCC", "#FFFF00", "#99CC00", "#003366", "#FFFF66", "#FF9933", "#660033", "#FF99FF", "#990033", "#5C0099");

    function labsAccess() {

        //$data = DB::select('SELECT lab_id, COUNT(lab_id) FROM logs WHERE  YEARWEEK(`start`, 1 ) = YEARWEEK(CURDATE(), 1 ) GROUP BY lab_id '); //SELECT lab_id, COUNT(lab_id) FROM logs WHERE START BETWEEN CURRENT_DATE() -7 AND CURRENT_DATE()  GROUP BY lab_id');
        $data = DB::select('SELECT lab_id, COUNT(lab_id) FROM logs GROUP BY lab_id '); //SELECT lab_id, COUNT(lab_id) FROM logs WHERE START BETWEEN CURRENT_DATE() -7 AND CURRENT_DATE()  GROUP BY lab_id');

        $name = "name_" . App::getLocale();
        $output = array();
        $value = "COUNT(lab_id)";
        $i = 0;
        foreach ($data as $lab) {
            $one = Labs::find($lab->lab_id);
            $output[$i]['value'] = intval($lab->$value);
            $output[$i]['color'] = $this->colors[$i];
            $output[$i]['title'] = $one[$name];
            $i++;
        }

        echo json_encode($output);
    }

    function countryAccess() {
        $data = DB::select('SELECT  UPPER(`country`) , COUNT(`country`) FROM `logs` WHERE YEARWEEK(`start`, 1 ) = YEARWEEK(CURDATE() , 1 )  GROUP BY  `country`');
        $output = array();
        $value = "COUNT(`country`)";
        $country = "UPPER(`country`)";
        $i = 0;

        foreach ($data as $place) {
            $output[$i]['value'] = $place->$value;
            $output[$i]['color'] = $this->colors[$i];
            $output[$i]['title'] = $place->$country;
            $i++;
            if ($i > 8)
                $i = 0;
        }
        echo json_encode($output);
    }

    function browserAccess() {
        //$data = DB::select('SELECT CONCAT(UCASE(SUBSTRING(`browser`, 1, 1)), LCASE( SUBSTRING(`browser`, 2 ))) , COUNT(`browser`) FROM  `logs` WHERE YEARWEEK(`start` , 1 ) = YEARWEEK(CURDATE(), 1) GROUP BY  `browser`');
        $data = DB::select('SELECT CONCAT(UCASE(SUBSTRING(`browser`, 1, 1)), LCASE( SUBSTRING(`browser`, 2 ))) , COUNT(`browser`) FROM  `logs` GROUP BY  `browser`');
        $output = array();
        $value = "COUNT(`browser`)";
        $mobile = "CONCAT(UCASE(SUBSTRING(`browser`, 1, 1)), LCASE( SUBSTRING(`browser`, 2 )))";
        $i = 0;

        foreach ($data as $web) {
            $output[$i]['value'] = $web->$value;
            $output[$i]['color'] = $this->colors[$i];
            $output[$i]['title'] = $web->$mobile;
            $i++;
        }
        echo json_encode($output);
    }

    function mobileAccess() {
        $lang = App::getLocale();
        $queryTrue = "";
        $queryFalse = "";
        if ($lang == "pt") {
            $queryTrue = "Dispositivos Móveis";
            $queryFalse = "Desktop";
        } else {
            $queryFalse = "Desktop";
            $queryTrue = "Mobile";
        }
        //$data = DB::select('SELECT IF(mobile, "' . $queryTrue . '", "' . $queryFalse . '") , COUNT(`mobile`) FROM  `logs` WHERE YEARWEEK(`start`, 1 ) = YEARWEEK(CURDATE(), 1 ) GROUP BY `mobile` ');
        $data = DB::select('SELECT IF(mobile, "' . $queryTrue . '", "' . $queryFalse . '") , COUNT(`mobile`) FROM  `logs`  GROUP BY `mobile` ');

        $output = array();
        $value = "COUNT(`mobile`)";
        $mobile = 'IF(mobile, "' . $queryTrue . '", "' . $queryFalse . '")';
        $i = 0;

        foreach ($data as $web) {
            $output[$i]['value'] = $web->$value;
            $output[$i]['color'] = $this->colors[$i];
            $output[$i]['title'] = $web->$mobile;
            $i++;
        }
        echo json_encode($output);
    }

}
