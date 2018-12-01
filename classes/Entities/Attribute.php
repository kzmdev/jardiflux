<?php

namespace Kernel\Entities;

use Kernel\Core\Query;

class Attribute{
	
	private $code = "";
	private $type = "";
	private $groupe = "test";
	private $label = "";
	private $default_metric_unit = null;
	private $max_characters = null;
	private $natural = "";
	
	public function __construct()
	{
		$this->natural = $this->skip_accents($this->label);
		
	}
	
	private function skip_accents( $str, $charset='utf-8' ) {
 
		$str = htmlentities( $str, ENT_NOQUOTES, $charset );
		
		$str = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str );
		$str = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $str );
		$str = preg_replace( '#&[^;]+;#', '', $str );
		
		return $str;
	}
	
	/* public function __call($name, $arguments)
	{
		$arg = "";
		//on recupere les 3 premiers caracteres
		$methode = substr($name,0,3);
		echo $methode."<br>";
		$aname = str_split(str_replace($methode, "",$name));
		$i=0;
		foreach($aname as $lettre)
		{
			if(strtoupper($lettre) === $lettre)
			{
				$arg .= (($i>0) ? "_" : "").strtolower($lettre);
			}
			else
			{
				$arg .= $lettre;
			}
			
			$i++;
		}
		var_dump($this->$methode($arg));
	} */
	
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
		Query::insert()->from("#_attributs")
					->set("code", $this->code)
					->set("type", $this->type)
					->set("groupe", $this->groupe)
					->set("label",$this->label)
					->set("default_metric_unit", $this->default_metric_unit)
					->set("max_characters", $this->max_characters)
					->save();
	}
	
}