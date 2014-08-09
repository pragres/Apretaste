<?php

/**
 * Process invitation order
 *
 * @param string $from
 * @param string $guest
 * @return array
 */
function cmd_invite($robot, $from, $argument, $body = '', $images = array()){
	
	// Messages
	$msgs = array(
			APRETASTE_INVITATION_REPEATED => "ya ha sido invitado anteriormente por Ud.",
			APRETASTE_INVITATION_STUPID => "es Ud., y Ud. no puede invitarse a si mismo.",
			APRETASTE_INVITATION_UNNECESASARY => "ya utiliza Apretaste!",
			APRETASTE_INVITATION_SUCCESSFULL => "se la ha enviado la invitaci&oacute;n"
	);
	
	// $argument = $argument . ' ' . $body;
	
	$argument = str_replace("\n", " ", $argument);
	$argument = str_replace("\r", "", $argument);
	$argument = trim($argument);
	
	Apretaste::addToAddressList($argument, 'apretaste.invitation');
	
	// Filter argument
	$address = Apretaste::getAddressFrom($argument);
	
	$r = false;
	$results = array();
	$friends = array();
	$simulator = Apretaste::isSimulator();
	
	if (! isset($address[0]))
		return array(
				"command" => "invite",
				"answer_type" => "invite_guest_missing",
				"title" => "Escriba la direcci&oacute;n de correo de su amigo",
				"compactmode" => true,
				"guest" => "missing",
				"from" => $from
		);
		
		// Invite
	
	foreach ( $address as $guest ) {
		if (! isset($results[$guest])) {
			$robot->log("Invite $guest");
			$results[$guest] = Apretaste::invite($from, $guest, false);
			
			if (! $simulator)
				if (Apretaste::isUser($guest))
					$friends[$guest] = ApretasteSocial::makeFriends($from, $guest);
		}
	}
	
	$answers = array();
	
	$xresults = $results;
	
	foreach ( $xresults as $k => $v ) {
		if (is_array($v)) {
			$answers[] = $v;
			$v = APRETASTE_INVITATION_SUCCESSFULL;
		}
		
		$results[$k] = $msgs[$v];
	}
	
	$answers[] = array(
			"command" => "invite",
			"answer_type" => "invite_successfull",
			"title" => "Resultado de invitar a sus contactos",
			"compactmode" => true,
			"guest" => false,
			"addresses" => $results,
			"from" => $from,
			"_to" => $from
	);
	
	return array(
			'_answers' => $answers
	);
}
