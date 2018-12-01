<?php
namespace Kernel\Core;

class SMTemplate{  
     
    private $css = array();
	private $js = array();
	
    public function __construct(&$smarty, $conf = ''){  
		$add_config = array();
		$ini_config = array();
		 
      
		if($conf != "")
		{
			$smarty->config_load(_PATH_.$conf."global.conf");
			$add_config = $smarty->get_config_vars();
			if(file_exists(_PATH_.$conf."template.conf"))
			{
				$smarty->config_load(_PATH_.$conf."template.conf");
				$ini_config = $smarty->get_config_vars();
			}
		}
		else
		{
			$smarty->config_load(_CONFIG_."global.conf");
			$add_config = $smarty->get_config_vars();
		}
		
		$smtemplate_config = array_merge($ini_config, $add_config);
		
		$this->conf = $conf;
		$smarty->template_dir = _PATH_.$smtemplate_config['template_dir'];  
		$smarty->addTemplateDir(_PATH_.$smtemplate_config['layouts_dir']);
		$smarty->compile_dir = _PATH_.$smtemplate_config['compile_dir'];  
        $smarty->cache_dir = _PATH_.$smtemplate_config['cache_dir'];  
		
		$this->templatedir = $smtemplate_config['layouts_dir'];  
		
		$this->o = $smarty;
    }  
	
	public function setJS($path)
	{
		if(!in_array('<script language="Javascript" src="'. $path . '"></script>', $this->js))
		{
			$this->js[] = '<script language="Javascript" src="'. $path . '"></script>';
		}
	}
	public function setCSS($path)
	{
		if(!in_array('<link href="'.$path.'" rel="stylesheet">', $this->css))
		{
			$this->css[] = '<link href="'.$path.'" rel="stylesheet">';
		}
	}
	
	public function render($template, $layout = 'layout'){  
		
		$content = $this->o->fetch($template . '.tpl'); 
		$listJs = array();
		$listCss = array();
				
        $this->o->assign('__content', $content);  
		$this->o->assign('__path_dir', _PATH_);  
		
		$this->o->assign('__js', implode(PHP_EOL, $this->js));
		$this->o->assign('__css', implode(PHP_EOL, $this->css));
       
	   $this->o->display('layouts/'.$layout . '.tpl');  
		
		$_debug_var['template'][] = "template : $template";
    }  
	
	public function display($tpl)
	{
		 $this->o->display($tpl . '.tpl');  
	}
	
	public function fetch($tpl)
	{
		return $this->o->fetch($tpl . '.tpl'); 
	}
	
	public function assign($val, $var)
	{
		 $this->o->assign($val, $var); 
	}
	
	public function pathTemplate()
	{
		return $this->templatedir;
	}
} 

?>