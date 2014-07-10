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
	
	if (! isset($address[0]))
		$results = array(
				APRETASTE_INVITATION_GUEST_MISSING
		);
	else {
		
		// Invite
		
		foreach ( $address as $guest ) {
			if (! isset($results[$guest])) {
				$robot->log("Invite $guest");
				$results[$guest] = Apretaste::invite($from, $guest, $body);
			}
		}
	}
	
	if (! isset($address[1]) && isset($results[0])) {
		
		switch ($results[0]) {
			
			case APRETASTE_INVITATION_REPEATED :
				return array(
						"command" => "invite",
						"answer_type" => "invite_repeated",
						"title" => "Ud. ya ha invitado a su contacto {$guest} anteriormente",
						"compactmode" => true,
						"guest" => $guest,
						"from" => $from
				);
				break;
			
			case APRETASTE_INVITATION_STUPID :
				return array(
						"command" => "invite",
						"answer_type" => "invite_stupid",
						"title" => "Ud. se ha invitado a Ud. mismo?",
						"compactmode" => true,
						"guest" => $guest,
						"from" => $from
				);
			
			case APRETASTE_INVITATION_UNNECESASARY :
				return array(
						"command" => "invite",
						"answer_type" => "invite_unnecesary",
						"title" => "Su amigo {$guest} ya utiliza Apretaste!",
						"compactmode" => true,
						"guest" => $guest,
						"from" => $from
				);
				break;
			
			case APRETASTE_INVITATION_GUEST_MISSING :
				return array(
						"command" => "invite",
						"answer_type" => "invite_guest_missing",
						"title" => "Escriba la direcci&oacute;n de correo de su amigo",
						"compactmode" => true,
						"guest" => "missing",
						"from" => $from
				);
				break;
			case APRETASTE_INVITATION_SUCCESSFULL :
				return array(
						"command" => "invite",
						"answer_type" => "invite_successfull",
						"title" => "Se le ha enviado la invitacion a su contacto {$address[0]}",
						"compactmode" => true,
						"guest" => $address[0],
						"addresses" => false,
						"from" => $from
				);
				break;
		}
	} else {
		
		$xresults = $results;
		foreach ( $xresults as $k => $v )
			$results[$k] = $msgs[$v];
		
		return array(
				"command" => "invite",
				"answer_type" => "invite_successfull",
				"title" => "Resultado de invitar a sus contactos",
				"compactmode" => true,
				"guest" => false,
				"addresses" => $results,
				"from" => $from
		);
	}
}
