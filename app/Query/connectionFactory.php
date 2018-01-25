<?php
class connectionFactory{

	private static $config, $db;

	public static function setConfig($nomFichier){
		self::$config=parse_ini_file($nomFichier);
	}

	public static function getConnection(){
		if(!isset($db)){
			$host=self::$config['host'];
			$base=self::$config['database'];
			$user=self::$config['username'];
			$pass=self::$config['password'];
			$option=array(	\PDO::ATTR_PERSISTENT=>true,
					\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
					\PDO::ATTR_EMULATE_PREPARES=> false,
					\PDO::ATTR_STRINGIFY_FETCHES => false);
			$dsn = "mysql:host=$host;dbname=$base";
			self::$db=new \PDO($dsn, $user, $pass, $option);
			return self::$db;
		}else{
			return self::$db;
		}
	}
}
