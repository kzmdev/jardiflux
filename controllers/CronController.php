<?php
namespace controllers;

use Kernel\Core\Query;
use Kernel\Core\Akeneo;
use Kernel\Entities\Attribute;
use Kernel\Entities\AttributesOption;
use Kernel\Facades\AttributesOptions;



class CronController {
	
	
	public function MajAttributes(){
						
		$akeneo = new Akeneo();
		$attributes = $akeneo->getAttributes();
		
		foreach($attributes as $code => $attribut)
		{
			$attr = new Attribute();
			$attr->set("code", $code)
					->set("type", $attribut["type"])
					->set("groupe", $attribut["group"])
					->set("default_metric_unit", $attribut["default_metric_unit"])
					->set("max_characters", $attribut["max_characters"])
					->set("label", $attribut["labels"]["fr_FR"])
					->save();
		}
	}
	
	public function MajOptions(){
		$akeneo = new Akeneo();
		$attributes = $akeneo->getAttributes();
		$i=0;
		foreach($attributes as $code => $attribut)
		{
			$ak = new Akeneo();
			foreach($ak->getOptions($code) as $option_code => $option)
			{
				$op = new AttributesOption();
				$op->set("attribute_code", $code)
					->set("options_code", $option_code)
					->set("value", (isset($option["labels"]["fr_FR"]) ? $option["labels"]["fr_FR"] : ""))
					->save(); 
			}
		}
	}
	
	public function MajAxesVariants()
	{
		$akeneo = new Akeneo();
		
		$this->initStart("libMarketing");
		//on recupère les valeurs Marketing		
		$libMarketing = AttributesOptions::getLibelleMarketing();
		
		$this->initEnd("libMarketing");
		echo "le traitement [libMarketing] est terminé en ".$this->SaveDelais("libMarketing")."<br>";
		
		
		$this->initStart("models");
		$models = $akeneo->getModels();
		$this->initEnd("models");
		echo "le traitement [models] est terminé en ".$this->SaveDelais("models")."<br>";
		
		$this->initStart("familles");
		$familles = $akeneo->getFamilies();
		$this->initEnd("familles");
		echo "le traitement [familles] est terminé en ".$this->SaveDelais("familles")."<br>";
				
		
		
		$this->initStart("familles_boucle");
		foreach( $akeneo->getFamilies() as $code => $infos)
		{
			if(in_array("variante_name", $infos["attributs"]))
			{
				$variantFamilly[$code] = $akeneo->getVariant($code);
			} 
		}
		$this->initEnd("familles_boucle");
		echo "le traitement [familles_boucle] est terminé en ".$this->SaveDelais("familles_boucle")."<br>";
		
		$this->initStart("products");
		$products = $akeneo->getProducts('{"family": [{"operator": "IN","value": ["'.implode('","', array_keys($variantFamilly)).'"]}], "variante_name":[{"operator" : "EMPTY"}]}', false);
		$this->initEnd("products");
		echo "le traitement [products] est terminé en ".$this->SaveDelais("products")."<br>";
		
		$this->initStart("products_boucle");
		foreach($products as $sku => $product)
		{
			if(!is_null($product["parent"]))
			{
				
				
				$market = [];
				foreach($variantFamilly[$product["family"]][$models[$product["parent"]]["family_variant"]] as $attribute_code)
				{
					if(isset($libMarketing[$product["formatValue"][$attribute_code]]) and trim($libMarketing[$product["formatValue"][$attribute_code]]) != "nc")
					{
						$market[] = $libMarketing[$product["formatValue"][$attribute_code]];
					}
				}
				$variante_name = implode(" - ", $market);
				$o = new \stdClass();
				$o->identifier = $sku;
				$o->values = new \stdClass();

				$o->values->variante_name = [];
				$o->values->variante_name[0] = new \stdClass();
				$o->values->variante_name[0]->locale = null;
				$o->values->variante_name[0]->scope = null;
				$o->values->variante_name[0]->data = $variante_name;
				
				$this->initStart("productsSave");
				$akeneo->setProduct($sku, $o);
				echo $product["parent"]. "=>".$sku . " => ".$product["family"]." => ".$variante_name."<br>";
				$this->initEnd("productsSave");
				echo "la sauvegarde est terminé en ".$this->SaveDelais("productsSave")."<br>";
				
			}
		}
		$this->initEnd("products_boucle");
		echo "le traitement [products_boucle] est terminé en ".$this->SaveDelais("products_boucle")."<br>";
		exit();
	}
	
	private function initStart($traitement)
	{
		$this->chrono[$traitement]["debut"] = microtime(true); 
	}	
	
	private function initEnd($traitement)
	{
		$this->chrono[$traitement]["fin"] = microtime(true); 
	}
	
	private function SaveDelais($traitement)
	{
		if(isset($this->chrono[$traitement]["debut"]) and isset($this->chrono[$traitement]["fin"]))
		{
			return round(($this->chrono[$traitement]["fin"] - $this->chrono[$traitement]["debut"]), 5);
		}
		else
		{
			return null;
		}
	}
	/* public function SendVariantName()
	{
		$akeneo = new Akeneo();
		
		
		foreach( $akeneo->getFamilies() as $code => $infos)
		{
			if(in_array("variante_name", $infos["attributs"]))
			{
				$result[] = $code;
			} 
		}
		$query = '{"family": [{"operator": "IN","value": ["'.implode('","', $result).'"]}]}';
		var_dump( $result);
		var_dump( $query);
	} */
}

