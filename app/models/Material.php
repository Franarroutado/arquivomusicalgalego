<?php

class Material extends BaseModel {

    // As laravel is not able to get the plural, I put the table explicitly.
    protected $table = 'materiales';

    protected $guarded = array();

    public static $rules = array(
      'abrev' => array('required', 'unique:materiales'),
      'lang' => 'required',
      'user_id' => array('required','numeric')
    ); 

    // Relationsship One To One (one Autore corresponds one User)
    public function user()
    {
      return $this->belongsTo('User');
    }
}