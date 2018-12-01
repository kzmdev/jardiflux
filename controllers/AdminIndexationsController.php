<?php
namespace controllers;

use Kernel\Core\Query;
use Kernel\Core\Controllers;
use Kernel\Core\Alert;
use Kernel\Core\Akeneo;
use Kernel\Core\Grids;
use Kernel\Facades\Indexations;




class AdminIndexationsController extends Controllers {
	
	protected $template_ss_titre = "Indexations";
	
	/* public function __construct(){
		
	} */
	
	public function displayGrid($post=null){
				
		$this->adminAccesrequired();
		
		Alert::isAlert($this->template);
		
		$liste = Indexations::all();
		
		
		$this->template->assign("liste", $liste);
		$this->template->render('indexation', 'common');
		
		
	}
	
}

