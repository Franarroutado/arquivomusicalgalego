<?php
use Baum\Node;

/**
* Genero
*/
class Genero extends Node {

  /**
   * Table name.
   *
   * @var string
   */
  protected $table = 'generos';

  protected $guarded = array();

  public static $rules =  array(
    'lang' => 'required',
    'user_id' => array('required','numeric')
  );  

  // Relationsship One To One (one Autore corresponds one User)
  public function user()
  {
    return $this->belongsTo('User');
  }

}
