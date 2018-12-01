<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty jsonaffiche modifier plugin
 * Type:     modifier<br>
 * Name:     jsonaffiche<br>
 * Purpose:  Affcihe un json sous le format attendu
 * {@internal {$string|jsonaffiche:li:true} is the fastest option for MBString enabled systems }}
 *
 * @param string  $string    chaine à décoder
 * @param boolean $uc_digits also capitalize "x123" to "X123"
 * @param boolean $lc_rest   capitalize first letters, lowercase all following letters "aAa" to "Aaa"
 *
 * @return string capitalized string
 * @author Monte Ohrt <monte at ohrt dot com>
 * @author Rodney Rehm
 */
function smarty_modifier_jsonaffiche($string, $uc_digits = false, $lc_rest = false)
{
    $t = json_decode($string);
	
	foreach($t as $k => $o)
	{
		$tValeurs = get_object_vars($o);
	}
    return $upper_string;
}
