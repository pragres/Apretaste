<?php

class ApretasteEmailLogger{

	function __construct($verbose=false,$debug=false){
		
		$this->verbose=$verbose;
		$this->debug=$debug;
	}
	
	function log($message,$result){		
		echo $this->verbose ? "creating log for message\n" : "";
		
		$id = Apretaste::message($message, $result);
		
		if($this->debug){
			//var_dump($message);
			//var_dump($result);
		}
                
                return $id;
	}

}
