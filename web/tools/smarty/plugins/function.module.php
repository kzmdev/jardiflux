<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Fichier :  function.module.php
 * Type :     fonction
 * Nom :      module
 * Rôle :     retourne le module associé
 * -------------------------------------------------------------
 */
function smarty_function_module($params, &$smarty)
{
	//require_once(_CORE_."db.php");
	
	$db = new \classes\core\db();
	$o = $db->select()
				->from('modules')
				->addFiltre('name')
				->where('position_id = ?', $params["position"])
				->fetchOne();
	
	if(is_object($o) and is_file(SMARTY_PLUGINS_DIR . 'function.'.$o->name.'.php'))
	{
		require_once(SMARTY_PLUGINS_DIR . 'function.'.$o->name.'.php');
	
		$func = "smarty_function_".$o->name;
		return $func($params, $smarty);
	}
	else
	{
		return null;
	}
    
}
?>