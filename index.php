<?php
register_shutdown_function('error_debug_show');

ignore_user_abort(true);
set_time_limit(0);
ini_set("memory_limit","10G");

use \Kernel\Autoloader;
use \Kernel\Core\Query;
use \Kernel\Core\router\Router;


// Initialisation de l'environnement
include('./config/config_init.php');
	
//les variables de template
$CoreConstantes = get_defined_constants(true);
if(isset($CoreConstantes["user"]))
{	
	foreach($CoreConstantes["user"] as $k => $v)
	{
		//echo strtolower(rtrim($k, '_')) . " => ".$v."<br>"; 
	
		$smarty->assign(strtolower(rtrim($k, '_')), $v);
	}
}

include('./config/route_init.php');

function error_debug_show()
{
	$last_error =  error_get_last();

	if(!is_null($last_error) and count($last_error) > 0)
	{
		echo "<pre>ERROR<br>";
		print_r($last_error);
		echo "</pre>";
	}
	//debug_print_backtrace();
}
?>