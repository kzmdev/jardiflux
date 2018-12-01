<?php
namespace Kernel\Core;

/**
* Class Query
* Façade de QueryBuilder
*/
class Query{

	public static function __callStatic($method, $arguments)
	{
		$query = new QueryBuilder();
		return call_user_func_array([$query, $method], $arguments);
	}
}