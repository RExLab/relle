<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Praticas_circuitos;
use App\Http\Requests;
use Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Request;
use DB;
use App;
use Input;
use File;
use Image;

class RepositorioController extends Controller {

    public function funcao() {

        $praticas = Praticas_circuitos::all();

        return view('repositorio', compact('praticas'));
        // return redirect('/repositorio');
    }

    public function searchpraticas() {

        $input = Request::all();
        if (
                empty($input['terms']) &&
                !array_key_exists('descri', $input) &&
                !array_key_exists('nome', $input)
        ) {
            $mensagem =  "Não foram retornados resultados";
            return view('repositorio',  compact('mensagem'));
        } else {
            $praticas = searchpraticas($input);
            return view('repositorio', compact('praticas'));
        }
    }

    public function criarpratica() {

        return view('create_practice');
    }

    public function createpratica() {
        
        $input = Request::all();
        
        $rules = [
            'nome' => 'required',
            'descri' => 'required', 
            'img_visir' => 'required',
            'img_diagrama' => 'required',
            'arquivo' => 'required',
        ];
        
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $messages = $validator->messages();
            
             return redirect('create_practice')
                            ->withInput()
                            ->withErrors($validator);
        }
        
   
        
        $tmp_path = $input['img_visir']->getRealPath();
        $extension = $input['img_visir']->getClientOriginalExtension();
        $pathimgvisir = '/img/' . uniqid() . '.' . $extension;
        Image::make($tmp_path)->save(base_path() . '/public' . $pathimgvisir);
        

        $tmp_path1 = $input['img_diagrama']->getRealPath();
        $extension = $input['img_diagrama']->getClientOriginalExtension();
        $pathimgdiagrama = '/img/' . uniqid() . '.' . $extension;
        Image::make($tmp_path1)->save(base_path() . '/public' . $pathimgdiagrama);
        
        $file = $input['arquivo'];
        $tmp_path2 = $input['arquivo']->getRealPath();
        $extension = $input['arquivo']->getClientOriginalExtension();
        $patharquivo = 'files/' . uniqid() . '.' . $extension;
        $path = 'files/';
        Input::file('arquivo')->move(public_path().'/'.$path,$patharquivo);
        /*$teste = move_uploaded_file($tmp_path2, $patharquivo);
         */
       $input['img_visir'] = '/teste/' . $pathimgvisir;
       $input['img_diagrama']= '/teste/' . $pathimgdiagrama ;
       $input['arquivo'] = '/teste' . $patharquivo;
       Praticas_circuitos::create($input);
        
       return view('create_practice');
    }

}
