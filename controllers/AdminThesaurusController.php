<?php
namespace controllers;

use Kernel\Core\Query;
use Kernel\Core\Controllers;
use Kernel\Core\Alert;
use Kernel\Core\Akeneo;
use Kernel\Core\Grids;
use Kernel\Facades\AttributesOptions;
use Kernel\Entities\AttributesOption;



class AdminThesaurusController extends Controllers {
	
	protected $template_ss_titre = "Thesaurus";
	
	/* public function __construct(){
		
	} */
	
	public function displayGrid($post=null){
				
		$this->adminAccesrequired();
		
		Alert::isAlert($this->template);
		
		$this->setjs($this->templateDir."/js/grids.js");
		$this->setjs($this->templateDir."/js/uploader.js");
		
		//init grids
		$grid = new Grids("thesaurus");
		
		
		$liste = AttributesOptions::liste(['by_page' => $grid->by_page,'page' => $grid->page]);
		$nbDataTotal = AttributesOptions::countAll();
		$nbPageMax = ceil($nbDataTotal/$grid->by_page);
		
		$this->template->assign("liste", $liste);
		$this->template->assign("total", $nbDataTotal);
		$this->template->assign("nbPageMax", $nbPageMax);
		$this->template->assign("currentPage", $grid->page);
		$this->template->assign("byPage", $grid->by_page);
		
		$this->template->render('grids/thesaurus', 'common');
		
		
	}
	
	public function displayForm($code=null){
		
		$this->adminAccesrequired();
		
		$this->setjs($this->templateDir."/js/form.js");
		
		if(!is_null($code))
		{
			$item = AttributesOptions::get($code);
			
			$this->template->assign("item", $item);
			$this->template->assign("thesaurus", explode(",", $item->thesaurus));
		}
		
		$this->template->render('forms/thesaurus', 'common');
	}
	
	public function formAction()
	{
		
		$op = new AttributesOption();
		$op->set('attribute_code', $_POST['attribute_code']);
		$op->set('options_code', $_POST['options_code']);
		$op->set('value', $_POST['value']);
		if(isset($_POST["label_marketing"]))
		{
			$op->set('label_marketing', $_POST['label_marketing']);
		}
		$thesaurus = (isset($_POST["thesaurus"]) ? implode(",",$_POST['thesaurus']) : "");
		$op->set('thesaurus', $thesaurus);
		$op->save();
		
		$url = ((isset($_POST["callback"]) and $_POST["callback"] != "") ? $_POST["callback"] : "/");
		header("Location: ".$url);
		exit();
		
	}
	
	public function formGrid(){
			//init grids
			$grid = new Grids("thesaurus");
			
			header("Location: /"._AdminPath_."/thesaurus");
			exit();
		}
		
}

