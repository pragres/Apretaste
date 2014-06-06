<?php

/**
 * Process unsibscribe order
 *
 * @param string $from
 * @param string $sub
 * @return array
 */
function cmd_unsubscribe($robot, $from, $argument, $body = '', $images = array()){
	if (trim($argument) == '') {
		$argument = trim($body);
		$argument = str_replace("\n", " ", $argument);
		$argument = str_replace("\r", "", $argument);
		$argument = trim($argument);
	}
	
	$sub = $argument;
	$r = Apretaste::unsubscribe($from, $sub);
	if ($r == APRETASTE_SUBSCRIBE_UNKNOWN) {
		return array(
				"command" => "unsubscribe",
				"answer_type" => "unsubscribe_unknown",
				"compactmode" => true,
				"title" => "La alerta no fue encontrada",
				"from" => $from,
				"sub" => $sub
		);
	}
	
	return array(
			"command" => "unsubscribe",
			"answer_type" => "unsubscribe_successfull",
			"compactmode" => true,
			"title" => "La alerta ha sido cancelada",
			"from" => $from,
			"sub" => $r
	);
}