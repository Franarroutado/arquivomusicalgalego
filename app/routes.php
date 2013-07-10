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

/** ------------------------------------------
 *  Dashboard Routes
 *  ------------------------------------------
 */

Route::group(['prefix' => 'dashboard', 'before'=>'auth.sentry2'], function()
{
  // Dashboard
  Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardHomeController@getIndex']);


  Route::get('autores/{criteria}/search', ['as' => 'dashboard.autores.search', 'uses' => 'DashboardAutoresController@getSearch'])
        ->where('criteria', '[a-z ñáéíóúA-Z]+');

  // Authors management
  Route::bind('autores', function($id, $route){
    return Autore::with('user')->find($id);
  });
  Route::resource('autores', 'DashboardAutoresController');

});

/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

// User RESTful Routes (Login, Logout, Register, etc)
Route::controller('users', 'UsersController', ['getLogin' => 'login', 'postLogin' => 'post.login','getLogout' => 'logout']);

Route::get('/', function()
{
  return View::make('hello');
});