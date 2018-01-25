<?php
//require ("conf/ClassLoader.php");
require __DIR__ . '/app/Query/connectionFactory.php';
require __DIR__ . '/app/Query/query.php';
require __DIR__ . '/app/Model/Model.php';
require __DIR__ . '/app/Model/Article.php';
require __DIR__ . '/app/Model/Categorie.php';

// $load = new ClassLoader('app');
// $load->register();

connectionFactory::setConfig('conf/config.ini');

$a = new Article();
$a->id= 102;
$a->nom= 'Benotto';
$a->descr= 'beau velo de course rouge';
$a->tarif= 59.95;
$a->id_categ=1;
$a->insert();

echo "<h2>Insert</h2>";
$liste = Article::all();
foreach ($liste as $art) echo $art->id.' '.$art->nom.' '.$art->descr.'<br/>';

echo "<h2>Delete</h2>";
$a->delete();
$liste = Article::all();
foreach ($liste as $art) echo $art->id.' '.$art->nom.' '.$art->descr.'<br/>';

echo "<h2>Find</h2>";
$liste = Article::find(64);
foreach ($liste as $art) echo $art->id.' '.$art->nom.' '.$art->descr.'<br/>';

echo "<h2>Find 2</h2>";
$liste = Article::find(68, ['id', 'nom', 'tarif']);
foreach ($liste as $art) echo $art->id.' '.$art->nom.' '.$art->tarif.'<br/>';

echo "<h2>Find Condiciones</h2>";
$liste = Article::find(['tarif', '>=', 100 ], ['id', 'nom', 'tarif']);
foreach ($liste as $art) echo $art->id.' '.$art->nom.' '.$art->tarif.'<br/>';

echo "<h2>First</h2>";
$liste = Article::first(['tarif', '<=', 100 ], ['id', 'nom', 'tarif']);
foreach ($liste as $art) echo $art->id.' '.$art->nom.' '.$art->tarif.'<br/>';

echo "<h2>Belongs To</h2>";
$a=Article::first(65);
foreach ($a as $art) echo $art->id.' '.$art->nom.' '.$art->tarif.'<br/>';
$categorie = $art->belongs_to('categorie', 'id_categ');
print_r($categorie);

echo "<h2>Has many</h2>";
$m = Categorie::first(1);
foreach ($m as $cat) echo $cat->nom;
$list_article = $cat->has_many('article', 'id_categ');
var_dump($list_article);

// $cat=Article::first(56)->categorie();
// var_dump($cat);
