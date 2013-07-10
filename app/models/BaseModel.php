<?php

class BaseModel extends Eloquent {

  public $errors; 

  protected $softDelete = true;

  public static function boot() {
    parent::boot();

    static::saving(function($post){
      return $post->validate();
    });
  }

  public function validate() {

    $validation = Validator::make($this->attributes, static::$rules);

    if ($validation->passes()) return true;

    $this->errors = $validation->messages();

    return false;
  }
}