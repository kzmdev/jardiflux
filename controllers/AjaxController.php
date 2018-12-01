<?php
namespace controllers;

use Kernel\Core\Query;
use Kernel\Core\Controllers;
use Kernel\Core\Parser;
use Kernel\Facades\Fournisseurs;
use Kernel\Entities\Mapping;
use Kernel\Entities\AttributesOption;



class AjaxController extends Controllers {
	
	protected $template_ss_titre = "404";
	
	
	public function UploadMapping()
	{
		$h = getallheaders();
		$source = file_get_contents('php://input');
		
		if(file_exists(_TEMP_HEADERS."/".$h["x-file-name"]))
		{
			unlink(_TEMP_HEADERS."/".$h["x-file-name"]);
		}
		file_put_contents(_TEMP_HEADERS."/".$h["x-file-name"], $source);
		
		$csv = new Parser(_TEMP_HEADERS."/".$h["x-file-name"]);
		
		$datas = $csv->datas[0];
		
		foreach($csv->headers as $header => $col)
		{
			//on enregistre
			$info = array(
							"code" => $h["x-params-fournisseur"],
							"header" => $header,
							"exemple" => (isset($datas[$header]) ?$datas[$header] : "")
						);
			$map = new Mapping();
			$map->save($info);
			
		}
		
		$item = Fournisseurs::get($h["x-params-fournisseur"]);
		$mapping = $item->getMapping();
		ksort($mapping);
		echo json_encode($mapping);
	}
	
	public function setMapping()
	{
		$map = new Mapping();
		$map->save($_POST);
	}
	
	public function UploadMarketingLabel()
	{
		$h = getallheaders();
		$source = file_get_contents('php://input');
		
		if(file_exists(_TEMP_HEADERS."/".$h["x-file-name"]))
		{
			unlink(_TEMP_HEADERS."/".$h["x-file-name"]);
		}
		file_put_contents(_TEMP_HEADERS."/".$h["x-file-name"], $source);
		
		$csv = new Parser(_TEMP_HEADERS."/".$h["x-file-name"]);
		
		$headersWanted = ["attribute_code","options_code","label_marketing"];
		$headers = $csv->headers;
		
		$missed = array_diff($headersWanted, array_keys($headers));
		
		if(count($missed) > 0)
		{
			$error = [
						"error" => 1,
						"msg" => "Les colonnes suivantes sont manquantes : [". implode("] ", $missed)
			];

			echo json_encode($error);
			exit();
		}
		else
		{
			$i = 0;
			$success = 0;
			$rejets = [];
			foreach($csv->datas as $line)
			{
				if($line["attribute_code"] == "" or $line["options_code"] == "")
				{
					if($line["attribute_code"] == "")
					{
						$rejets[] = "ligne [".$i."] : la valeur attribute_code ne peut être vide";
					}
					elseif($line["options_code"] == "")
					{
						$rejets[] = "ligne [".$i."] : la valeur options_code ne peut être vide";
					}
				}
				else
				{
					//on test l'existence de l'attribut code
					
					$op = new AttributesOption();
					$op->set("attribute_code", $line["attribute_code"]);
					$op->set("options_code", $line["options_code"]);
					$op->set("label_marketing", $line["label_marketing"]);
					$op->save();
				}
				$i++;
			}
			
			$result = [
						"error" => 0,
						"msg" => $i." libelles marketing ont été mis à jour",
						"rejets" => $rejets
			];

			echo json_encode($result);
			exit();
		}
		
	}		
}