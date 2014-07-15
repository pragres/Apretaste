<?php

function cmd_lock($robot, $from, $argument, $body = '', $images = array()){
	$from = strtolower($from);
	
	$argument = trim(strtolower($argument));
	
	if (Apretaste::checkAddress($argument) || $argument == 'newuser@localhost') {
		$r = Apretaste::query("SELECT count(*) as total FROM friends_lock WHERE author = '$from' and locked = '$argument';");
		
		if ($r[0]['total'] * 1 == 0) {
			Apretaste::query("INSERT INTO friends_lock (author, locked) VALUES ('$from','$argument'); ");
		}
		
		return array(
				"answer_type" => "lock",
				"command" => "lock",
				"locked" => $argument,
				"title" => "Usuario $argument bloqueado satisfactoriamente"
		);
	}
	
	return array(
			"answer_type" => "lock",
			"command" => "lock",
			"locked" => false,
			"title" => "No escribi&oacute; la direcci&oacute;n del usuario a bloquear"
	);
}