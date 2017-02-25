<?php

namespace App\Http\Controllers;

use App\Docs;
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
use URL;
/**
 * Docs Controller
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

class DocsController extends Controller {

    /**
     * @return \Illuminate\View\View
     */
    public function show() {

        $docs = Docs::paginate(15);

        return view('docs.all', compact('docs'));
    }
     public function labs_page() {

        $labs = Labs::all();

        return view('all_labs', compact('labs'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create() {

        return view('docs.create');
    }

    /**
     * Stores Labs data
     *
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store() {

        $input = Request::all();
        
        //print_r($input); die;
        

        $rules = [
            'title' => 'required',
            'type' => 'required',
            'lang' => 'required',
            'file' => 'required',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails() or empty($input['file'])) {

            // redirect our user back to the form with the errors from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return redirect(url(URL::previous()))->withErrors($validator);
        } else {
            
            $new['title'] = $input['title'];
            $new['tags'] = $input['tags'];
            $new['type'] = $input['type'];
            $new['lang'] = $input['lang'];
            $new['format'] = Input::file('file')->getClientOriginalExtension();
            $new['size'] = Input::file('file')->getSize();
            
            
            $tmp_path = Input::file('file')->getRealPath();
            $fileName = uniqid() . '.' . $new['format'];
            $path = 'docs/';
            Input::file('file')->move(public_path().'/'.$path, $fileName);
            
            $new['url'] = $path . $fileName;
            Docs::create($new);
                       
            return redirect('docs/all');
            
            /*
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
            if (isset($input['maintenance']))
                ($input['maintenance'] == 'on') ? $input['maintenance'] = '1' : $input['maintenance'] = '0';
            ($input['queue'] == 'on') ? $input['queue'] = '1' : $input['queue'] = '0';

            Labs::create($input);
            return redirect('labs');
             */
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

            //return var_dump($labs);

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
        if ($exp['maintenance'] == 1) {
            if (Auth::check()) {
                if (Auth::user()->username == 'fpuntel' || Auth::user()->username == 'marisa.cavalcante') {
                    return view('labs.one', compact('exp'));
                } else if (!admin()) {
                    return redirect('/');
                } else {
                    return view('labs.one', compact('exp'));
                }
            } else {
                return redirect('/');
            }
        } else {
            return view('labs.one', compact('exp'));
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
        $lab = Labs::find(Route::getCurrentRoute()->parameters()['id']);

        return view('labs.edit', compact('lab'));
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doEdit() {
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
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();


            // redirect our user back to the form with the errors from the validator
            return redirect('labs/' . $input['id'] . '/edit')
                            ->withErrors($validator);
        } else {


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
            //echo $input['maintenance'];die;

            if (array_key_exists("maintenance", $input))
                ($input['maintenance'] == 'on') ? $input['maintenance'] = '1' : $input['maintenance'] = '0';
            if (array_key_exists("queue", $input))
                ($input['queue'] == 'on') ? $input['queue'] = '1' : $input['queue'] = '0';


            Labs::where('id', '=', $input['id'])->update($input);
            return redirect('labs');
        }
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
