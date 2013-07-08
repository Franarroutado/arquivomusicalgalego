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
 *  Dashboard Routes
 *  ------------------------------------------
 */

Route::group(['prefix' => 'dashboard', 'before'=>'auth.sentry2'],function(){
  // Home
  Route::get('/', function()
  {
    return View::make('hello');
  });

  // User management
  Route::get('users', function(){
    return 'Hello users';
  });
});

/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

Route::get('login', function() {
  return View::make('login');
});

Route::get('/', function()
{
  return View::make('hello');
});


Route::get('test', function(){

  //Sentry::logout();

  $myCredent = ['email' => 'amg@amg.com', 'password' => 'test'];
  
  try {
    //$myCredent = ['email' => 'amg@amg.com'];
    $user = Sentry::authenticate($myCredent);
  }
  catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
  {
      echo 'Login field is required.';
  }
  catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
  {
      echo 'Password field is required.';
  }
  catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
  {
      echo 'Wrong password, try again.';
  }
  catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
  {
      echo 'User was not found.';
  }
  catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
  {
      echo 'User is not activated.';
  }
  // The following is only required if throttle is enabled
  catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
  {
      echo 'User is suspended.';
  }
  catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
  {
      echo 'User is banned.';
  }


  if ( Sentry::check() ) {
    echo '<p>Logged in</p>';

    // Get Groups
    $groups = $user->getGroups();

    foreach ($groups as $key) {
      echo $key . '<br/>';;
    }

    $user->permissions = ['users.edit' => 1, 'users.create' => -1 ];

    $user->save();

    $permissions = $user->getPermissions();

    foreach ($permissions as $key => $value) {
      echo $key . ' : ' . $value . '<br/>';
    }
    //dd($groups);

  } else {
    echo '<p>Not logged in</p>';
  }

  
  

  //dd( Sentry::getUser() );
});