<?php

namespace Kernel\Entities;

use Kernel\Core\Query;

class Account{
	
	public function getRight()
	{
		$resultat = array();
		$rows = Query::select()
				->from('#_account_role_right')
				->join('#_account_right', '#_account_right.right_id', '#_account_role_right.right_id')
				->where('role_id', '=', $this->role_id)
				->fetchAll();
		foreach($rows as $row)
		{
			$resultat[$row->right_code] = array();
			if($row->creating == 1) array_push($resultat[$row->right_code], 'create');
			if($row->updating == 1) array_push($resultat[$row->right_code], 'update');
			if($row->deleting == 1) array_push($resultat[$row->right_code], 'delete');
		}
		
		return $resultat;
	}
	
}