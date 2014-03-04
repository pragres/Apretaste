<?php

function cmd_addresses($robot, $from, $argument, $body = '', $images = array()){
	return array(
			"command" => "addresses",
			"answer_type" => "addresses",
			"title" => "Lista de buzones de Apretaste!",
			"compactmode" => true
	);
}