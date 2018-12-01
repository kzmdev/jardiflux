<?php

namespace Kernel\Tables;

use Kernel\Entities\Indexation;
use Kernel\Core\Query;
use \PDO;

class IndexationsTables{
		
	public function all()
	{
		return Query::select()->from("#_indexations")->fetchAll(PDO::FETCH_CLASS, "Kernel\Entities\Indexation");
	}
	
}

?>