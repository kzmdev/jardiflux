<?php

namespace Kernel\Core;
use Kernel\Core\Files\CSV;

class Parser{
	
	public $mine;
	public $extension;
	public $basename;
	public $filename;
	public $dirname;
	public $size;
	public $update;
	public $create;
	public $file;
	public $headers = [];
	public $datas = [];
	
	public function __construct($file){
		
		$this->file = $file;
		$stat = stat($file);
		$path_parts = pathinfo($file);

		
		$this->mine = mime_content_type($file);
		$this->size = $stat["size"];
		$this->create = $this->created();
		$this->update = date('d/m/Y H:i:s', $stat["mtime"]);
		$this->extension = $path_parts["extension"];
		$this->dirname = $path_parts['dirname'];
		$this->basename = $path_parts['basename'];
		$this->filename = $path_parts['filename'];
		
		$this->parse();
		
	}
	
	public function parse(){
		if($this->extension == "csv")
		{
			$csv = new CSV($this->file);
			$this->headers = $csv->getHeaders();
			$this->datas = $csv->getDatas();
		}
	}
	
	private function created()
	{
		$com = new \COM('Scripting.FileSystemObject');
 
		$file = $com->GetFile($this->file);
		$time = variant_date_to_timestamp($file->DateCreated);
		 
		return date('d/m/Y H:i:s', $time);
	}
}

?>