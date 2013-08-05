<?php

class AMG {

    /**
     * Helps to build a message under the field of any form
     * @param  $errors [description]
     * @param  [type] $name   [description]
     * @return [type]         [description]
     */
    public static function displayErr( $errors, $name) 
    {
      if (!$errors->has($name)) return '';
      return '<div style="color: #712d2d; font-weight: bold;">'.'* '.$errors->first($name).'</div>';
    }

    /**
     * Return the localized string from a JSON structure.
     * @param  JSON string $jsonString Contains a JSON structure
     * @param  string $lang 
     * @return string 
     */
    public static function getLangJSON($jsonString, $lang = null)
    {
        $currentLang = Config::get('app.locale');
        if (isset($lang)) $currentLang = $lang;

        $objJson = json_decode($jsonString);
        if (!isset($objJson->$currentLang)) return trans('no_trans');
        return $objJson->$currentLang;
    }

    /**
     * Displays a flash message
     * @param  string $name
     * @return string
     */
    public static function flashMsg($name)
    {
      if (Session::has($name)) return Session::get($name);
    }

    /**
     * Return a random translation literal name when validation doesn't pass.
     * @return string 
     * 
     */
    public static function displayRandomErrorValidation()   
    {
      $avaliableErrors = array('validation.validation_err1', 'validation.validation_err2', 'validation.validation_err3');
      return static::returnRandomArrayValue($avaliableErrors);
    }

    public static function returnRandomArrayValue($array)
    {
        $randomIndex = array_rand($array);
        return $array[$randomIndex];
    }

    public static function returnDefaultCenterName($userId)
    {
        $user= User::find($userId);
        return $user->getDefaultCentro();
    }

    public static function returnDefaultCenterId($userId)
    {
        $user= User::find($userId);
        return $user->getDefaultCentroId();
    }
}