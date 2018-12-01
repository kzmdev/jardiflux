<?php

namespace Kernel\Entities;

use Kernel\Core\Query;

class AttributesOption{
	
	public function set($attr, $val)
	{
		$this->$attr = $val;
		
		return $this;
	}
	
	public function get($attr)
	{
		return isset($this->$attr) ? $this->$attr : "";
	}
	
	
	public function save()
	{
		
			$ins = Query::insert()->from("#_attributs_options")
					->set("attribute_code", $this->attribute_code)
					->set("options_code", $this->options_code);
			if(isset($this->value))
			{
				$ins->set("value", $this->value);
			}
			if(isset($this->thesaurus))
			{
					$ins->set("thesaurus",$this->thesaurus);
			}
			if(isset($this->label_marketing))
			{
					$ins->set("label_marketing",$this->label_marketing);
			}
			$ins->save();
		
	}

	public function isAxe()
	{
		$result = Query::select('groupe')->from("#_attributs")->where("code", "=", $this->attribute_code)->fetchOne();
		
		return (($result->groupe == "axe") ? true : false);
	}
}