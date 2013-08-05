<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user', 'User');
Route::model('autor', 'Autore');
Route::model('genero', 'Genero');
Route::model('material', 'Material');
Route::model('centro', 'Centro');

/** ------------------------------------------
 *  Dashboard Routes
 *  ------------------------------------------
 */

Route::group(array('prefix' => 'dashboard', 'before'=>'auth.sentry2'), function()
{
  // Dashboard
  Route::get('/', array('as' => 'dashboard', 'uses' => 'DashboardHomeController@getIndex'));

  // Authors management
  Route::get('autores/{criteria}/search', array('as' => 'dashboard.autores.search', 'uses' => 'DashboardAutoresController@getSearch'))
        ->where('criteria', '[a-z ñáéíóúA-Z]+');

  Route::bind('autores', function($id, $route){
    return Autore::with('user')->find($id);
  });
  Route::resource('autores', 'DashboardAutoresController');

  // Genres management
  Route::bind('generos', function($id, $route){
    return Genero::with('user')->find($id);
  });

  Route::get('generos/{criteria}/search', array('as' => 'dashboard.generos.search', 'uses' => 'DashboardGenerosController@getSearch'))
        ->where('criteria', '[a-z ñáéíóúA-Z]+');

  Route::resource('generos', 'DashboardGenerosController');

  // Materials management
  Route::bind('materiales', function($id, $route){
    return Material::with('user')->find($id);
  });

  Route::get('materiales/{criteria}/search', array('as' => 'dashboard.materiales.search', 'uses' => 'DashboardMaterialesController@getSearch'))
        ->where('criteria', '[a-z ñáéíóúA-Z]+');

  Route::resource('materiales', 'DashboardMaterialesController');

  // Materials management
  Route::bind('centros', function($id, $route){
    return Centro::with('user')->find($id);
  });

  Route::get('centros/{criteria}/search', array('as' => 'dashboard.centros.search', 'uses' => 'DashboardCentrosController@getSearch'))
        ->where('criteria', '[a-z ñáéíóúA-Z]+');

  Route::resource('centros', 'DashboardCentrosController');

  // Files management
  Route::bind('registros', function($id, $route){
    return Registro::with('user')->find($id);
  });
  Route::get('registros/{criteria}/search', array('as' => 'dashboard.registros.search', 'uses' => 'DashboardRegistrosController@getSearch'))
        ->where('criteria', '[a-z ñáéíóúA-Z]+');
  Route::resource('registros', 'DashboardRegistrosController');

  // User management
  Route::get('usuario/propiedades', array('as' => 'dashboard.usuarios.config', 'uses' => 'DashboardHomeController@getUserOptions'));
  Route::post('usuario/propiedades', array('as' => 'dashboard.usuarios.configStore', 'uses' => 'DashboardHomeController@postUserOptions'));

 /** ------------------------------------------
 *  REST Services Secured
 *  ------------------------------------------
 */
 Route::get(
  'rest/usuario/setlang/{userid}/{lang}', 
  array(
    'as' => 'rest.users.setLangByUserId', 
    'uses'=>'DashboardHomeController@setJsonedLangByUserId'));
 Route::get(
  'rest/usuario/getCentros/{userid}', 
  array(
    'as' => 'rest.users.getCentrosById', 
    'uses'=>'DashboardHomeController@getJsonedCentrosById'));
 Route::get(
  'rest/usuario/setCentros/{userid}/{idcentros}', 
  array(
    'as' => 'rest.users.setCentrosById', 
    'uses'=>'DashboardHomeController@setJsonedCentrosById'));

});

/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

// User RESTful Routes (Login, Logout, Register, etc)
Route::controller('users', 'UsersController', array('getLogin' => 'login', 'postLogin' => 'post.login','getLogout' => 'logout'));

Route::get('/', function()
{
  return Redirect::route('dashboard');
});

/** ------------------------------------------
 *  REST Services
 *  ------------------------------------------
 */
Route::get('rest/materiales', array('as' => 'rest.materiales.all', 'uses' => 'DashboardMaterialesController@getJasoned'));
Route::get('rest/autores', array('as' => 'rest.autores.all', 'uses' => 'DashboardAutoresController@getJasoned'));
Route::get('rest/generos', array('as' => 'rest.generos.all', 'uses' => 'DashboardGenerosController@getJasoned'));
Route::get('rest/centros', array('as' => 'rest.centros.all', 'uses' => 'DashboardCentrosController@getJasoned'));


Route::get('dragndrop', function(){
  return View::make('dragndrop');
});

Route::get('migrar', function() {

  $registros = Registro::all();
  $registrosActualizados = 0;

  foreach ($registros as $registro) {

    $jsonedArray = array();
    $arrayMaterial = explode(';', $registro->material);

    foreach ($arrayMaterial as $material) {
      $trimmedMaterial = trim($material);
      $jsonedArray[$trimmedMaterial] = $trimmedMaterial;
    }

    // DB::table('registros')
    //         ->where('id', $registro->id)
    //         ->update(array('material' => json_encode($jsonedArray, JSON_UNESCAPED_UNICODE)));
    $registrosActualizados ++;
  }

  echo $registrosActualizados . " registros actualizados!.";
});

Route::get('buscador', function(){
  return View::make('buscador');
});

Route::get('rel', function(){

  $generos = Genero::where('lang', 'like', '%bailable%')->where('id', '!=', 6)->get();
  $root = Genero::find(6);
 
  foreach ($generos as $item) { 

    $item->makeChildOf($root);
    $item->save();
  }
  return "listo";
});

Route::get('testCentro', function() {

  //$myUser = User::find(27);

  //var_dump($myUser->getAssignedCentros());
  //echo $myUser->getDefaultCentro();

  return Request::route()->action('as');
});
