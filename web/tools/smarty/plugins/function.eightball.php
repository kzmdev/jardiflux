<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Fichier :  function.eightball.php
 * Type :     fonction
 * Nom :      eightball
 * Rôle :     renvoie une phrase magique au hasard
 * -------------------------------------------------------------
 */
function smarty_function_eightball($params, &$smarty)
{
	$answers = array('Yes',
                     'No',
                     'No way',
                     'Outlook not so good',
                     'Ask again soon',
                     'Maybe in your reality');

    $result = array_rand($answers);
    return $answers[$result];
}
?>