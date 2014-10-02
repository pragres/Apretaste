<?php 

class ApretasteApp extends div{

	public function getPage($url){
		return file_get_contents($url);
	}

}