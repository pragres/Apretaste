<?php

function cmd_terms($robot, $from, $argument, $body = '', $images = array()){
	return array(
			"command" => "terms",
			"answer_type" => "terms",
			"title" => "Condiciones de uso",
			"compactmode" => true
	);
}