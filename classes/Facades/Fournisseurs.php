<?php
namespace Kernel\Facades;

use Kernel\Tables\FournisseursTables;
/**
* Class Classes
* Façade de QueryBuilder
*/
class Fournisseurs{

	public static function __callStatic($method, $arguments)
	{
		$query = new FournisseursTables();
		
		return call_user_func_array([$query, $method], $arguments);
	}
}