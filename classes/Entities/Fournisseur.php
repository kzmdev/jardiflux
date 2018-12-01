<?php

namespace Kernel\Entities;

use Kernel\Core\Query;
use Kernel\Facades\Attributes;

class Fournisseur{
	
	
	public function set($attr, $val)
	{
		$this->$attr = $val;
		
		return $this;
	}
	
	public function get($attr)
	{
		return $this->$attr;
	}
	
	public function getMapping()
	{
		$result = array();
		$attr = Attributes::allLabel();
		
		$mapping = Query::select()->from("#_mapping")
									->where("fournisseurs_code", "=", $this->code)
									->fetchAll();
		foreach($mapping as $o)
		{
			$result[$o->header] = [
									"attributs_code" => $o->attributs_code,
									"attributs_label" => (isset($attr[$o->attributs_code]) ? $attr[$o->attributs_code] : ""),
									"exemple"	=> $o->exemple
								];
		}
		
		return $result;
	}
	
	public function save()
	{
		
	}
	
}