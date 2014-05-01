<?php
/**
 * Apretaste!com Help Command
 *
 * @param string $from
 * @return array
 */
function cmd_services($robot, $from, $argument, $body = '', $images = array()){
	
	$robot->log("Services to $from");
	
	$data = array(
			"command" => "services",
			"answer_type" => "services",
			"title" => "Servicios de Apretaste!",
			"from" => $from
	);
	
	$data['images'] = array();
	$data['compactmode'] = true;
	return $data;
}