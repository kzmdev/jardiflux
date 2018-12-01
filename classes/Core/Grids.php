<?php
namespace Kernel\Core;

class Grids {
	
	public $by_page = 10;
	public $page = 1;
	private $gridName; 
	
	public function __construct($gridName) {
		$this->gridName = $gridName;
		$this->setDefaultValues();
		$this->init();
		
	}
	
	private function setDefaultValues()
	{
		foreach($_POST as $field => $val)
		{	
			$_SESSION["grids"][$this->gridName][$field] = $val;
		}
	}
	
	private function init()
	{
	
		if(isset($_SESSION["grids"][$this->gridName]))
		{
			foreach($_SESSION["grids"][$this->gridName] as $field => $val)
			{
				$this->$field = $val;
			}
		}
	}
}
?>