<?php


function cmd_exclusion($robot, $from, $argument, $body = '', $images = array()){
	

	$oStaticMap = new GoogleStaticMap();
	$oStaticMap->setCenter("Havana,CU")
	->setHeight(500)
	->setWidth(500)
	->setZoom(15)
	->setHttps(true);
	
	
}