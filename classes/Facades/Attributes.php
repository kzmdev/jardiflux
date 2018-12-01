<?php
namespace Kernel\Facades;

use Kernel\Tables\AttributesTables;
/**
* Class Classes
* Façade de QueryBuilder
*/
class Attributes{

	public static function __callStatic($method, $arguments)
	{
		$query = new AttributesTables();
		
		return call_user_func_array([$query, $method], $arguments);
	}
}