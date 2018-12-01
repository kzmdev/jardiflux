<?php
namespace Kernel\Facades;

use Kernel\Tables\IndexationsTables;
/**
* Class Classes
* Façade de QueryBuilder
*/
class Indexations{

	public static function __callStatic($method, $arguments)
	{
		$query = new IndexationsTables();
		
		return call_user_func_array([$query, $method], $arguments);
	}
}