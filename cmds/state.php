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
			"search" => "<b>BUSCAR</b>: Busar anuncios",
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
	
	return array(
			"command" => "state",
			"compactmode" => true,
			"answer_type" => "state",
			"title" => "Su estado en Apretaste!",
			"announcements" => $r,
			"subscribes" => $s,
			"stats" => $stats,
			"services" => $services,
			"credit" => $credit,
			"sms" => $sms
	);
}