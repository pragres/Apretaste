<?php
function cmd_remedy($robot, $from, $argument, $body = '', $images = array()){
	$results = Apretaste::google("$argument site:remediospopulares.com");
	
	if (isset($results[0])) {
		$remedio = file_get_contents($results[0]->url);
		unset($results[0]);
		return array(
				"answer_type" => "remedy",
				"command" => "remedy",
				"title" => $results[0]->title,
				"body" => $body,
				"others" => $results,
				"compactmode" => true
		);
	}
}
