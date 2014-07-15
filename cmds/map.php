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
	
	$type = 'hibrido';
	
	if (stripos($argument, 'fisico') !== false) {
		$oStaticMap->setMapType("satellite");
		$argument = str_replace_count('fisico', '', $argument, 1);
		$type = 'fisico';
	} elseif (stripos($argument, 'politico') !== false) {
		$argument = str_replace_count('politico', '', $argument, 1);
		$oStaticMap->setMapType("roadmap");
		$type = 'politico';
	} elseif (stripos($argument, 'terreno') !== false) {
		$argument = str_replace_count('terreno', '', $argument, 1);
		$oStaticMap->setMapType("terrain");
		$type = 'terreno';
	}
	
	if (stripos($argument, 'hibrido') !== false) 
		$argument = str_replace_count('hibrido', '', $argument, 1);
	
	$oStaticMap->setScale(1);
	$oStaticMap->setHeight(640);
	$oStaticMap->setWidth(640);
	
	// $argument = str_replace('habana', 'havana', $argument);
	
	$oStaticMap->setLanguage("es");
	
	$argument = trim($argument);
	if (substr($argument, 0, 3) == 'de ')
		$argument = substr($argument, 3);
	if (substr($argument, 0, 4) == 'del ')
		$argument = substr($argument, 4);
	
	$oStaticMap->setCenter("$argument");
	
	$url = "$oStaticMap";
	
	$robot->log("Getting map $url");
	
	$img = file_get_contents($url);
	
	return array(
			"answer_type" => "map",
			"command" => "map",
			"title" => "Mapa de $argument [$type] - " . date("Y-m-d"),
			"argument" => "$type $argument",
			"zoom" => $zoom,
			"sharethis" => "MAPA $argument",
			"images" => array(
					array(
							"type" => "image/png",
							"content" => $img,
							"name" => "Mapa de $argument [$type] - " . date("Y-m-d") . "png",
							"id" => "mapa",
							"src" => "cid:mapa"
					)
			)
	);
}