<?php
function cmd_remedy($robot, $from, $argument, $body = '', $images = array()){
	$results = Apretaste::google("$argument site:remediospopulares.com");
	
	if (isset($results[0])) {
		$remedio = file_get_contents($results[0]->url);
		
		$doc = new DOMDocument();
		
		@$doc->loadHTML($remedio);
		
		$r = $doc->getElementById("layer5");
		
		$remedio = $doc->saveHTML($r);
		
		$titulo = $results[0]->title;
		unset($results[0]);
		return array(
				"answer_type" => "remedy",
				"command" => "remedy",
				"title" => $titulo,
				"body" => $remedio,
				"others" => $results,
				"compactmode" => true
		);
	}
	
	return array(
			"answer_type" => "remedy_not_found",
			"command" => "remedy",
			"title" => 'No se encontraron remedios para ' . $argument,
			"compactmode" => true
	);
}
