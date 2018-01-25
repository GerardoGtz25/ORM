<?php

class Article extends Model {

   protected static $table='article';
   protected static $idColumn='id';

   public function categorie(){
     return $this->belongs_to('categorie', 'id_categ');
   }
}
