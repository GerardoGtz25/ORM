<?php

class Model {

  protected static $table;
  protected static $idColumn;
  protected $t = [];

  public function __construct(array $t = null){
    if(!is_null($t)) $this->t = $t;
  }

  public function __get($attr_name){
        if(array_key_exists($attr_name, $this->t))
        return $this->t[$attr_name];
    }

  public function __set($nom_att, $valeur){
      $this->t[$nom_att] = $valeur;
    }

  public static function all() : array{
    $all = Query::table(static::$table)->get();
    $return=[];
    foreach($all as $m) {
      $return[] = new static($m);
    }
    return $return;
  }

  public function belongs_to($table, $fk) : array{
    $all = Query::table($table)->where('id', '=', $this->t[$fk])->first();
    $return=[];
    foreach($all as $m) {
      $return[] = new static($m);
    }
    return $return;
  }

  public function has_many ($table, $fk) : array{
    $all = Query::table($table)->where($fk, '=', $this->t['id'])->get();
    $return=[];
    foreach($all as $m) {
      $return[] = new static($m);
    }
    return $return;
  }

  public static function find($f, array $p=['*']) : array{
    if (is_array($f)) {
      $col=$f[0];
      $op=$f[1];
      $val=$f[2];
      $all = Query::table(static::$table)->select($p)->where($col, $op, $val)->get();
      $return=[];
      foreach($all as $m) {
        $return[] = new static($m);
      }
      return $return;
    }else{
      $all = Query::table(static::$table)->select($p)->where(static::$idColumn, '=', $f)->get();
      $return=[];
      foreach($all as $m) {
        $return[] = new static($m);
      }
      return $return;
    }
  }

  public static function first($f, array $p=['*']) : array{
    if (is_array($f)) {
      $col=$f[0];
      $op=$f[1];
      $val=$f[2];
      $all = Query::table(static::$table)->select($p)->where($col, $op, $val)->first();
      $return=[];
      foreach($all as $m) {
        $return[] = new static($m);
      }
      return $return;
    }else{
      $all = Query::table(static::$table)->select($p)->where(static::$idColumn, '=', $f)->first();
      $return=[];
      foreach($all as $m) {
        $return[] = new static($m);
      }
      return $return;
    }
  }

  public function delete(){
    return Query::table(static::$table)
    ->where(static::$idColumn, '=', $this->t[static::$idColumn])
    ->delete();
    }

  public function insert(){
    return Query::table(static::$table)
    ->insert($this->t);
  }
}
