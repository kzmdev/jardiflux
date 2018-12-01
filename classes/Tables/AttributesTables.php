<?php

namespace Kernel\Tables;

use Kernel\Entities\Attribute;
use Kernel\Core\Query;
use \PDO;

class AttributesTables{
		
	public static function create($infos)
	{
		foreach($infos as $info)
		{
			$attr = new Attribute();
			$attr->set("code", $info["code"]);
			$attr->set("type", $info["type"]);
			$attr->set("groupe", $info["group"]);
			$attr->set("default_metric_unit", $info["default_metric_unit"]);
			$attr->set("max_characters", $info["max_characters"]);
			$attr->set("label", (isset($info["labels"]["fr_FR"]) ? $info["labels"]["fr_FR"] : ""));
			$attr->save();
		}
	}
	
	public static function find($id)
	{
	}
	
	public static function all()
	{
		$attr = Query::select()->from("#_attributs")->fetchAll(PDO::FETCH_CLASS, "Kernel\Entities\Attribute");
		
		usort($attr, 'self::comparer');
		
		return $attr;
	}
	
	public static function allLabel()
	{
		$result = [];
		$attrs = self::all();
		
		foreach($attrs as $attr)
		{
			$result[$attr->get("code")] = $attr->get("label");
		}
		
		return $result;
	}
	
	public static function comparer($a, $b) {
	  return strcmp($a->get('natural'), $b->get('natural'));
	}
	
}

?>