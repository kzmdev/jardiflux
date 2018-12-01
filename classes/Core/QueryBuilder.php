<?php

namespace Kernel\Core;

use \PDO;

/**
* Class QueryBuilder
* ORM simplifié pour préparer ces requetes
*/

class QueryBuilder extends Database{

/**
* @var string methode utiliser pour la requete
*/	
	protected $type = "select";
/**
* @var array tableau des colonnes sélectionnées
*/
	protected $columns = array();
/**
* @var  tableau des tables
*/
	protected $from = array();
/**
* @var  tableau des conditions
*/
	protected $where = array();
/**
* @var  tableau des sous conditions
*/
	protected $groupwhere = array();
/**
* @var  tableau des statement de la requete 
	  [ALL | DISTINCT | DISTINCTROW ]
	  [HIGH_PRIORITY] 
	  [MAX_STATEMENT_TIME = N]
      [STRAIGHT_JOIN]
      [SQL_SMALL_RESULT] [SQL_BIG_RESULT] [SQL_BUFFER_RESULT]
      [SQL_CACHE | SQL_NO_CACHE] 
	  [SQL_CALC_FOUND_ROWS]
*/
	protected $statements = array();
/**
* @var  tableau des valeurs à sécuriser
*/	
	protected $bindvalue = array();
/**
* @var  les joitures
*/	
	protected $join = array();
/**
* @var  l'ordre
*/	
	protected $order = array();
/**
* @var  la limite
*/	
	protected $limit = "";
/**
* @var  les valeurs à setter
*/	
	protected $set = array();
/**
* @var  les champs à grouper
*/	
	protected $group = array();
	
	protected $debug = false;

public function query($query, $fetch = PDO::FETCH_COLUMN )
{//echo "<br>[QUERY]<br>";
	$dbh = parent::getDb();
	return $dbh->query(parent::_getprefixe($query));
}

public function exec($query)
{//echo "<br>[EXEC]<br>";
	$dbh = parent::getDb();
	return $dbh->exec(parent::_getprefixe($query));
}

public function debug()
{
	$this->debug = true;
	
	return $this;
}
/**
* @function select
*
* @param string or array	
*
* @return object
*
* Met à jour le type de requete en mode select
*/
	public function select()
	{
		foreach(func_get_args() as $args)
		{
			if(is_array($args))
			{
				foreach($args as $arg => $alias)
				{
					$this->columns(parent::_quoteName($arg)." as ".$alias, false);
				}
			}
			else
			{
				$this->columns($args);
			}
		}
		
		$this->type = "select";
		
		return $this;
	}
	
	public function func($function_name, $args, $alias)
	{
		$func = $function_name."(";
		$func .= implode(", ", $args);
		$func .= ") as ".$alias;
		
		$this->columns($func, false);
		
		return $this;
	}
	
	public function countAll($tbl, $args=[])
	{
		$nb = 0;
		$req = "select count(*) as nb from ".parent::_quoteName($tbl)." where 1 ";;
		foreach($args as $field => $exp)
		{
			$req .= " and ".$exp;
		}
		
		$resp = $this->query($req);
		$row = $resp->fetch();
		if(is_array($row) and !empty($row))
		{
			$nb = $row["nb"];
		}
		
		return $nb;
	}
/**
* @function join
*
* @param string	table le nom de la table
* @param string	primary clé principale
* @param string	foreigner clé etrangère
* @param string	type type de jointure (INNER)
* 		valeurs autorisées : INNER, CROSS, LEFT, RIGHT, FULL, SELF, NATURAL
*
* @return object
*
* Met à jour le type de requete en mode select
*/
	public function join($table, $primary, $foreigner, $type="INNER")
	{
		
		$this->join[] = $type." JOIN ". parent::_quoteName($table) . " ON ". parent::_quoteName($primary) . " = ". parent::_quoteName($foreigner);
		
		return $this;
	}
	
/**
* @function columns
*
* @param string or array	fields	liste sous format d'une chaine ou d'un tableau des colonnes à sélectionner
* @param boleen				$quote	autorisation de rajouter les quotes(true)
*
* @return object
*
* Met à jour le type de requete
*/
	private function columns($fields, $quote=true)
	{
		if(is_array($fields))
		{
			foreach($fields as $field)
			{
				if($quote)
				{
					$this->columns[] = parent::_quoteName($field);
				}
				else
				{
					$this->columns[] = $field;
				}
			}
		}
		else
		{
			//on gere les éventuels séparateurs
			$champs = explode(",", $fields);
			foreach($champs as $champ)
			{
				if($quote)
				{
					$this->columns[] = parent::_quoteName($champ);
				}
				else
				{
					$this->columns[] = $champ;
				}
			}
		}
		return $this;
	}	

/**
* @function from
*
* @param string or array	tables	liste sous format d'une chaine ou d'un tableau des tables à sélectionner
*
* @return object
*
* Met à jour le from de la requete
*/
	public function from($tables)
	{
		if(is_array($tables))
		{
			foreach($tables as $table)
			{
				$this->from[] = parent::_quoteName($table);
			}
		}
		else
		{
			$champs = explode(",", $tables);
			foreach($champs as $champ)
			{
				$this->from[] = parent::_quoteName($champ);
			}
		}
		return $this;
	}	

/**
* @function statement
*
* @param string or array	tables	liste sous format d'une chaine ou d'un tableau des tables à sélectionner
*
* @return object
*
* Ajoute les statements à la requete
*/
	public function statement()
	{
		foreach(func_get_args() as $args)
		{
			if(is_array($args))
			{
				foreach($args as $arg)
				{
					$this->statements[] = $arg;
				}
			}
			else
			{
				$this->statements[] = $args;
			}
		}
		
		return $this;
	}	

/**
* @function where
*
* @param string 	field	nom du champ sur lequel s'applique la clause
* @param string		operateur	l'opérateur qui s'applique à la clause
* @param string or array	values les valeurs que doit prendre le champs de la clause
* @param string	groupname	nom du sous groupe pour les requetes avec sous opérateur
* @param string	determinant	
*
* @return object
*
* Ajoute les clause à la requete
*/
	public function where($field, $operateur="=", $values, $groupname="", $determinant = "")
	{
		$i = 0;
		if(is_array($values))
		{
			foreach($values as $value)
			{	
				$bind = ":" . parent::_bindvalue();
				$this->bindvalue[$bind] = $value;
				$binds[$bind] = $value;
				$i++;
			}
		}
		else
		{
			$bind = ":" . parent::_bindvalue();
			$this->bindvalue[$bind] = $values;
			$binds[$bind] = $values;
		}
		
		if($groupname != "")
		{
			if(isset($this->groupwhere[$groupname]))
			{
				$this->groupwhere[$groupname]["query"][] = (($determinant != "") ? $determinant." " : "") . parent::_quoteName($field) . " " . $operateur. " " . ((count($binds)>1) ? "(".implode(', ', array_keys($binds)).")" : key($binds));
			}
			else
			{
				trigger_error("Vous devez initialiser le groupe \"".$groupname."\" de condition avec la methode setconditionsGroupe", E_USER_ERROR);
			}
		}
		else
		{
			$this->where[] =  (($determinant != "") ? $determinant." " : "") . parent::_quoteName($field) . " " . $operateur. " " . (((count($binds)>1) or ($operateur == "IN")) ? "(".implode(', ', array_keys($binds)).")" : key($binds));
			
		}
		return $this;
	}	

/**
* @function whereAnd
*
* @param string 	field	nom du champ sur lequel s'applique la clause
* @param string		operateur	l'opérateur qui s'applique à la clause
* @param string or array	values les valeurs que doit prendre le champs de la clause
* @param string	groupname	nom du sous groupe pour les requetes avec sous opérateur
*
* @return object
*
* Ajoute les clause à la requete en mode AND
*/
	public function whereAnd($field, $operateur="=", $values, $groupname="")
	{
		$this->where($field, $operateur, $values, $groupname, "AND");
		return $this;
	}	

/**
* @function whereOr
*
* @param string 	field	nom du champ sur lequel s'applique la clause
* @param string		operateur	l'opérateur qui s'applique à la clause
* @param string or array	values les valeurs que doit prendre le champs de la clause
* @param string	groupname	nom du sous groupe pour les requetes avec sous opérateur
*
* @return object
*
* Ajoute les clause à la requete en mode OR
*/
	public function whereOr($field, $operateur="=", $values, $groupname="")
	{
		$this->where($field, $operateur, $values, $groupname, "OR");
		return $this;
	}	
	
	public function isNull($field, $determinant="", $groupname="")
	{
		if($groupname != "")
		{
			if(isset($this->groupwhere[$groupname]))
			{
				$this->groupwhere[$groupname]["query"][] = $this->where[] =  (($determinant != "") ? $determinant." " : "") . parent::_quoteName($field) . " IS NULL ";;
			}
			else
			{
				trigger_error("Vous devez initialiser le groupe \"".$groupname."\" de condition avec la methode setconditionsGroupe", E_USER_ERROR);
			}
		}
		else
		{
			$this->where[] =  (($determinant != "") ? $determinant." " : "") . parent::_quoteName($field) . " IS NULL ";
			
		}
		return $this;
	}
	
	public function isNotNull($field, $determinant="", $groupname="")
	{
		if($groupname != "")
		{
			if(isset($this->groupwhere[$groupname]))
			{
				$this->groupwhere[$groupname]["query"][] = $this->where[] =  (($determinant != "") ? $determinant." " : "") . parent::_quoteName($field) . " IS NOT NULL ";;
			}
			else
			{
				trigger_error("Vous devez initialiser le groupe \"".$groupname."\" de condition avec la methode setconditionsGroupe", E_USER_ERROR);
			}
		}
		else
		{
			$this->where[] =  (($determinant != "") ? $determinant." " : "") . parent::_quoteName($field) . " IS NOT NULL ";
			
		}
		return $this;
	}
	
/**
* @function setconditionsGroupe
*
* @return object
*
* Ajoute l'operateur OR entre deux requetes
*/
	public function setconditionsGroupe($groupname, $operateur)
	{
		$this->groupwhere[$groupname]["operateur"] = "OR";
		return $this;
	}	
	
/**
* @function order
*
* @param array 	arguments	tableau
* @param string		operateur	l'opérateur qui s'applique à la clause
*
* @return object
*
* Ordonne la requete 
*/
	public function order($field, $ordre = "ASC")
	{
		$this->order[] = parent::_quoteName($field)." ".$ordre;
		
		return $this;
	}

/**
* @function group
*
* @param string 	field le champs sur lequel il faut grouper
*
* @return object
*
* Regroupe les requetes sur un champs 
*/
	public function group($field)
	{
		$this->group[] = parent::_quoteName($field);
		
		return $this;
	}
	
/**
* @function limit
*
* @param int 	borne_min index de départ
* @param int	pas	l'opérateur qui s'applique à la clause
*
* @return object
*
* limite le nombre de résultat 
*/
	public function limit($borne_min, $pas)
	{
		$this->limit = $borne_min.", ".$pas;
		
		return $this;
	}
	
/**
* @function insert
*
* @return object
*
* Met à jour le type de requete en mode insert
*/
	public function insert()
	{
		$this->type = "insert";
		
		return $this;
	}
	
	
	public function delete()
	{
		$this->type = "delete";
		
		return $this;
	}
	
	public function update()
	{
		$this->type = "update";
		
		return $this;
	}

/**
* @function set
*
* @return object
*
* Ajoute les nouvelles valeurs au tableau set
*/
	public function set($fieldname, $value)
	{
		$bind = ":" . parent::_bindvalue();
		$this->set[$bind] = parent::_quoteName($fieldname);
		$this->bindvalue[$bind] = $value;
		
		return $this;
	}		

/**
* @function build
*
* @return string 
*
* Mets en forme la requete
*/	
	protected function build()
	{
		$req = $this->type. " ";
		$req .= implode(" ", $this->statements) ." ";
		if(is_array($this->columns) and count($this->columns) > 0)
		{
			$req .= implode(", ", $this->columns) . " ";
		}
		else
		{
			if($this->type == "select")
			{
				$req .= "* ";
			}
		}
		if(is_array($this->from) and count($this->from) > 0)
		{
			if($this->type == "select" or $this->type == "delete")
			{
				$req .= "FROM ".implode(", ", $this->from) . " ";
			}
			elseif($this->type == "update")
			{
				$req .= implode(", ", $this->from) . " ";
			}
			else
			{
				$req .= "INTO ".implode(", ", $this->from) . " ";
			}
		}
		
		if(is_array($this->join) and count($this->join) > 0)
		{
			$req .= implode(" ", $this->join) . " ";
		}
		
		if(is_array($this->set) and count($this->set) > 0)
		{
			if($this->type == "insert")
			{
				$req .= " (". implode(", ", $this->set) . ") VALUES  (". implode(", ", array_keys($this->set)) . ") ";
			}
			elseif($this->type == "update")
			{
				$tup = array();
				foreach($this->set as $bind => $chp)
				{
					$tup[] = $chp ." = " . $bind;
				}
				$req .= " SET " .implode(", ", $tup);
			}
			
		}
		if(count($this->groupwhere) > 0 OR count($this->where) > 0)
		{
			$req .= " WHERE ";
			if(count($this->where) > 0)
			{
				$req .= implode(" ", $this->where);
			}
			if(count($this->groupwhere) > 0)
			{
				foreach($this->groupwhere as $name => $groupes)
				{
					$req .= " ".$groupes["operateur"]." (";
					foreach($groupes["query"] as $groupe)
					{
						$req .= $groupe." ";
					}
					$req .= ") ";
				}
			}
		}
		
		if(count($this->group) > 0)
		{
			if($this->type == "select")
			{
				$req .= " GROUP BY ".implode(", ", $this->group) . " ";
			}
		}
		
		if(count($this->order) > 0)
		{
			if($this->type == "select")
			{
				$req .= " ORDER BY ".implode(", ", $this->order) . " ";
			}
		}
		
		if($this->type == "insert")
		{
			if(is_array($this->set) and count($this->set) > 0)
			{
				$keys = $this->getPrimaryKey($this->from[0]);
				
			
				foreach($this->set as $behind => $field)
				{	
					if(!in_array($field, $keys))
					{	
						$values[] = $field . " = ".$behind;
					}
				}
				
				if(isset($values) and count($values) > 0)
				{
					$req .= " ON DUPLICATE KEY UPDATE ". implode(", ", $values);
				}
			}
		}
		
		if($this->limit != "")
		{
			$req .= " LIMIT ".$this->limit . " ";
		}
		
		return $req;
	}
	
	public function subQuery()
	{
		$req = $this->build();
		return $req;
	}
	public function fetchOne($fetch_style=PDO::FETCH_OBJ, $fetch_argument=null)
	{
		$req = $this->build();
		
		$resp = $this->execute($req);
		if($fetch_argument)
		{
			$resp->setFetchMode($fetch_style, $fetch_argument); 
		}
		else
		{
			$resp->setFetchMode($fetch_style);
		}
		return $resp->fetch(); 
	}
	
	public function fetchColumn()
	{
		$req = $this->build();
		
		$resp = $this->execute($req);
		
		return $resp->fetchColumn(); 
	}
	
	public function fetchAll($fetch_style=PDO::FETCH_OBJ, $fetch_argument=null)
	{
		$req = $this->build();
		$resp = $this->execute($req);
		if($fetch_argument)
		{
			return $resp->fetchAll($fetch_style, $fetch_argument); 
		}
		else
		{
			return $resp->fetchAll($fetch_style);
		}
	}
	
	public function save()
	{
		$req = $this->build();
		$lastId = $this->execute($req);
		
		return $lastId;
	}
	
	public function getColumns($tbl){
		$table = parent::_quoteName($tbl);
		//echo "<br>[GETCOLUMNS]<br>";
		$dbh = parent::getDb();
		$q = $dbh->prepare("DESCRIBE ".$table);
		$q->execute();
		$table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
		$q->closeCursor();
		unset($dbh);
		return $table_fields;
	}
	
	protected function getPrimaryKey($tbl){
		$table = parent::_quoteName($tbl);
		//echo "<br>[GETPRIMARY]<br>";
		$dbh = parent::getDb();
		$q = $dbh->prepare("SHOW COLUMNS FROM ".$table." where `Key` = 'PRI'");
		$q->execute();
		$keys = $q->fetchAll(PDO::FETCH_COLUMN);
		$q->closeCursor();
		unset($dbh);
		return $keys;
	}
	
	protected function execute($query)
	{	if($this->debug)	
		{
			parent::_debugquery($query, $this->bindvalue); 
		}
		try{
			
			$dbh = parent::getDb();
			$sth = $dbh->prepare($query);
			$sth->execute($this->bindvalue);
			
			if($this->type == "insert")
			{
				$lastId = $dbh->lastInsertId();
				$sth->closeCursor();
				unset($dbh);
				return $lastId;
			}
			else{
				return $sth;
			}
		}
		catch (\PDOExeption $e) {
			echo "erreur";
			return "error";
		}
	}
}

?>