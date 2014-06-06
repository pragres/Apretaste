<?php

/**
 * Apretaste!com Subscribe Command
 *
 * @param string $from
 * @param string $phrase
 * @return array
 */
function cmd_subscribe($robot, $from, $argument, $body = '', $images = array()){
	if (trim($argument) == '') {
		$argument = trim($body);
		$argument = str_replace("\n", " ", $argument);
		$argument = str_replace("\r", "", $argument);
		$argument = trim($argument);
	}
	
	$phrase = $argument;
	
	$robot->log("Subscribe: $phrase from $from");
	
	$r = Apretaste::subscribe($from, $phrase);
	
	switch ($r) {
		case APRETASTE_SUBSCRIBE_DUPLICATED :
			return array(
					'command' => 'subscribe',
					'answer_type' => 'subscribe_repeat',
					'phrase' => $phrase,
					"compactmode" => true,
					'title' => 'Ud. ya se encuentra subscrito(a) a la alerta "{$phrase}"'
			);
			break;
	}
	
	return array(
			'command' => 'subscribe',
			'answer_type' => 'subscribe_successfull',
			'phrase' => $phrase,
			"compactmode" => true,
			'title' => 'Subscrito(a) a la alerta "{$phrase}" satisfactoriamente',
			'id' => $r
	);
}
