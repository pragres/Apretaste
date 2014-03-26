<?php
function cmd_wordreference($robot, $from, $argument, $body = '', $images = array()){
	if (! Apretaste::isUTF8($argument))
		$argument = utf8_encode($argument);
	
	if (substr($argument, 0, 3) == 'ID:')
		$result = file_get_contents("http://buscon.rae.es/drae/srv/search?id=" . url_encode(substr($argument, 3)));
	else
		$result = file_get_contents("http://buscon.rae.es/drae/srv/search?val=" . url_encode($argument));
	
	
	$result = str_replace("search?id=","mailto:".'{$reply_to}'."?subject=SIGNIFICADO ID:", $result);
	
	if (! Apretaste::isUTF8($result))
		$result = utf8_encode($result);
	
	return array(
			"answer_type" => "wordreference",
			"command" => "wordreference",
			"title" => "Significados: $argument",
			"result" => $page,
			"compactmode" => true
	);
}