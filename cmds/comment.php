<?php

/**
 * Apretaste!com Comment Command
 *
 * @param string $from
 * @param string $id
 * @param string $body
 * @return array
 */
function cmd_comment($robot, $from, $argument, $body = '', $images = array()){
	
	$id = $argument;
	
	$robot->log("Comment ad: $id from $from");
	
	$body = strip_tags($body);
	$body = trim($body);
	$body = Apretaste::replaceRecursive("  ", " ", $body);
	$body = htmlentities($body, null, 'UTF-8', false);
	$body = substr($body, 0, 200);
	$body = trim($body);
	if ($body !== '') {
		
		$r = Apretaste::comment($from, $id, $body);
		
		if ($r == APRETASTE_ANNOUNCEMENT_NOTFOUND) {
			return array(
					'command' => 'comment',
					"compactmode" => true,
					'answer_type' => 'comment_announcement_notfound'
			);
		}
		
		$r = Apretaste::getAnnouncement($id);
		
		return array(
				'command' => 'comment',
				"compactmode" => true,
				"ad" => $r,
				'answer_type' => 'comment_successfull'
		);
	}
	
	return array(
			'command' => 'comment',
			"compactmode" => true,
			"ad" => $r,
			'answer_type' => 'comment_empty'
	);
}