<?php
namespace controllers;

use Kernel\Core\Query;
use Kernel\Core\Controllers;
use Kernel\Core\Alert;
use Kernel\Core\Grids;
use Kernel\Core\Parser;
use Kernel\Code\Akeneo;



class AdminProductsController extends Controllers {
	
	protected $template_ss_titre = "Produits";
	
	public function displayGrid(){
				
		$this->adminAccesrequired();
		
		Alert::isAlert($this->template);
		
		$this->setjs($this->templateDir."/js/grids.js");
		
		//init grids
		$grid = new Grids("produits");
		
		
		
		
		$this->template->render('grids/produits', 'common');
		
		
	}

	
}

