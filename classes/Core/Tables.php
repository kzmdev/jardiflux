<?php

namespace Kernel\Core;

class Tables{
	
	private $a = array();
	public $entetes = array();
	public $lines = array();
	
	public function __construct($array)
	{
		$this->a = $array;
		$this->getEntetes();
		$this->getLines();
	}
	
	private function geEntetes(){
		foreach($$this->a as $lignes)
		{
			foreach($lignes as $entete => $val)
			{
				if(!in_array($this->entetes, $entetes))
				{
					$this->entetes[] = $entete;
				}
			}
		}
	}
	
	private function getLines(){
		
	}
}

?>