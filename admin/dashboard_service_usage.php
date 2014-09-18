<?php
$r = ApretasteAnalitics::getMessagesByCommand(null, false);

$msg_by_command = array();
foreach ( $r as $x ) {
	if (! isset($msg_by_command[$x['command']])) {
		$msg_by_command[$x['command']] = array();
		for($i = 1; $i <= 12; $i ++)
			$msg_by_command[$x['command']][$i] = 0;
	}
	$msg_by_command[$x['command']][$x['mes']] = $x['cant'];
}

$data['msg_by_command'] = $msg_by_command;

$r = ApretasteAnalitics::getMessagesByCommand(null, - 2, 7);

$year = intval(date('Y'));
$month = intval(date('m'));

if ($r) {
	$data['pie_data'] = array();
	
	foreach ( $r as $s ) {
		$data['pie_data'][] = array(
				'label' => $s['command'] . " ({$s['cant']})",
				'data' => $s['cant'] * 1
		);
	}
}