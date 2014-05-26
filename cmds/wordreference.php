<?php
function cmd_wordreference($robot, $from, $argument, $body = '', $images = array()){
	if (! Apretaste::isUTF8($argument))
		$argument = utf8_encode($argument);
	
	if (substr($argument, 0, 3) == 'ID:') {
		$robot->log("Getting word reference $argument in Real Academia Espanola");
		$url = "http://buscon.rae.es/drae/srv/search?id=" . urlencode($argument);
		$robot->log("Downloading $url");
		$result = file_get_contents($url);
	} else {
		$robot->log("Searching for $argument in Real Academia Espanola");
		$url = "http://buscon.rae.es/drae/srv/search?val=" . urlencode($argument);
		$robot->log("Downloading $url");
		$result = file_get_contents($url);
	}
	
	$robot->log("Cleanning the result");
	
	if (! Apretaste::isUTF8($result))
		$result = utf8_encode($result);
	
	$result = str_replace("search?id=", "mailto:" . '{$reply_to}' . "?subject=SIGNIFICADO ID:", $result);
	
	return array(
			"answer_type" => "wordreference",
			"command" => "wordreference",
			"title" => "Significados: $argument",
			"result" => $result,
			"compactmode" => true
	);
}