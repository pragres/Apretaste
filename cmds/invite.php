<?php

/**
 * Process invitation order
 *
 * @param string $from
 * @param string $guest
 * @return array
 */
function cmd_invite($robot, $from, $argument, $body = '', $images = array()){
	
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
			$robot->log("Invite $guest");
			$results[] = Apretaste::invite($from, $guest);
		}
	}
	
	if (! isset($address[1])) {
		
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
		}
		
	} else {
		return array(
				"command" => "invite",
				"answer_type" => "invite_successfull",
				"title" => isset($address[1]) ? "Sus contactos han sido invitados" : "Su contacto {$address[0]} han sido invitado satisfactoriamente",
				"compactmode" => true,
				"guest" => false,
				"addresses" => $address, 
				"from" => $from
		);
	}
}
