<?php

namespace Kernel\Entities;

use Kernel\Core\Query;

class Mapping{
	
	
	public function getFromFournisseur($code)
	{
		$result = array();
		$mapping = Query::select()->from("#_mapping")
									->where("fournisseurs_code", "=", $code)
									->fetchAll();
		foreach($mapping as $o)
		{
			$result[$o->header] = $o->attributs_code;
		}
		
		return $result;
	}
	
	public function save($info)
	{
		$ins = Query::insert()->from("#_mapping")
							->set("fournisseurs_code", $info['code'])	
							->set("header", $info["header"]);
		if(isset($info["attributs_code"]))
		{
			$ins->set("attributs_code", (($info["attributs_code"] == "") ? NULL : $info["attributs_code"]));
		}
		if(isset($info["exemple"]))
		{
			$ins->set("exemple", (($info["exemple"] == "") ? NULL : $info["exemple"]));
		}
		$ins->save();
	}
	
}