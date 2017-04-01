<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Labs;
use App\Log;
use App\Subjects;
use App\SubjectsLabs;
use Input;
use DB;
use App;

class HomeController extends Controller {

    public function index() {

        $labs = Labs::all();
        /*
          $feature = [];
          $subjects = Subjects::all();
          foreach ($subjects as $one) {
          $rel = SubjectsLabs::select('*')
          ->where('subject_id', $one->id)->get();
          $lab_feature = [
          'id' => -1,
          'qtd' => 0
          ];
          foreach ($rel as $r) {
          $n = Log::where(['lab_id' => $r->lab_id])->count();
          if ($n > $lab_feature['qtd']) {
          $lab_feature['id'] = $r->lab_id;
          $lab_feature['qtd'] = $n;
          }
          }
          if ($lab_feature['id'] >= 0)
          $feature[$one->name] = Labs::find($lab_feature['id']);
          }
         */
        $users = DB::table('users')->get();

        $category_id = (App::getLocale() == 'pt') ? 5 : 2;

        $all_courses = array_map(function($item) {
            return (array) $item;
        }, DB::connection('moodle')
                        ->table('mdl_course')
                        ->where('category', $category_id)
                        ->where('visible', '1')
                        ->get()
        );
        $courses = [];


        $qtd = (5 <= count($all_courses)) ? '5' : count($all_courses);
        $nums=[];
        $i = 0;
        do {
            //$rand = rand(0, $qtd - 1);
           // if (!array_search($rand, $courses)) {
                array_push($courses, $all_courses[$i]);
                $i++;
            //}
        } while ($i < $qtd);

        return view('home', ['labs' => $labs, 'courses' => $courses]);
    }

    public function search() {

        $input = Input::all();
        $result['labs'] = searchLabs($input);
        $result['docs'] = searchDocs($input);

        /*
          print "<pre>";
          print_r($result);
          print "<\pre>";
          die;
         * 
         */
        return view('search_results', compact('result'));
    }

}
