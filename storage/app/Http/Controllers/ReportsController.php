<?php

namespace App\Http\Controllers;

use Route;
use App;
use Input;
use Session;

class ReportsController extends Controller {

    public function reports() {
        $reportname = "";
        $rpijson = "";

        if (Session::has("data")) {
            $rpijson = Session::get("data");
        } else {
            echo "Error";
            die;
        }

        $exp = Route::getCurrentRoute()->parameters()['id'];   //ID Parameter
        $pdf = App::make('dompdf.wrapper');

        $pdf->loadHTML(view("reports." . $exp . ".report_" . App::getlocale() . "", compact("rpijson", "exp")));    //PDF Load

        if (App::getlocale() == "pt") {          //Report name
            $reportname = "Relatório";
        } else {
            $reportname = "Report";
        }

        return $pdf->stream($reportname);      //Return PDF
    }

    public function reports_post() {            //Post 
        Session::put('data', Input::all());
        return Input::all();
    }

}
