<?php
namespace Kernel;

class Autoloader{

	static function register(){
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}

	static function autoload($class){
	
		$class = str_replace(__NAMESPACE__ .'\\', '', $class);
		$class = str_replace('\\', '/', $class);
		//echo $class."<br>";
		if(file_exists($class.'.php'))
		{
			require $class.'.php';
		}
		else
		{
			if(file_exists('classes/'.$class.'.php'))
			{
				require 'classes/'.$class.'.php';
			}
		}
	}
	
}