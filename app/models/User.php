<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	public function getAssignedCentros()
	{
		$properties= json_decode($this->properties, true);
		if (!isset($properties['centros']))
		{
			$properties['centros']= '';
			$this->properties= json_encode($properties);
		}
		return $properties['centros'];
	}

	public function setAssignedCentros($idCentros)
	{
		$properties= json_decode($this->properties, true);
		$properties['centros'] = $idCentros;
		$this->properties = json_encode($properties);
	}

	public function getDefaultCentro()
	{
		$properties= json_decode($this->properties, true);
		$arrCentros= explode(",",$properties['centros']);
		$defaultCentro= $arrCentros[0];
		$centro= Centro::find($defaultCentro);
		return $centro->nombre;
	}

	public function getDefaultCentroId()
	{
		$properties= json_decode($this->properties, true);
		$arrCentros= explode(",",$properties['centros']);
		return $arrCentros[0];
	}

	public function getDefaultLanguage()
	{
		$properties = json_decode($this->properties, true);
		if (!isset($properties['lang']))
		{
			$properties['lang'] = Config::get('app.locale');
			$this->properties = json_encode($properties);
		}
		return $properties['lang'];
	}

	public function setDefaultLanguage($lang)
	{
		$properties= json_decode($this->properties, true);
		$properties['lang'] = $lang;
		$this->properties = json_encode($properties);
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}