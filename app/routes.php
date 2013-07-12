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

/** ------------------------------------------
 *  Dashboard Routes
 *  ------------------------------------------
 */

Route::group(['prefix' => 'dashboard', 'before'=>'auth.sentry2'], function()
{
  // Dashboard
  Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardHomeController@getIndex']);

  // Authors management
  Route::get('autores/{criteria}/search', ['as' => 'dashboard.autores.search', 'uses' => 'DashboardAutoresController@getSearch'])
        ->where('criteria', '[a-z ñáéíóúA-Z]+');

  Route::bind('autores', function($id, $route){
    return Autore::with('user')->find($id);
  });
  Route::resource('autores', 'DashboardAutoresController');

  // Genres management
  Route::bind('generos', function($id, $route){
    return Genero::with('user')->find($id);
  });

  Route::get('generos/{criteria}/search', ['as' => 'dashboard.generos.search', 'uses' => 'DashboardGenerosController@getSearch'])
        ->where('criteria', '[a-z ñáéíóúA-Z]+');

  Route::resource('generos', 'DashboardGenerosController');

  // Materials management
  Route::bind('materiales', function($id, $route){
    return Material::with('user')->find($id);
  });

  Route::get('materiales/{criteria}/search', ['as' => 'dashboard.materiales.search', 'uses' => 'DashboardMaterialesController@getSearch'])
        ->where('criteria', '[a-z ñáéíóúA-Z]+');

  Route::resource('materiales', 'DashboardMaterialesController');

});

/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

// User RESTful Routes (Login, Logout, Register, etc)
Route::controller('users', 'UsersController', ['getLogin' => 'login', 'postLogin' => 'post.login','getLogout' => 'logout']);

Route::get('/', function()
{
  return Redirect::route('dashboard');
});

Route::get('dragndrop', function(){
  return View::make('dragndrop');
});
