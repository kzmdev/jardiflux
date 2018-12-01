<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Fichier :  function.menuprincipal.php
 * Type :     fonction
 * Nom :      menuprincipal
 * Rôle :     renvoie le menu
 * -------------------------------------------------------------
 */
function smarty_function_menuprincipal($params, &$smarty)
{
	require_once(_CORE_."SMTemplate.php");
	print_r($params);
	return "mon menu principal";
}
?>