<?php

namespace Kernel\Tables;

use Kernel\Entities\Fournisseur;
use Kernel\Core\Query;
use \PDO;

class FournisseursTables{
	
	private $diff = ["by_page","page"];
		
	public function liste($args=array())
	{
		
		$by_page= (isset($args["by_page"]) ? $args["by_page"] : 10);
		$deb = ((isset($args["page"]) ? $args["page"] : 1)-1)*$by_page;
		
		$req = Query::select()
				->from('#_fournisseurs');
		if(isset($_SESSION["grids"]["fournisseurs"]))
		{
			$i=0;
			foreach($_SESSION["grids"]["fournisseurs"] as $field => $val)
			{
				if($val != "" and !in_array($field, array_keys($args)))
				{
					$req->where($field, "like", "%".$val."%", "", (($i>0) ? "and" : ""));
					$i++;
				}
			}
		}
		$req->limit($deb,$by_page);
		$o = $req->fetchAll(PDO::FETCH_CLASS, "Kernel\Entities\Fournisseur");
				
		return $o;
	}
	
	public function countAll()
	{
		$args = [];
		if(isset($_SESSION["grids"]["fournisseurs"]))
		{
			foreach($_SESSION["grids"]["fournisseurs"] as $field => $val)
			{
				if($val != "" and !in_array($field, $this->diff))
				{
					$args[$field] = $field . " LIKE '%".$val."%'";
				}
			}
		}
		$nb = Query::countAll('#_fournisseurs', $args);
				
		return $nb;
	}
	
	public function get($id)
	{
		return Query::select()->from('#_fournisseurs')->where("code", "=", $id)->fetchOne(PDO::FETCH_CLASS, "Kernel\Entities\Fournisseur");
	}
	
}

?>