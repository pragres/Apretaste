<?php
/**
 * Apretaste!com Help Command
 *
 * @param string $from
 * @return array
 */
function cmd_help($robot, $from, $argument, $body = '', $images = array()){
	
	$robot->log("Help to $from");
	
	$data = array(
			"command" => "help",
			"answer_type" => "help",
			"title" => "Ayuda de Apretaste!",
			"from" => $from
	);
	
	$data['images'] = array();
	$data['compactmode'] = true;
	return $data;
}