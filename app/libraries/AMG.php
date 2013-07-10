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
      $avaliableErrors = ['validation.validation_err1', 'validation.validation_err2', 'validation.validation_err3'];
      return static::returnRandomArrayValue($avaliableErrors);
    }

    public static function returnRandomArrayValue($array)
    {
        $randomIndex = array_rand($array);
        return $array[$randomIndex];
    }
}