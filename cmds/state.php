<?php

/**
 * Process state order
 *
 * @param string $from
 * @return array
 */
function cmd_state($robot, $from, $argument, $body = '', $images = array()){
	$r = Apretaste::getAnnouncementsOf($from);
	$s = Apretaste::getSubscribesOf($from);
	$stats = Apretaste::getUserStats($from);
	
	$services = array(
			"search" => "<b>BUSCAR</b>: Buscar anuncios",
			"insert" => "<b>PUBLICAR</b>: Publicar un anuncio",
			"joke" => "<b>CHISTE</b>: Leer un chiste",
			"sudoku" => "<b>SUDOKU</b>: Resolver un Sudoku",
			"article" => "<b>ARTICULO</b>: Consultar la Wikipedia",
			// "weather" => "<b>CLIMA</b>: Ver el estado del tiempo",
			// "translate" => "<b>TRADUCIR</b>: Traducir textos",
			"invite" => "<b>INVITAR</b>: Invitar a un amigo",
			"subscribe" => "<b>ALERTA</b>: Recibir alertas de anuncios por correo",
			"translate" => "<b>TRADUCIR</b>: Traducir textos"
	);
	
	if (is_array($stats['messages_by_command']))
		foreach ( $stats['messages_by_command'] as $msg ) {
			if (isset($services[$msg['command']]))
				unset($services[$msg['command']]);
		}
	
	Apretaste::query("UPDATE address_list SET send_status = CURRENT_DATE where email = '$from';");
	
	$credit = ApretasteMoney::getCreditOf($from);
	
	$sms = ApretasteSMS::getLastSMSOf($from);
	
	$from = strtolower($from);
	$rf = Apretaste::query("SELECT * FROM xraffles where active = true and closed = false limit 1;");
	$rf = $rf[0];
	$tks = Apretaste::query("SELECT count_user_raffle_tickets('{$rf['id']}','$from') as total;");
	
	$profile = Apretaste::getAuthor($from);
	
	$data = array(
			"email" => $from,
			"from" => $from,
			"command" => "state",
			"compactmode" => true,
			"answer_type" => "state",
			"title" => "Su estado en Apretaste!",
			"announcements" => $r,
			"subscribes" => $s,
			"stats" => $stats,
			"services" => $services,
			"credit" => $credit,
			"sms" => $sms,
			"tickets" => $tks[0]['total'],
			"profile" => $profile
	);
	
	if (isset($profile['picture']))
		if ($profile['picture'] !== '') {
			$img = base64_decode($profile['picture']);
			// $img = Apretaste::convertImageToJpg($img);
			$img = base64_decode(Apretaste::resizeImage(base64_encode($img), 80));
			
			$data['images'] = array(
					
					array(
							"type" => "image/jpeg",
							"content" => $img,
							"name" => "$from.jpg",
							"id" => "profile_picture",
							"src" => "cid:profile_picture"
					)
			);
		}
	
	return $data;
}
