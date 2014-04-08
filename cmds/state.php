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
			"help" => "AYUDA: Ayuda de Apretaste!",
			"search" => "BUSCAR: Busar anuncios",
			"insert" => "PUBLICAR: Publicar un anuncio",
			"joke" => "CHISTE: Leer un chiste",
			"sudoku" => "SUDOKU: Resolver un Sudoku",
			"article" => "ARTICULO: Consultar la Wikipedia",
			// "weather" => "CLIMA: Ver el estado del tiempo",
			// "translate" => "TRADUCIR: Traducir textos",
			"invite" => "INVITAR: Invitar a un amigo",
			"subscribe" => "ALERTA: Recibir alertas de anuncios por correo"
	);
	
	if (is_array($stats['messages_by_command']))
		foreach ( $stats['messages_by_command'] as $msg ) {
			if (isset($services[$msg['command']]))
				unset($services[$msg['command']]);
		}
	
	return array(
			"command" => "state",
			"compactmode" => true,
			"answer_type" => "state",
			"title" => "Su estado en Apretaste!com",
			"announcements" => $r,
			"subscribes" => $s,
			"stats" => $stats,
			"services" => $services
	);
}