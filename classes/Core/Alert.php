<?php

namespace Kernel\Core;

class Alert{
	
	public static function error($msg){
		$_SESSION["alert"] = array(	
									"style" => "danger",
									"type" => "Erreur",
									"text" => $msg
								);
	}
	
	public static function set($msg, $style="success", $type=""){
		$_SESSION["alert"] = array(	
									"style" => $style,
									"type" => $type,
									"text" => $msg
								);
	}
	
	public static function isAlert(&$template){
		if(isset($_SESSION["alert"]) and count($_SESSION["alert"]) == 3)
		{
			$template->assign('alert', $_SESSION["alert"]);
			unset($_SESSION["alert"]);
			return true;
		}
		
		return false;
	}
}
	