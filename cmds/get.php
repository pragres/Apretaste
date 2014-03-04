<?php
/**
 * Apretaste!com Get command
 *
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param array $images
 * 
 * @return array
 */
function cmd_get($robot, $from, $argument, $body = '', $images = array()) {

	$id = $argument;

	$robot->log("Getting ad: $id");

	$r = Apretaste::getAnnouncement($id);

	if ($r == APRETASTE_ANNOUNCEMENT_NOTFOUND)
		return array(
				"command" => "get",
				"compactmode" => true,
				"answer_type" => "announcement_not_found",
				"id" => $id
		);

	Apretaste::addVisit($id, $from);

	$r['answer_type'] = 'show_announcement';
	$r['image_src'] = 'cid:announcement.image';
	$r['command'] = 'get';
	$r['from'] = $from;
	if (isset($r['image']))
	if ("{$r['image']}" != '') {
		if ("image/{$r['image_type']}" == 'image/')
			$r['image_type'] = 'jpeg';
		$r['images'][] = array(
				"type" => "image/{$r['image_type']}",
				"content" => base64_decode($r['image']),
				"name" => $r['image_name'],
				"id" => 'announcement.image'
						);
	}

	return $r;
}