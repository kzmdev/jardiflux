<?php

namespace Kernel\Tables;

use Kernel\Entities\AttributesOption;
use Kernel\Core\Query;
use \PDO;

class AttributesOptionsTables{
		
	private $diff = ["by_page","page"];
	
	public function liste($args=array())
	{
		
		$by_page= (isset($args["by_page"]) ? $args["by_page"] : 10);
		$deb = ((isset($args["page"]) ? $args["page"] : 1)-1)*$by_page;
		$i=0;
		
		$req = Query::select()
				->from('#_attributs_options');
		if(isset($_SESSION["grids"]["thesaurus"]))
		{
			foreach($_SESSION["grids"]["thesaurus"] as $field => $val)
			{
				if($val != "" and !in_array($field, array_keys($args)))
				{
					$req->where($field, "like", "%".$val."%", "", (($i>0) ? "and" : ""));
					$i++;
				}
			}
		}
		$req->limit($deb,$by_page);
		$o = $req->fetchAll(PDO::FETCH_CLASS, "Kernel\Entities\AttributesOption");
				
		return $o;
	}
	
	public function get($code)
	{
		return Query::select()
				->from('#_attributs_options')
				->where('options_code', '=', $code)
				->fetchOne(PDO::FETCH_CLASS, "Kernel\Entities\AttributesOption");
	}
	
	public function countAll()
	{
		$args = [];
		if(isset($_SESSION["grids"]["thesaurus"]))
		{
			foreach($_SESSION["grids"]["thesaurus"] as $field => $val)
			{
				if($val != "" and !in_array($field, $this->diff))
				{
					$args[$field] = $field . " LIKE '%".$val."%'";
				}
			}
		}
		$nb = Query::countAll('#_attributs_options', $args);
				
		return $nb;
	}
	
	public function getLibelleMarketing()
	{
		$return = [];
		$libs = Query::select()->from("#_attributs_options")->isNotNull("label_marketing")->fetchAll(PDO::FETCH_CLASS, "Kernel\Entities\AttributesOption");
		
		foreach($libs as $lib)
		{
			$return[$lib->options_code] = $lib->label_marketing;
		}
		
		return $return;
	}
	
}

?>