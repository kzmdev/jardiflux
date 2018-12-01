<?php
namespace Kernel\Core;
use Kernel\Core\Grids;

class Controllers{
	
	protected $type = "admin";
	protected $menu_selected = "";
	protected $config = "";
	protected $template = null;
	protected $template_ss_titre = "";
	protected $datatables = false;
	
	protected $js = array(	_WEB_ .'js/jquery.min.js', 
							_WEB_ .'js/jquery-ui.min.js', 
							_WEB_ .'js/bootstrap.min.js'
						);
	protected $css = array(
							_WEB_ . 'css/bootstrap.css',
							_WEB_ . 'css/jquery-ui.min.css',
							_WEB_ . 'css/jquery-ui.structure.min.css',
							_WEB_ . 'css/jquery-ui.theme.min.css',
							_WEB_ . 'css/animated-icone.css'
						);
	protected $templateDir = "";
	
	protected $lg;
	
	protected $current_grid = null;
	
	protected $grid;
	
	public function __construct()
	{
		if($this->type != "")
		{
			$this->lg = (isset($_SESSION["Auth"]["lg"]) ? $_SESSION["Auth"]["lg"] : "FR");
			
			$iTemplate = Query::select()
					->from('#_templates')
					->where('default', '=', $this->type)
					->fetchOne();
			
			$this->config = 'templates/'.$iTemplate->path; 
			$this->setTemplate();
			
			foreach($this->js as $path)
			{
				$this->setjs($path);
			}
			
			
			foreach($this->css as $path)
			{
				$this->setcss($path);
			}
			
			if($this->datatables)
			{
				$this->setjs('https://cdn.datatables.net/v/bs/dt-1.10.15/fc-3.2.2/fh-3.1.2/r-2.1.1/datatables.min.js');
				$this->setcss('https://cdn.datatables.net/v/zf/dt-1.10.15/fc-3.2.2/fh-3.1.2/r-2.1.1/datatables.min.css');
			}
		}
		
		if(!is_null($this->current_grid))
		{
			//init grids
			$this->grid = new Grids($this->current_grid);
		}
		
	}
	
	protected function setTemplate()
	{
		global $smarty;
		
		$this->template = new SMTemplate($smarty, $this->config);
		$this->templateDir = "/".$this->template->pathTemplate();
		
		$this->template->assign("_template_dir", $this->templateDir);
		$this->template->assign("menu_selected", $this->menu_selected);
		$this->template->assign("template_ss_titre", $this->template_ss_titre);
		$this->template->assign("lg", $this->lg);
	}
	
	protected function setjs($path)
	{
		$this->template->setJS($path);
	}
	
	protected function setcss($path)
	{
		$this->template->setCSS($path);
	}
	
	protected function treatment($query){
		$args = explode("/", $query);
		foreach($args as $key => $arg)
		{
			if($key%2 == 0)
			{
				$field[$arg] = $args[$key+1];
			}
		}
		return $field;
	}
	
	protected function adminAccesrequired()
	{
		if(!isset($_SESSION["Auth"]) OR (isset($_SESSION["Auth"]["acces"]) and  $_SESSION["Auth"]["acces"] != "authorized"))
		{
			header("Location: /"._AdminPath_);
			exit();
		} 
	}
}
?>