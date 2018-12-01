<?php
namespace controllers;

use Kernel\Core\Query;
use Kernel\Core\Controllers;
use Kernel\Core\Alert;
use Kernel\Facades\Attributes;
use Kernel\Core\Grids;
use Kernel\Core\Parser;
use Kernel\Facades\Fournisseurs;
use Kernel\Entities\Mapping;



class AdminFournisseursController extends Controllers {
	
	protected $template_ss_titre = "Fournisseurs";
	
	public function displayGrid(){
				
		$this->adminAccesrequired();
		
		Alert::isAlert($this->template);
		
		$this->setjs($this->templateDir."/js/grids.js");
		
		//init grids
		$grid = new Grids("fournisseurs");
		
		
		$liste = Fournisseurs::liste(['by_page' => $grid->by_page,'page' => $grid->page]);
		$nbDataTotal = Fournisseurs::countAll();
		$nbPageMax = ceil($nbDataTotal/$grid->by_page);
		
		$this->template->assign("liste", $liste);
		$this->template->assign("total", $nbDataTotal);
		$this->template->assign("nbPageMax", $nbPageMax);
		$this->template->assign("currentPage", $grid->page);
		$this->template->assign("byPage", $grid->by_page);
		
		$this->template->render('grids/fournisseurs', 'common');
		
		
	}
	
	public function displayForm($id)
	{
		$this->adminAccesrequired();
		
		$this->setjs($this->templateDir."/js/form.js");
		$this->setjs($this->templateDir."/js/tags.js");
		
		$item = Fournisseurs::get($id);
		$this->template->assign("template_ss_titre", "Fournisseur / ".$item->login);
		
		$mapping = $item->getMapping();
		ksort($mapping);
		
		$attributs = Attributes::all();
		
		$this->template->assign("attributs", $attributs);
		$this->template->assign("mapping", $mapping);
		$this->template->assign("item", $item);
		$this->template->render('forms/fournisseur', 'common');
	}
	
	public function formGrid()
	{
		
		//init grids
		$grid = new Grids("fournisseurs");
		
		header("Location: /"._AdminPath_."/fournisseur");
		exit();
	}
	
}

