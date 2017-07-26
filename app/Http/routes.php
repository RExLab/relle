<?php



/*
 * Docs
 */
Route::group(array('prefix' => 'docs'), function() {
    Route::get('/create', ['middleware' => 'admin', 'uses' => 'DocsController@create']);
    Route::post('/create', ['middleware' => 'admin', 'uses' => 'DocsController@store']);
    Route::get('/all', 'DocsController@show');
});

//Search Bar  
Route::post('/search', 'HomeController@search');

Route::get('/new', 'HomeController@index');
Route::get('/repositorio', 'RepositorioController@funcao');
Route::post('/searchpraticas', 'RepositorioController@searchpraticas');
Route::get('/create_practice', 'RepositorioController@criarpratica');
Route::post('/createpratica', 'RepositorioController@createpratica');


Route::group(array('prefix' => 'booking'), function() {
    Route::get('/create', ['middleware' => 'teacher', 'uses' => 'BookingController@create']);
    Route::post('/create', ['middleware' => 'teacher', 'uses' => 'BookingController@store']);           
    Route::get('/all', ['middleware' => 'teacher', 'uses' => 'BookingController@show']);
    Route::delete('/all', ['middleware' => 'teacher', 'uses' => 'BookingController@delete']);
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


Route::get('/es', function() {
    Session::put('lang', 'es');
    return redirect(url(URL::previous()));
});
 



Route::get('/', 'HomeController@index');
//Route::get('/',  ['middleware' => 'home', 'uses' => 'HomeController@index']);

Route::get('/labs', 'LabsController@labs_page');

Route::get('/login', 'PagesController@login');
Route::post('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::get('/login/forgot', 'AuthController@forgot');
Route::post('/login/forgot', 'AuthController@sendPass');
Route::get('/login/guest', 'AuthController@guest');

Route::get('/password/reset/{token}', 'AuthController@reset');
Route::post('/password/reset/', 'PasswordController@reset');

Route::get('cam', function() {
    //return view('welcome');
    return Request::server('HTTP_ACCEPT_LANGUAGE')[0] . Request::server('HTTP_ACCEPT_LANGUAGE')[1];
});


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
Route::post('/contact', 'ContactController@contactForm');
/*
 * Dashboard
 */
Route::get('/dashboard', ['middleware' => 'auth', 'uses' => 'PagesController@dashboard']);

/*
 * Labs
 */
//All Labs







Route::group(array('prefix' => 'labs'), function() {

//Create Lab
    Route::get('/create', ['middleware' => 'admin', 'uses' => 'LabsController@create']);
    Route::get('/create/beta', ['middleware' => 'admin', 'uses' => 'LabsController@create2']);
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
    Route::get('/{id}/moodle', 'LabsController@moodle');
    //LabsLand
    Route::get('/{id}/labsland', 'LabsController@labsland');
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
    Route::post('/teacher', 'UsersController@teacher');
    Route::post('/delete/bulk', 'UsersController@delete_bulk');
    Route::post('/export/bulk', 'UsersImportController@export_bulk');
});

//Reports
Route::get('/labs/{id}/report', 'ReportsController@reports');
Route::post('/labs/{id}/report', 'ReportsController@reports_post');

Route::group(array('prefix' => 'log'), function() {
    Route::get('all', 'LogController@all');
});


Route::get('status', function() {
    $query = 'SELECT lab_id FROM instances WHERE maintenance = "1"';
    $status = DB::select($query);

    return $status;
});

Route::post('contact', 'ContactController@send');

Route::get('doc/{name}', function() {
    return "<script>"
            . "window.open(" . asset('doc/' . Route::getCurrentRoute()->parameters()[0]) . ",'_blank');"
            . "</script>";
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
