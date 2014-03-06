<?php

/**
 * Process state order
 *
 * @param string $from
 * @return array
 */
function cmd_state($robot, $from, $argument, $body = '', $images = array()){
	
	$r = Apretaste::getAnnouncementsOf($from);	
	$s = Apretaste::getSubscribesOf($from);

	return array(
			"command" => "state",
			"answer_type" => "state",
			"title" => "Su estado en Apretaste!com",
			"announcements" => $r,
			"subscribes" => $s
	);
}