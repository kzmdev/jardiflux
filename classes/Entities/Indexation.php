<?php

namespace Kernel\Entities;

use Kernel\Core\Query;

class Indexation{
	
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
		
	}

	
}