<?php

class BaseController extends Controller {

	protected $defaultCentro;
	protected $defaultCentroId;
	protected $user;

	public function __construct()
	{
		// parent::__construct();
		$this->user = Sentry::getUser();
		
		if (Sentry::check()) {
			$this->authorizeRequest();
			$this->setDefaultCentro();
		} 
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Check if user has authoritation to enter on the current controller/action by name route
	 * @return [type] [description]
	 */
	protected function authorizeRequest()
	{
		$currentNameRoute = Route::currentRouteName();
		if (!$this->user->hasAccess($currentNameRoute)) {
			echo "<h2>$currentNameRoute</h2>";
			App::abort(401, 'You are not authorized.'); 
		}
	}

	protected function setDefaultCentro()
	{
		$this->defaultCentro = AMG::returnDefaultCenterName($this->user->id);
		$this->defaultCentroId = AMG::returnDefaultCenterId($this->user->id);
	}

}