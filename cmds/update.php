<?php

/**
 * Apretaste!com Insert Command
 *
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param array $images
 *
 * @return array
 */
function cmd_update($robot, $from, $argument, $body = '', $images = array()){
	$title = $argument;
	
	$fail_response = array(
			"command" => "insert",
			"answer_type" => "insert_fail",
			"compactmode" => true,
			'title' => $title
	);
	
	$p = strpos($title, " ");
	if ($p === false)
		return $fail_response;
	$ticket = substr($title, 0, $p);
	$title = substr($title, $p + 1);
	
	if (strlen(trim($title)) < 7) {
		if (strlen(trim($body)) > 7) {
			$title = div::teaser($body, 100);
		} else
			return array(
					"command" => "insert",
					"answer_type" => "insert_short",
					"compactmode" => true
			);
	}
	
	$title = trim($title);
	
	$robot->log("Updating: $title from $from as $body");
	
	$text = $title . ' ' . $body;
	$price = "0";
	$currency = "$";
	$prices = Apretaste::getPricesFrom($text);
	
	// The price is the first price found?
	if (isset($prices[0])) {
		$price = $prices[0]['value'];
		$currency = $prices[0]['currency'];
	}
	
	$phones = Apretaste::getPhonesFrom($text);
	
	if (! Apretaste::isSimulator())
		$r = Apretaste::insert($from, $title, $body, $images, $price, $phones, null, null, null, $currency, true, $ticket);
	
	switch ($r) {
		case APRETASTE_INSERT_FAIL :
			return $fail_response;
			break;
	}
	
	return array(
			'command' => 'update',
			'answer_type' => 'update_successfull',
			'title' => $title,
			'ticket' => $r['ticket'],
			"compactmode" => true,
			'id' => $r['id'],
			'post_date' => $r['post_date'],
			'search_results' => $r['search_results'],
			'oferta' => $r['oferta'],
			'contact_info' => $r['contact_info'],
			'showminimal' => true
	);
}