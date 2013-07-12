<?php

class Centro extends BaseModel {
  
    protected $guarded = array();

    public static $rules = [
      'abrev' => ['required'],
      'nombre' => ['required'],
      'user_id' => ['required','numeric']
    ]; 

    // Relationsship One To One (one Autore corresponds one User)
    public function user()
    {
      return $this->belongsTo('User');
    }
}