<?php
function cmd_map($robot, $from, $argument, $body = '', $images = array()){
	$oStaticMap = new GoogleStaticMap();
	$oStaticMap->setCenter("$argument");
	$oStaticMap->setHeight(400);
	$oStaticMap->setWidth(640);
	$oStaticMap->setHttps(true);
	
	$argument = trim(strtolower($argument));
	
	if (stripos($argument, 'satelital'))
		$oStaticMap->setMapType("satellite");
	
	if (stripos($argument, 'satelite'))
		$oStaticMap->setMapType("satellite");
	
	if (stripos($argument, 'carreteras'))
		$oStaticMap->setMapType("roadmap");
	
	if (stripos($argument, 'hibrido'))
		$oStaticMap->setMapType("hybrid");
	
	if (stripos($argument, 'terreno'))
		$oStaticMap->setMapType("terrain");
	
	if (stripos($argument, 'lejos'))
		$oStaticMap->setZoom(5);
	
	if (stripos($argument, 'cerca'))
		$oStaticMap->setZoom(22);
	
	if (stripos($argument, 'grande')) {
		$oStaticMap->setHeight(640);
		$oStaticMap->setWidth(640);
	}
	
	if (stripos($argument, 'mediano')) {
		$oStaticMap->setHeight(320);
		$oStaticMap->setWidth(320);
	}
	
	if (stripos($argument, 'pequeno')) {
		$oStaticMap->setHeight(120);
		$oStaticMap->setWidth(120);
	}
	
	$argument = str_replace(array(
			"satelital",
			"carreteras",
			"hibrido",
			"terreno",
			" del ",
			" de ",
			"lejos",
			"cerca",
			"grande",
			"mediano",
			"pequeno"
	), '', $argument);
	
	$argument = str_replace('habana','havana', $argument);
	 
	$oStaticMap->setLanguage("es");
	
	$url = "$oStaticMap";
	$robot->log("Getting map $url");
	$img = file_get_contents($url);
	
	return array(
			"answer_type" => "map",
			"command" => "map",
			"title" => "Mapa de $argument",
			"images" => array(
					array(
							"type" => "image/png",
							"content" => $img,
							"name" => "mapa.png",
							"id" => "mapa",
							"src" => "cid:mapa"
					)
			)
	);
}