<?php

Route::get('newip', function() {
    return print_r(Location::get('179.108.171.203'));
});

Route::get('/en', function() {
    Session::put('lang', 'en');
    return redirect(url(URL::previous()));
//link_to_route(URL::previous())->parameters();    
});
Route::get('/pt', function() {
    Session::put('lang', 'pt');
    return redirect(url(URL::previous()));
});
Route::get('/', 'HomeController@index');
//Route::get('/',  ['middleware' => 'home', 'uses' => 'HomeController@index']);

Route::get('/login', 'PagesController@login');
Route::post('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::get('/login/forgot', 'AuthController@forgot');
Route::post('/login/forgot', 'AuthController@sendPass');
Route::get('/login/guest', 'AuthController@guest');

Route::get('/password/reset/{token}', 'AuthController@reset');
Route::post('/password/reset/', 'PasswordController@reset');

Route::post('map', 'LogController@map');

Route::get('cam', function() {
    //return view('welcome');
    return Request::server('HTTP_ACCEPT_LANGUAGE')[0] . Request::server('HTTP_ACCEPT_LANGUAGE')[1];
});

Route::get('pais', 'LogController@get1');

/*
 * PORTUGUÊS
 */

/*
 * Pages
 */
Route::get('/sobre', 'PagesController@about');
Route::get('/contato', 'PagesController@contact');

/*
 * Dashboard
 */
Route::get('/controle', ['middleware' => 'auth', 'uses' => 'PagesController@dashboard']);

/*
 * Labs
 */
//All Labs
Route::get('/experimentos', function() {
    return redirect('/');
});
//Search Lab
Route::post('/experimentos', 'LabsController@search');
// /labs/something
Route::group(array('prefix' => 'experimentos'), function() {

//Create Lab
    Route::get('/criar', ['middleware' => 'admin', 'uses' => 'LabsController@create']);
//Store Lab
    Route::post('/criar', 'LabsController@store');
// All Labs
    Route::get('/todos', ['middleware' => 'admin', 'uses' => 'LabsController@all']);
//Edit
    Route::get('/{id}/editar', ['middleware' => 'admin', 'uses' => 'LabsController@edit']);
    Route::post('/{id}/editar', 'LabsController@doEdit');
//Delete
    Route::post('/dodelete', ['middleware' => 'auth', 'uses' => 'LabsController@doDelete']);
    Route::get('/{id}/excluir', ['middleware' => 'admin', 'uses' => 'LabsController@delete']);
//Lab page
    Route::get('/{id}', 'LabsController@lab');
//Route::get('/{id}', ['middleware' => 'guest', 'uses' => 'LabsController@lab']);
});

Route::get('/usuarios', 'UsersController@all');

Route::group(array('prefix' => 'usuarios'), function() {
    Route::get('/criar', ['middleware' => 'admin', 'uses' => 'UsersController@create']);
    Route::get('/editar', ['middleware' => 'auth', 'uses' => 'UsersController@edit']);
    Route::get('/excluir', ['middleware' => 'auth', 'uses' => 'UsersController@delete']);
    Route::get('/{id}/excluir', ['middleware' => 'admin', 'uses' => 'UsersController@deleteOther']);
    Route::post('/create', ['middleware' => 'admin', 'uses' => 'UsersController@store']);
    Route::post('/editar', ['middleware' => 'admin', 'uses' => 'UsersController@doEdit']);
    Route::post('/dodelete', ['middleware' => 'admin', 'uses' => 'UsersController@doDelete']);
    Route::get('/cadastrar', 'UsersController@signUp');
    Route::post('/cadastrar', 'UsersController@doSignUp');
    Route::get('/{id}/editar', ['middleware' => 'admin', 'uses' => 'UsersController@editOther']);
});
//
//Reports
Route::get('/experimentos/{id}/relatorio', 'ReportsController@reports');
Route::post('/experimentos/{id}/relatorio', 'ReportsController@reports');




/*
 * ENGLISH
 */

/*
 * Pages
 */
Route::get('/about', 'PagesController@about');
Route::get('/contact', 'PagesController@contact');

/*
 * Dashboard
 */
Route::get('/dashboard', ['middleware' => 'auth', 'uses' => 'PagesController@dashboard']);

/*
 * Labs
 */
//All Labs
Route::get('/labs', ['middleware' => 'admin', 'uses' => 'LabsController@all']);

//Search Lab
Route::post('/labs', 'LabsController@search');
// /labs/something
Route::group(array('prefix' => 'labs'), function() {

//Create Lab
    Route::get('/create', ['middleware' => 'admin', 'uses' => 'LabsController@create']);
//Store Lab
    Route::post('/create', 'LabsController@store');
// All Labs
    Route::get('/all', ['middleware' => 'admin', 'uses' => 'LabsController@all']);
//Edit
    Route::get('/{id}/edit', ['middleware' => 'admin', 'uses' => 'LabsController@edit']);
    Route::post('/{id}/edit', 'LabsController@doEdit');
//Delete
    Route::post('/dodelete', ['middleware' => 'admin', 'uses' => 'LabsController@doDelete']);
    Route::get('/{id}/delete', ['middleware' => 'admin', 'uses' => 'LabsController@delete']);

    //Moodle
    Route::get('/{id}/moodle/', 'LabsController@moodle');
//Lab page
    Route::get('/{id}', 'LabsController@lab');
    
    
    Route::post('/export', 'LabsController@export_csv');
    Route::get('/export', 'LabsController@export_csv');  
});

Route::get('/users', 'UsersController@all');

Route::group(array('prefix' => 'users'), function() {
    Route::get('/create', ['middleware' => 'admin', 'uses' => 'UsersController@create']);
    Route::get('/edit', ['middleware' => 'auth', 'uses' => 'UsersController@edit']);
    Route::get('/delete', ['middleware' => 'auth', 'uses' => 'UsersController@delete']);
    Route::get('/{id}/delete', ['middleware' => 'admin', 'uses' => 'UsersController@deleteOther']);
    Route::post('/create', ['middleware' => 'admin', 'uses' => 'UsersController@store']);
    Route::post('/edit', ['middleware' => 'auth', 'uses' => 'UsersController@doEdit']);
    Route::post('/dodelete', ['middleware' => 'admin', 'uses' => 'UsersController@doDelete']);
    Route::get('/signup', 'UsersController@signUp');
    Route::post('/signup', 'UsersController@doSignUp');
    Route::get('/{id}/edit', ['middleware' => 'admin', 'uses' => 'UsersController@editOther']);
    Route::get('/import', 'UsersImportController@show');
    Route::post('/import', ['middleware' => 'admin', 'uses' => 'UsersImportController@import']);
    Route::get('/export', 'UsersImportController@export');
    Route::get('/bulk', ['middleware' => 'admin', 'uses' => 'UsersController@bulk']);
    Route::post('/admin', 'UsersController@admin');
    Route::post('/delete/bulk', 'UsersController@delete_bulk');
    Route::post('/export/bulk', 'UsersImportController@export_bulk');
});
//
//Reports
Route::get('/labs/{id}/report', 'ReportsController@reports');
Route::post('/labs/{id}/report', 'ReportsController@reports_post');

/** GeoIP - TEST
 * WORKING \o/
 * Route::get('geoip', function(){
  $location = GeoIP::getLocation($_SERVER["REMOTE_ADDR"]);

  return $location;
  });
 */
//Analytics (Reports)
//Lab Access
Route::post('analytics/labs_access', 'AnalyticsController@labsAccess');

//Country Access
Route::post('analytics/country_access', 'AnalyticsController@countryAccess');

//Web Browser Access
Route::post('analytics/browser_access', 'AnalyticsController@browserAccess');

//Mobile Access
Route::post('analytics/mobile_access', 'AnalyticsController@mobileAccess');



Route::group(array('prefix' => 'log'), function() {
    Route::post('put', 'LogController@put');
    Route::get('all', 'LogController@all');
    Route::post('end', 'LogController@end');
    Route::get('export', 'LogController@export');
});


Route::get('status', function() {
    $query = 'SELECT id FROM labs WHERE maintenance = "1"';
    $status = DB::select($query);

    return $status;
});

Route::post('contact', 'ContactController@send');

Route::get('doc/{name}', function() {
    return "<script>"
            . "window.open(" . asset('doc/' . Route::getCurrentRoute()->parameters()[0]) . ",'_blank');"
            . "</script>";
});

Route::get('flab', function() {
    return view('labs.flab');
});

Route:post('loggedin', function() {
    if (Auth::user()) {
        $info = [
                'avatar' => asset(Auth::user()->avatar),
                'name' => Auth::user()->firstname
            ];
        echo json_encode($info);
    } else {
        echo json_encode(false);
    }
});
Route::get('labx', function(){
    return redirect('/labs/4');
});


Route::group(array('prefix' => 'arduino'), function() {
    Route::post('upload', 'ArduinoController@upload');
    Route::post('download', 'ArduinoController@download');
    Route::post('get', 'ArduinoController@get');
});

if(App::getLocale()=='pt'){
    Route::get('tutorial', function(){
        return view('tutorial_pt');
    });
}else{
    Route::get('tutorial', function(){
        return view('tutorial_en');
    });
}

