<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsFunction
 */
 
 /**
 * Smarty {html_datatables} function plugin
 * Type:     function<br>
 * Name:     html_table<br>
 * Date:     Feb 01, 2017<br>
 * Purpose:  restitue une datatable avec les arguments<br>
 * Params:
 * paging 		-booleen -true affiche la pagination -false cache la navigation -defaut:true
 * ordering 	-booleen -true autorise l'ordonnance des colonnes				-defaut:true
 * info  		-booleen -true affiche les infos xx sur yy pour un total de zz -false cache les infos	-defaut:false
 * searching	-booleen -true affiche le moteur de recherche -false cache le moteur	-defaut:true
 */
 
function smarty_function_html_datatables($params)
{
	$opt['paging'] 		= (isset($params['paging']) ? $params['paging'] : true);
	$opt['ordering'] 	= (isset($params['ordering']) ? $params['ordering'] : true);
	$opt['info'] 		= (isset($params['info']) ? $params['info'] : false);
	$opt['searching'] 	= (isset($params['searching']) ? $params['searching'] : true);
	
	//include("modules/mod_HTML_datatables/html/datatable.php");
	
	return _MODULES_;
}