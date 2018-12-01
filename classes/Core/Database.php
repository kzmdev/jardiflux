<?php
namespace Kernel\Core;

use \PDO;


class Database{

	
	static $pdo;

	
	protected static function getDb()
	{
		if(self::$pdo === null)
		{
			try {
						$db = new PDO(BDD_DNS, BDD_LOGIN, BDD_MDP, [PDO::MYSQL_ATTR_LOCAL_INFILE => true]);
						
					} 
				catch (PDOException $e) {
						die("PDO CONNECTION ERROR: " . $e->getMessage() . "<br/>");
					}
			
		
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );
			self::$pdo = $db;
			 $db->query("SET wait_timeout=2400;"); 
		}
		
		
		return self::$pdo;
	}
	
/**
* @function _quoteName
*
* @param string	field	le nom du champs à protéger par des `
*
* @return string
*
* Ajoute des quote autour des noms des tables et des noms des champs
*/
	protected static function _quoteName($field)
	{
		$pattern_func = "/\((.*)\)/";
		$pattern_elt = "/[\"`'%*]/"; 
		preg_match($pattern_func, $field, $matches);
		
		if(count($matches) > 0)	//il s'agit d'une function
		{
			//on recupere les arguments
			$args = explode(",", $matches[1]);
			foreach($args as $arg)
			{
				$ar = array();
				$elements = explode(".", $arg);
				foreach($elements as $element){
					$ar[] = self::_getprefixe(((preg_match($pattern_elt, $element)) ? $element : "`".trim($element)."`" ));
				}
				$t[$arg] = implode(".", $ar);
			}
			
		}
		else
		{
			//on verifie s'il y a une table
			$args = explode(".", $field);
			$ar = array();
			foreach($args as $arg){
					$ar[] = self::_getprefixe(((preg_match($pattern_elt, $arg)) ?  $arg : "`".trim($arg)."`"));
			}
			$t[$field] = implode(".", $ar);
			
		}
		
		
		$str = str_replace(array_keys($t), $t, $field);
		
		return $str;
	}

	protected static function _unquoteName($field)
	{	
		return self::_getprefixe($field);
	}
/**
* @function _bindvalue
*
* @return string
*
* Creation des champs bind pour les requetes préparées
*/	
	protected static function _bindvalue()
	{
		$char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXZ0123456789';
		$return = str_shuffle($char);
		$return = substr($return , 0, 10);
		return $return;
	}

/**
* @function _debugquery
*
* @param string	query	la requete à decoder
* @param array	binds	les valeurs des champs bind
*
* @return string
*
* Decode la requete en mode debug
*/	
	protected static function _debugquery($query, $binds)
	{
		foreach($binds as $bind => $val)
		{
			$query = str_replace($bind, "'".$val."'", $query);
		}
		
		echo "<br>##############################################<br><br>".$query."<br><br>##############################################<br>";
	}

/**
* @function _getprefixe
*
* @param string	table	la table a prefixer
*
* @return string
*
* Prefixe le nom de la table avec la valeur choisie
*/	
	protected static function _getprefixe($table)
	{
		$str = str_replace("#", BDD_PREFIXE, $table);
		
		return $str;
	}
	
}

