<?php
namespace controllers;

use Kernel\Core\Query;
use Kernel\Core\Controllers;
use Kernel\Core\Alert;
use Kernel\Entites\Account;
use Kernel\Tables\AccountTables;

class AdminIndexController extends Controllers {
	
	protected $template_ss_titre = "Identification";
	
	public function display(){

		if(isset($_SESSION["Auth"]) and $_SESSION["Auth"]["acces"] == "authorized")
		{
			header("Location: /"._AdminPath_."/dashboard");
			exit();
		} 
		
		if((isset($_POST["username"]) and $_POST["username"]!= "") and (isset($_POST["password"]) and $_POST["password"]!= ""))
		{
			$account = new AccountTables();
			if(!$account->hasAccess($_POST["username"], $_POST["password"]))
			{
				Alert::error("Vos clés d'accès n'ont pas été reconnues !");
				header("Location: /" . _AdminPath_ );
				exit(); 
			}
		}
		
		Alert::isAlert($this->template);
		
		$this->template->render('authentification', 'index');
	}
}