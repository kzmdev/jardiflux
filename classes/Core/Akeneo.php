<?php

namespace Kernel\Core;
use \Exception;

class Akeneo{
	
	private $debug = false;
	private $attributes = [];
	private $families = [];
	private $axes = [];
	private $options = [];
	private $produits = [];
	private $models = [];
	
	public function __construct()
	{
		$this->token = $this->getToken();
		echo $this->token."<br>";
	}
	
	private function getToken(){

		$userData = array(
							"grant_type" => AKENEO_GRANT, 
							"username" => AKENEO_LOG, 
							"password" => AKENEO_MDP
						);
						
		$ch = curl_init(AKENEO_DNS . "/api/oauth/v1/token");
	
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
													"Content-Type: application/json", 
													"Authorization: Basic " . AKENEO_APIKEY
													));
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		
		$result = curl_exec($ch);
		$error = curl_errno($ch);
		$response = json_decode($result, true);
		
		if($this->debug)
		{
			$error = curl_errno($ch);
			$this->Error(curl_strerror($error));
			var_dump($result);
		}
		
		
		return $response["access_token"];
	}
	
	private function callCurl($endpoint, $method, $body = null, $debug=false)
	{
		$ch = curl_init(AKENEO_DNS . $endpoint);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		if(!is_null($body))
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
		}
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
													"Content-Type: application/json", 
													"Authorization: Bearer " . $this->token
													));
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		
		$result = curl_exec($ch);
		$error = curl_errno($ch);
		
		if($debug)
		{
			echo urldecode(AKENEO_DNS . $endpoint)."<br>";
			echo $method.'<br>';
			var_dump($body);
			echo json_encode($body)."<br>";
			$error = curl_errno($ch);
			$this->Error(curl_strerror($error));
		}
		
		return json_decode($result, true);
	}
	
	public function getProducts($query = null, $once=true, $limite=100)
	{
		$result = [];
				
		
		$endpoint = "/api/rest/v1/products?limit=".$limite."&pagination_type=search_after";
		if(!is_null($query))
		{
			$endpoint .= "&search=".urlencode($query);
		}
		
		$this->getlisteProduit($endpoint, $once);
		
		
		
		return $this->produits;
	}
	
	
	private function getlisteProduit($url, $once)
	{
		$next = str_replace(AKENEO_DNS, "", $url);
		$result = [];
		$iteration = $this->callCurl($next, "GET");
	
		if(!$once)
		{
			//on relance si il y a plusieurs page
			if(isset($iteration["_links"]["next"]["href"]) and $iteration["_links"]["next"]["href"] != "")
			{
				$next = str_replace(AKENEO_DNS, "", $iteration["_links"]["next"]["href"]);
				foreach($iteration["_embedded"]["items"] as $item)
				{
					$this->produits[$item["identifier"]] = array(
																	"family" => $item["family"],
																	"parent" => $item["parent"],
																	"categories" => $item["categories"],
																	"formatValue" => $this->formatValue($item["values"])
															);
					
				}
				$this->getlisteProduit($next, $once);
			}
			else
			{
				if(isset($iteration["_embedded"]["items"]))
				{
					foreach($iteration["_embedded"]["items"] as $item)
					{
						
						$this->produits[$item["identifier"]] = array(
																		"family" => $item["family"],
																		"parent" => $item["parent"],
																		"categories" => $item["categories"],
																		"formatValue" => $this->formatValue($item["values"])
																);

					}
				}
			}
		}
		else			
		{
			
			foreach($iteration["_embedded"]["items"] as $item)
			{
				
				$this->produits[$item["identifier"]] = array(
																"family" => $item["family"],
																"parent" => $item["parent"],
																"categories" => $item["categories"],
																"formatValue" => $this->formatValue($item["values"])
														);

			}
		}
		
	}
	
	public function getProduct($sku)
	{
			
		$product = $this->callCurl("/api/rest/v1/products/".$sku, "GET");
		
		if(!is_null($product))
		{
			$product["formatValue"] = $this->formatValue($product["values"]);
		}
		
		return $product;
	}
	
	public function setProduct($identifiant, $body)
	{
		$batch = $this->callCurl("/api/rest/v1/products/".$identifiant, "PATCH", $body, true);
	}
	
	public function getModel($sku)
	{
		$url = "/api/rest/v1/product-models/".$sku;
		$item = $this->callCurl($url, "GET");
		
		return $item;
	}
	
	public function getModels($next=null)
	{
		//echo $this->token."<br>";
		$url = (is_null($next) ? "/api/rest/v1/product-models?limit=100&pagination_type=search_after" : $next);
		
		$items = $this->callCurl($url, "GET");
		
		if(isset($items["_links"]["next"]["href"]) and $items["_links"]["next"]["href"] != "")
		{
			$next = str_replace(AKENEO_DNS, "", $items["_links"]["next"]["href"]);
			
			foreach($items["_embedded"]["items"] as $item)
			{
				
				$this->models[$item["code"]] = $item;

			}
			$this->getModels($next);
		}
		else
		{
			if(isset($items["_embedded"]["items"]))
			{
				foreach($items["_embedded"]["items"] as $item)
				{
					
					$this->models[$item["code"]] = $item;

				}
			}
		}
		return $this->models;
	}
	
	public function getVariant($family_code)
	{
		
		$url = "/api/rest/v1/families/".$family_code."/variants?limit=100&pagination_type=page";
		$items = $this->callCurl($url, "GET");
		
		$axe = [];
		
		foreach($items["_embedded"]["items"] as $item)
		{
			foreach($item["variant_attribute_sets"] as $axes)
			{
				$axe[$item["code"]] = (isset($axes["axes"]) ? $axes["axes"] : array());
			}
		}
		
		return $axe;
	}
	
	public function getFamilies($next=null)
	{
				
		$url = (is_null($next) ? "/api/rest/v1/families?limit=100&pagination_type=page" : $next);
		
		$items = $this->callCurl($url, "GET");
		
		if(isset($items["_links"]["next"]["href"]) and $items["_links"]["next"]["href"] != "")
		{
			$next = str_replace(AKENEO_DNS, "", $items["_links"]["next"]["href"]);
			
			foreach($items["_embedded"]["items"] as $item)
			{
				
				$this->families[$item["code"]] = array(
														"attributs" => $item["attributes"],
														"requirements" => (isset($item["attribute_requirements"]->ecommerce) ? $item["attribute_requirements"]->ecommerce : [])
														);

			}
			$this->getFamilies($next);
		}
		else
		{
			foreach($items["_embedded"]["items"] as $item)
			{
				
				$this->families[$item["code"]] = array(
														"attributs" => $item["attributes"],
														"requirements" => (isset($item["attribute_requirements"]->ecommerce) ? $item["attribute_requirements"]->ecommerce : [])
														);

			}
		}
		return $this->families;
	}
	
	public function getAttributes($next=null)
	{
		
		$url = (is_null($next) ? "/api/rest/v1/attributes?limit=100&pagination_type=page" : $next);
				
		$attributes = $this->callCurl($url, "GET");
		
		if(isset($attributes["_links"]["next"]["href"]) and $attributes["_links"]["next"]["href"] != "")
		{
			$next = str_replace(AKENEO_DNS, "", $attributes["_links"]["next"]["href"]);
			foreach($attributes["_embedded"]["items"] as $items)
			{
				
				if(isset($items["labels"]["fr_FR"]))
				{
					$this->attributes[$items["code"]] = $items;
				}
				else
				{
					//var_dump($items);
				}
			}
			//var_dump($this->attributes);
			$this->getAttributes($next);
		}
		else
		{//var_dump($attributes);
			foreach($attributes["_embedded"]["items"] as $items)
			{
				$this->attributes[$items["code"]] = $items;
			}
			
		}
		return $this->attributes;
	}
	
	public function getOptions($attribut_code, $next=null)
	{
		$url = (is_null($next) ? "/api/rest/v1/attributes/".$attribut_code."/options?limit=100&with_count=true" : $next);
		
		$options = $this->callCurl($url, "GET");
		
		if(isset($options["_links"]["next"]["href"]) and $options["_links"]["next"]["href"] != "")
		{
			$next = str_replace(AKENEO_DNS, "", $options["_links"]["next"]["href"]);
			foreach($options["_embedded"]["items"] as $items)
			{
				$this->options[$items["code"]] = $items;
			}
			$this->getOptions($attribut_code, $next);
		}
		else
		{
			if(isset($options["_embedded"]["items"]))
			{
				foreach($options["_embedded"]["items"] as $items)
				{
					$this->options[$items["code"]] = $items;
				}
			}
		}
		
		return $this->options;
		
	}
	
	public function setOptions($infos)
	{
		$body = new \StdClass();
		$body->attribute = $infos["attribute_code"];
		$body->code = $infos["options_code"];
		$body->sort_order = 1;
		$body->labels = new \StdClass();
		$body->labels->fr_FR = $infos["value"];
		
		$endpoint = "/api/rest/v1/attributes/".$infos["attribute_code"]."/options/".$infos["options_code"];
		
		$this->callCurl($endpoint, "PATCH", $body, true); 
	}
	
	
	
	private function Error($msg)
	{
		// Fatal error
		//throw new Exception('AKENEO error: '.$msg);
		var_dump($msg);
	}
	
	private function formatValue($values)
	{
		$return = array();
		foreach($values as $attribut_code => $infos)
		{
			foreach($infos as $info)
			{
				if(is_null($info["locale"]) or $info["locale"] == 'fr_FR')
				{
					$return[$attribut_code] = $info["data"];
				}
			}
		}
		
		return $return;
	}
}

?>