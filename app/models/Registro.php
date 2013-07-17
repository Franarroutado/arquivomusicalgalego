<?php

class Registro extends BaseModel {
  
    protected $guarded = array();

    public static $rules = [
      'nombre'      => ['required'],
      'autore_id'   => ['required', 'numeric'],
      'genero_id'   => ['required', 'numeric'],
      'tipo'        => 'required',
      'centro_id'   => ['required', 'numeric'],
      'fecha'       => 'date_format:Y',
      'user_id'     => ['required', 'numeric']
    ]; 


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