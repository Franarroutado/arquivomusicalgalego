<?php

class Centro extends BaseModel {
  
    protected $guarded = array();

    public static $rules = array(
      'abrev' => array('required'),
      'nombre' => array('required'),
      'user_id' => array('required','numeric')
    ); 

    // Relationsship One To One (one Autore corresponds one User)
    public function user()
    {
      return $this->belongsTo('User');
    }
}