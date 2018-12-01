<?php
namespace controllers;

use Kernel\Core\Query;
use Kernel\Core\Controllers;



class ResponseServerController extends Controllers {
	
	protected $template_ss_titre = "404";
	
	
	public function display404(){
		
		$this->template->render('404', 'index');
	}
	
}