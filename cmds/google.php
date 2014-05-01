<?php
/**
 * Apretaste!
 * 
 * Google command
 * 
 * @param unknown $robot
 * @param unknown $from
 * @param unknown $argument
 * @param string $body
 * @param unknown $images
 * @return multitype:string boolean unknown |multitype:string boolean
 */
function cmd_google($robot, $from, $argument, $body = '', $images = array()){
	
	$robot->log("Search with Google");
	
	$results = Apretaste::google($argument);
	
	$robot->log(count($results) . " results");
	
	if (isset($results[0])) {
		
		$robot->log("Getting the first result from {$results[0]->url}");
		
		$remedio = file_get_contents($results[0]->url);
		
		$robot->log("Fix encoding...");
		
		$remedio = ApretasteEncoding::fixUTF8($remedio);
		
		$robot->log("Extract the content");
		
		$doc = new DOMDocument();
		
		@$doc->loadHTML($remedio);
		
		$remedio = $doc->saveHTML();
		
		$robot->log("Cleanning the content");
		
		$titulo = strip_tags($results[0]->title);
		
		$remedio = strip_tags($remedio, '<b><strong><tr><table><td><li><ul><ol><p><a><div><br><hr><style><script>');
		
		$remedio = Apretaste::repairUTF8($remedio);
		
		unset($results[0]);
		
		$robot->log("Finish google search");
		
		return array(
				"answer_type" => "google",
				"command" => "google",
				"title" => $titulo,
				"body" => $remedio,
				"others" => $results,
				"compactmode" => true,
				"query" => $argument
		);
	}
	
	$robot->log("No page found");
	
	return array(
			"answer_type" => "google_not_found",
			"command" => "google",
			"title" => 'No se encontraron resultados en la web para ' . $argument,
			"compactmode" => true
	);
}