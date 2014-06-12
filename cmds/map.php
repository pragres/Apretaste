<?php

/**
 * Apretaste Map Command
 *
 * @param ApretasteRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param array $images
 * @return array
 */
function cmd_map($robot, $from, $argument, $body = '', $images = array()){
	if (trim($argument) == '') {
		$argument = trim($body);
		$argument = str_replace("\n", " ", $argument);
		$argument = str_replace("\r", "", $argument);
		$argument = trim($argument);
	}
	
	$oStaticMap = new GoogleStaticMap();
	$oStaticMap->setCenter("$argument");
	$oStaticMap->setHeight(400);
	$oStaticMap->setWidth(640);
	$oStaticMap->setHttps(true);
	$oStaticMap->setMapType("hybrid");
	
	$argument = trim(strtolower($argument));
	
	$zoom = null;
	// Detecting zoom
	for($i = 22; $i >= 1; $i --) {
		if (stripos($argument, $i . 'x') !== false) {
			$zoom = $i;
			$argument = str_ireplace($i . 'x', '', $argument);
		}
	}
	
	if (! is_null($zoom))
		$oStaticMap->setZoom($zoom);
	
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
	
	$oStaticMap->setHeight(640);
	$oStaticMap->setWidth(640);
	
	$argument = str_replace(array(
			"satelital",
			"carreteras",
			"hibrido",
			"terreno",
			" del ",
			" de "
	), '', $argument);
	
	$argument = str_replace('habana', 'havana', $argument);
	
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