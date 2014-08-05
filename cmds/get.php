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
function cmd_get($robot, $from, $argument, $body = '', $images = array()){
	if (trim($argument) == '') {
		$argument = trim($body);
		$argument = str_replace("\n", " ", $argument);
		$argument = str_replace("\r", "", $argument);
		$argument = trim($argument);
	}
	
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
	
	if (! Apretaste::isSimulator())
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
	
	$r['sharethis'] = 'ANUNCIO ' . $argument;
	
	return $r;
}