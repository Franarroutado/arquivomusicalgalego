<?php

class UsersController extends BaseController {

  /**
   * User Model
   * @var User
   */
  protected $user;

  /**
   * Inject the models.
   * @param  User $user
   */
  public function __contruct(User $user)
  {
    parent::__contruct();
    $this->user = $user;
  }

  public function getLogin() 
  {
    if (Sentry::check()) return Redirect::route('dashboard');

    return View::make('login');
  }

  public function postLogin() 
  {
    $validator = Validator::make(
      Input::all(),
      array('username' => array('required', 'email'), 'password' => 'required')
    );
    if ($validator->passes()) 
    {
      $message = '';
      try {
        $myCredentials = array('email' => Input::get('username'), 'password' => Input::get('password'));
        $user = Sentry::authenticate($myCredentials, Input::get('rememberme') ? true : false);
      } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
          $message = trans('validation.sentry2.wrong_password');
      } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
          $message = trans('validation.sentry2.wrong_user');;
      } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
          $message = trans('validation.sentry2.non_activated');;
      }

      if (strlen($message)>0) return Redirect::back()->withInput()->with('error', $message);

      return Redirect::route('dashboard')->with('success', trans('validation.sentry2.autenticado' , array('username' => Sentry::getUser()->first_name)));
    }

    return Redirect::back()
      ->withInput()
      ->withErrors($validator)
      ->with('error', trans(AMG::displayRandomErrorValidation()));
  }

  /**
   * Clear session
   * @return Redirect
   */
  public function getLogout() 
  {
    Sentry::logout();

    return Redirect::route('login')->with('success', trans('validation.sentry2.signout'));
  }
}