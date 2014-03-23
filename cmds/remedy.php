<?php
/**
 * Apretaste!
 * 
 * Remedy command
 * 
 * @param unknown $robot
 * @param unknown $from
 * @param unknown $argument
 * @param string $body
 * @param unknown $images
 * @return multitype:string boolean unknown |multitype:string boolean
 */
function cmd_remedy($robot, $from, $argument, $body = '', $images = array()){
	
	$robot->log("Search in http://remediospopulares.com with Google");
	
	$results = Apretaste::google("$argument site:remediospopulares.com");
	
	$robot->log(count($results) . " results");
	
	if (isset($results[0])) {
		
		$robot->log("Getting the first result from {$results[0]->url}");
		
		$remedio = file_get_contents($results[0]->url);
		
		$robot->log("Fix encoding...");
		
		$remedio = ApretasteEncoding::fixUTF8($remedio);
		
		$robot->log("Extract the content");
		
		$doc = new DOMDocument();
		
		@$doc->loadHTML($remedio);
		
		$r = $doc->getElementById("layer5");
		
		$remedio = $doc->saveHTML($r);
		
		$robot->log("Cleanning the content");
		
		$titulo = strip_tags($results[0]->title);
		
		$remedio = strip_tags($remedio, '<b><strong><tr><table><td><li><ul><ol><p>');
		
		unset($results[0]);
		
		$robot->log("Finish remedy");
		
		return array(
				"answer_type" => "remedy",
				"command" => "remedy",
				"title" => $titulo,
				"body" => $remedio,
				"others" => $results,
				"compactmode" => true
		);
	}
	
	$robot->log("No remedy found");
	
	return array(
			"answer_type" => "remedy_not_found",
			"command" => "remedy",
			"title" => 'No se encontraron remedios para ' . $argument,
			"compactmode" => true
	);
}
