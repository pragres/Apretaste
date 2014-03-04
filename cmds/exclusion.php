<?php

function cmd_exclusion($robot, $from, $argument, $body = '', $images = array()){

	Apretaste::exclusion($from);

	$data = array("command" => "exclusion", "answer_type" => "exclusion", "title" => "Atendiendo a su solicitud, Ud. ha sido excluido de los servicios de Apretaste!");
	$data['compactmode'] = true;
	return $data;
}