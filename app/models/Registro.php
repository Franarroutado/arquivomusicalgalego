<?php

class Registro extends BaseModel {
  
    protected $guarded = array();

    public static $rules = array(
      'nombre'      => array('required'),
      'autore_id'   => array('required', 'numeric'),
      'genero_id'   => array('required', 'numeric'),
      'tipo'        => 'required',
      'centro_id'   => array('required', 'numeric'),
      'fecha'       => 'date_format:Y',
      'user_id'     => array('required', 'numeric')
    ); 


    // Relationsship One To One (one Autore corresponds one User)
    public function user()
    {
      return $this->belongsTo('User');
    }
    // Relationsship One To One (one Autore corresponds one User)
    public function autore()
    {
      return $this->belongsTo('Autore');
    }
    // Relationsship One To One (one Autore corresponds one User)
    public function centro()
    {
      return $this->belongsTo('Centro');
    }
    // Relationsship One To One (one Autore corresponds one User)
    public function genero()
    {
      return $this->belongsTo('Genero');
    }
}