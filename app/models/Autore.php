<?php

class Autore extends BaseModel {
    protected $guarded = array();

    public static $rules = [
      'nombre' => 'required',
      'user_id' => ['required','numeric']
    ];  

    // Relationsship One To One (one Autore corresponds one User)
    public function user()
    {
      return $this->belongsTo('User');
    }
}