<?php
namespace Kernel\Core\Files;



class CSV {
	
	private $fp;
	private $datas = [];
	private $headers = [];
	private $delimiter;
	private $enclosure;
	
	public function __construct($file, $delimiter = ";", $enclosure = '"')
	{
		$this->delimiter = $delimiter;
		$this->enclosure = $enclosure;
		
		$this->fp = fopen($file, "r+");

		$this->parsing();
		
		fclose($this->fp);
	}
	
	private function parsing()
	{
		if($this->fp !== FALSE) {
			
			$i=0;
			while (($datas = fgetcsv($this->fp, 0, $this->delimiter, $this->enclosure)) !== FALSE) {
				if($i == 0)		//les entetes
				{
					foreach($datas as $col => $entete)
					{
						$this->headers[$entete] = $col;
						$entetes[$col] = $entete;
					}
					$i++;
					continue;
				}
				foreach($datas as $col => $val)
				{
					$this->datas[$i-1][$entetes[$col]] = $val;
				}
				$i++;
			}
		}
		
		
	}
	
	public function getHeaders()
	{
		return $this->headers;
	}
	
	public function getDatas($line = null)
	{
		if(is_null($line))
		{
			return $this->datas;
		}
		else
		{
			return $this->datas[$line];
		}
	}
}