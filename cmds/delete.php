<?php

/**
 * Apretaste!com Delete Command
 *
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param array $images
 *
 * @return array
 */

function cmd_delete($robot, $from, $argument, $body = '', $images = array()){
	$ticket = $argument;
	
	$robot->log("Deleting: $ticket from $from");
	
	$r = Apretaste::delete($from, $ticket);
	
	if ($r == APRETASTE_ANNOUNCEMENT_NOTFOUND)
		return array(
				"command" => "delete",
				"compactmode" => true,
				"answer_type" => "delete_announcement_notfound"
		);
	
	return array(
			'command' => 'delete',
			'answer_type' => 'delete_successfull',
			"compactmode" => true,
			'title' => $r['title']
	);
}