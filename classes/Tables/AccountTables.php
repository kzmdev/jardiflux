<?php

namespace Kernel\Tables;

use Kernel\Entites\Account;
use Kernel\Core\Query;
use \PDO;

class AccountTables{
	
	public function hasAccess($log, $mdp)
	{
		$o = Query::select()
				->from('#_account')
				->where('username', '=', $log)
				->isNull("locked", 'and')
				->fetchOne(PDO::FETCH_CLASS, "Kernel\Entities\Account");
				
		if(isset($o->mdp))
		{
			if (password_verify($mdp, $o->mdp)) {
				
				unset($o->mdp);
				foreach($o as $f => $v)
				{
					$_SESSION["Auth"][$f] = $v;
				}
				
				//les droits
				$_SESSION["Auth"]["droit"] = $o->getRight();
				$_SESSION["Auth"]["acces"] = "authorized";
				
				//la gestion de la langue
				$_SESSION["Auth"]["lg"] = "FR";	//TODO: modifier la langue
				
				return true;
			}
		}
		
		
		return false;
	}
	
	
	public static function getMDP($mdp)
	{
		$options = [
			'cost' => 10
		];
		
		return  password_hash($mdp, PASSWORD_BCRYPT, $options);
	}
}

?>