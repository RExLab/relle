<?php

namespace App\Http\Controllers;

use App\Labs;
use App\Docs;
use App\Instances;
use App\DocsLabs;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Image;
use File;
use DB;
use App;
use Route;
use Input;
use Validator;
use App\Log;
use Auth;
use Excel;
use ExcelFile;

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
    public function show() {

        $labs = Labs::all();

        return view('labs.all', compact('labs'));
    }

    public function labs_page() {

        //$labs = Labs::all();
        $labs = DB::table('labs')->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('instances')
                      ->whereRaw('instances.lab_id = labs.id');
            })
            ->get();



        return view('all_labs', compact('labs'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create() {

        return view('labs.create');
    }
    
    
     public function createInstance() {
        $nameLang = "name_".App::getLocale();
        $labs = Labs::lists($nameLang, 'id');

        return view('labs.create_instance', compact('labs'));
    }

    
    /**
     * Stores Instance data
     *
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
     public function storeInstance()
     {
         /*
        test instances after to do all
         */
         
         $input = Request::all();
        
         $rules = [
             'lab_id' => 'required',
             'description' => 'required',
             'address' => 'required',
             'duration' => 'required',
             'queue' => 'required',
         ];
         
          $validator = Validator::make($input, $rules);
        if ($validator->fails() or empty($input['package'])) {

        // get the error messages from the validator
            $messages = $validator->messages();

        // redirect our user back to the form with the errors from the validator
            return redirect('labs/create')
                            ->withInput()
                            ->withErrors($validator);
        } else {

            // Unzip this instance
            unzipLab($input['package']->getRealPath(), $input['lab_id'], getLastInstance($input['lab_id']));
            $input['id'] = getLastInstance($input['lab_id']);
            // Maintenance executation
            if (array_key_exists("maintenance", $input))
                ($input['maintenance'] == 'on') ? $input['maintenance'] = '1' : $input['maintenance'] = '0';
            else
                $input['maintenance'] = '0';
            if (array_key_exists("queue", $input))
                ($input['queue'] == 'on') ? $input['queue'] = '1' : $input['queue'] = '0';
            else
                $input['queue'] = '1';
                Labs::where('id', '=', $input['lab_id'])->update(['queue' => 1]);

            

            Instances::create($input);
            return redirect('labs');
        }
     }

    /**
     * Stores Labs data
     *
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store() {

        $input = Request::all();

        $rules = [
            'name_pt' => 'required',
            'name_en' => 'required',
            'name_es' => 'required',
            'description_pt' => 'required',
            'description_en' => 'required',
            'description_es' => 'required',
            'tags' => 'required',
            'duration' => 'required',
            'target' => 'required',
            'subject' => 'required',
            'difficulty' => 'required',
            'interaction' => 'required',
            'thumbnail' => 'required',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {

        // get the error messages from the validator
            $messages = $validator->messages();

        // redirect our user back to the form with the errors from the validator
            return redirect('labs/create')
                            ->withInput()
                            ->withErrors($validator);
        } else {

        //Image handling
            $tmp_path = $input['thumbnail']->getRealPath();
            $extension = $input['thumbnail']->getClientOriginalExtension();

            $path = '/img/exp/' . uniqid() . '.' . $extension;
            Image::make($tmp_path)->save(base_path() . '/public' . $path);
        //Image::make($tmp_path)->resize(240, 180)->save(base_path().'/public'.$path);
            $input['thumbnail'] = $path;

        //Array
            $input['target'] = arrayToString($input['target']);
            $input['subject'] = arrayToString($input['subject']);
            $input['id'] = getLastLabId();
            
            Labs::create($input);

            return redirect('/labs/create/instance');
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function search() {

        $input = Request::all();

//return var_dump($input);
        if (
                empty($input['terms']) &&
                !array_key_exists('target', $input) &&
                !array_key_exists('subject', $input) &&
                !array_key_exists('difficulty', $input) &&
                !array_key_exists('interaction', $input)
        ) {

            return $this->show();
        } else {
            $labs = searchLabs($input);

            return view('all_labs', compact('labs'));
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function lab() {
        $id = Route::getCurrentRoute()->parameters();
        $exp = Labs::find($id)[0];
        // $instance = Instances::where('lab_id', $id)->orderBy('lab_id', 'asc')->get();

       // var_dump($instance);

        $exp['lang'] = App::getLocale();


        $array = DocsLabs::where('lab_id', $id)->get();
        $docs = ['tec' => [], 'did' => []];

        foreach ($array as $one) {
            $doc = Docs::find($one['doc_id'])->toArray();
            if ($doc['type'] == 'manual') {
                array_push($docs['tec'], $doc);
            } else {
                array_push($docs['did'], $doc);
            }
        }


        //Sugestions
        $suggestions = labsSuggestion($exp['subject'], 4, $id);

        if ($exp['maintenance'] == 1) {
            if (Auth::check()) {
                if (!admin()) {
                    return redirect('/');
                } else {
                    return view('labs.one', ['exp' => $exp, 'docs' => $docs, 'suggestions' => $suggestions]);
                }
            } else {
                return redirect('/');
            }
        } else {

            return view('labs.one', ['exp' => $exp, 'docs' => $docs, 'suggestions' => $suggestions]);
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function all() {
        $labs = DB::select('select * from labs');

        return view('labs.all_dash', compact('labs'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function edit() {
        $id = Route::getCurrentRoute()->parameters()['id'];
        $data['lab'] = Labs::find($id);
        $data['docs'] = Docs::all();
        $data['instances'] = Instances::where('lab_id', $id)->orderBy('lab_id', 'asc')->get();
        
       //   var_dump($data['instances']);
        $array = DocsLabs::where('lab_id', $id)->get();
        $docs = '';
        foreach ($array as $one) {
            $docs.=$one['doc_id'] . ', ';
        }

        $data['labs_docs'] = $docs;
        
        return view('labs.edit', compact('data'));
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doEdit() {
        $input = Request::all();
        
        $lab = Labs::find($input['id']);
        $instance = Instances::where('lab_id', $input['id'])->orderBy('lab_id', 'asc')->get();
        
        //Image handling
        if (empty($input['thumbnail'])) {
            $input['thumbnail'] = $lab->thumbnail;
        } else {
            $tmp_path = $input['thumbnail']->getRealPath();
            $extension = $input['thumbnail']->getClientOriginalExtension();

            $path = '/img/exp/' . uniqid() . '.' . $extension;
            //Image::make($tmp_path)->save(base_path() . '/public' . $path);
            Image::make($tmp_path)->resize(null, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save(base_path() . '/public' . $path);
            $input['thumbnail'] = $path;
        }


        //Array
        $input['target'] = arrayToString($input['target']);
        $input['subject'] = arrayToString($input['subject']);

        //Package
        foreach($instance as $instances){
            if (!empty($input['package'.$instances->id])) {
                File::deleteDirectory(public_path('exp_data/'. $lab->id ."/". $instances->id));
                unzipLab($input[$instances->id]->getRealPath(), $lab->id, $instances->id);
                unset($input[$instances->id]);
            }
        }

        unset($input['_token']);
        
        // Maintenance and queue switchies
        foreach($instance as $instances){
        if (array_key_exists("maintenance".$instances->id, $input))
            ($input['maintenance'.$instances->id] == 'on') ? $input['maintenance'.$instances->id] = '1' : $input['maintenance'.$instances->id] = '0';
        else
            $input['maintenance'.$instances->id] = '0';

        if (array_key_exists("queue".$instances->id, $input))
            ($input['queue'.$instances->id] == 'on') ? $input['queue'.$instances->id] = '1' : $input['queue'.$instances->id] = '0';
        else
            $input['queue'.$instances->id] = '1';

        }

        // Docs
        if (!empty($input['docs'])) {
            $old = DocsLabs::where('lab_id', $input['id'])->delete();

            $docs = explode(',', $input['docs']);
            if (!empty($docs)) {
                foreach ($docs as $doc) {
                    $doclab = new DocsLabs();
                    $doclab->doc_id = $doc;
                    $doclab->lab_id = $input['id'];

                    $doclab->save();
                }
            }
        }

        unset($input['docs']);
         
        //Instances table update
        foreach ($instance as $instances){
            Instances::where(['lab_id' => $lab->id, 'id' => $instances->id])
            ->update(['description' => $input['description'.$instances->id], 'address' => $input['address'.$instances->id],
            'duration' => $input['duration'], 'maintenance' => $input['maintenance'.$instances->id]]);

            // Push instances elements on the array of input
            unset($input['description'.$instances->id]);
            unset($input['address'.$instances->id]);
            unset($input['queue'.$instances->id]);
            unset($input['maintenance'.$instances->id]);
        }
        
        //Labs table update
        Labs::where('id', '=', $input['id'])->update($input);
        return redirect('labs');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function instance() {
        $id = Route::getCurrentRoute()->parameters()['id'];
        $instances = Instances::where('lab_id', $id)->orderBy('lab_id', 'asc')->get(); 
        
        return view('labs.instance', compact('id', 'instances'));
    }

    public function delete() {
        $id = Route::getCurrentRoute()->parameters()['id'];
        $lab_id = Route::getCurrentRoute()->parameters()['lab_id'];
        return view('labs.delete', compact('id', 'lab_id'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doDelete() {
        $req = Input::all();
        
        Instances::where(['lab_id' => $req['lab_id'], 'id' => $req['id']])->delete();
        
        $labs = Instances::where('lab_id', $req['lab_id'])->count();
        
        if($labs == 0){
            Labs::find($req['lab_id'])->delete();
            File::delete(public_path() . $lab->thumbnail);
        }

        /*      Exclusão dos arquivos no servidor       */
        File::deleteDirectory(public_path('exp_data/'. $req['lab_id'] ."/". $req['id']));
        File::deleteDirectory(base_path() . '/resources/views/reports/'. $req['lab_id'] ."/". $req['id']);

//        File::delete(public_path() . $lab->thumbnail);
//        File::deleteDirectory(public_path() . '/exp_data/' . $lab->id);
//        File::deleteDirectory(base_path() . '/resources/views/reports/' . $lab->id);

        return redirect('labs/all');
    }

    /**
     * @return \Illuminate\View\View
     */
    function moodle() {
        $id = Route::getCurrentRoute()->parameters();
        $exp = Labs::find($id)[0];
        $exp['lang'] = App::getLocale();
        return view('labs.moodle', compact('exp'));
    }

    /**
     * @return \Illuminate\View\View
     */
    function labsland() {
        $id = Route::getCurrentRoute()->parameters();
        $exp = Labs::find($id)[0];
        $exp['lang'] = App::getLocale();
        return view('labs.labsland', compact('exp'));
    }
    /**
     * @param $id
     * @return bool
     */
    function status($id) {
        $query = 'select e.lab_id from instances e where not exists (select null from instances i where e.lab_id = i.lab_id and `maintenance` = 0)';
        $out = DB::select($query);

        foreach ($out as $one) {
            if ($one->id == $id) {
                return false;
            }
        }
        return true;
    }

    function export_csv() {
        Excel::create('data', function($excel) {

            $excel->sheet('data sheet', function($sheet) {

                $sheet->fromArray(Input::all());
            });
        })->export('csv');
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=data.csv");
    }

}
