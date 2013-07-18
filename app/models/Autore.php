<?php

class Autore extends BaseModel {
    protected $guarded = array();

    public static $rules = array(
      'nombre' => 'required',
      'user_id' => array('required','numeric')
    );  

    // Relationsship One To One (one Autore corresponds one User)
    public function user()
    {
      return $this->belongsTo('User');
    }
}