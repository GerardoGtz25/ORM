<?php
class ClassLoader{

	private $prefix;

// CONSTRUCTOR BASE
	public function __construct($prefix){
		$this->prefix = $prefix;
	}

// CARGAR CLASE
	function loadClass($class){
		$filename = $this->prefix. DIRECTORY_SEPARATOR
			. str_replace("\\", DIRECTORY_SEPARATOR, $class)
			. '.php';

		if(file_exists($filename)){
			require_once $filename;
		}
	}

	function register(){
		spl_autoload_register(array($this,'loadClass'));
	}
}
