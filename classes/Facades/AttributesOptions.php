<?php
namespace Kernel\Facades;

use Kernel\Tables\AttributesOptionsTables;
/**
* Class Classes
* Façade de QueryBuilder
*/
class AttributesOptions{

	public static function __callStatic($method, $arguments)
	{
		$query = new AttributesOptionsTables();
		
		return call_user_func_array([$query, $method], $arguments);
	}
}