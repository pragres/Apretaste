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
	$robot->log("Comment: $id from $from");
	
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
			'answer_type' => 'comment_successfull',
			'title' => $r['title']
	);
}