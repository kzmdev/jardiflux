<?php
namespace controllers;

use Kernel\Core\Query;
use Kernel\Core\Controllers;
use Kernel\Core\Alert;
use Kernel\Core\Akeneo;
use Kernel\Facades\Attributes;


class AdminAttributesController extends Controllers {
	
	protected $template_ss_titre = "Dashboard";
	
	public function display(){
				
		if(!isset($_SESSION["Auth"]) OR (isset($_SESSION["Auth"]["acces"]) and  $_SESSION["Auth"]["acces"] != "authorized"))
		{
			header("Location: /"._AdminPath_);
			exit();
		} 
		
		Alert::isAlert($this->template);
		$objets = Attributes::all();
		
		var_dump($objets);
		
		$this->template->render('dashboard', 'common');
		
		
	}
}

