<?php

namespace App\Http\Controllers;

use App\Labs;
use App\Docs;
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

        $labs = Labs::all();

        return view('all_labs', compact('labs'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create() {

        return view('labs.create');
    }
    
    
     public function create2() {

        return view('labs.create_new');
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
            'description_pt' => 'required',
            'description_en' => 'required',
            'tags' => 'required',
            'duration' => 'required',
            'target' => 'required',
            'subject' => 'required',
            'difficulty' => 'required',
            'interaction' => 'required',
            'thumbnail' => 'required',
            'package' => 'required',
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

//return var_dump($input);
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

//Package
            unzipLab($input['package']->getRealPath(), getLastLabId());
            
            
            if (array_key_exists("maintenance", $input))
                ($input['maintenance'] == 'on') ? $input['maintenance'] = '1' : $input['maintenance'] = '0';
            else
                $input['maintenance'] = '0';

            if (array_key_exists("queue", $input))
                ($input['queue'] == 'on') ? $input['queue'] = '1' : $input['queue'] = '0';
            else
                $input['queue'] = '1';

            
            Labs::create($input);

            return redirect('labs');
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
        if (!empty($input['package'])) {
            File::deleteDirectory(public_path('exp_data/' . $lab->id));
            unzipLab($input['package']->getRealPath(), $lab->id);
            unset($input['package']);
        }

        unset($input['_token']);


        if (array_key_exists("maintenance", $input))
            ($input['maintenance'] == 'on') ? $input['maintenance'] = '1' : $input['maintenance'] = '0';
        else
            $input['maintenance'] = '0';

        if (array_key_exists("queue", $input))
            ($input['queue'] == 'on') ? $input['queue'] = '1' : $input['queue'] = '0';
        else
            $input['queue'] = '1';



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

        Labs::where('id', '=', $input['id'])->update($input);
        return redirect('labs');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function delete() {
        $id = Route::getCurrentRoute()->parameters()['id'];

        return view('labs.delete', compact('id'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doDelete() {
        $req = Input::all();
        $lab = Labs::find($req['id']);

        File::delete(public_path() . $lab->thumbnail);
        File::deleteDirectory(public_path() . '/exp_data/' . $lab->id);
        File::deleteDirectory(base_path() . '/resources/views/reports/' . $lab->id);


        $log = Log::where('lab_id', $lab->id)->delete();
        $lab->delete();
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
     * @param $id
     * @return bool
     */
    function status($id) {
        $query = 'SELECT id FROM labs WHERE maintenance = "1"';
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
