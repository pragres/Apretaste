<?php
Apretaste::connect();

$r = ApretasteAnalitics::getMessagesByCommand(null, -2, 7);

$year = intval(date('Y'));
$month = intval(date('m'));

if ($r) {
	
	$labels = array();
	$points = array();
	
	foreach ( $r as $s ) {
		$labels[] = $s['command'] . " ({$s['cant']})";
		$points[] = $s['cant'];
	}
	
	$g = new ApretasteDefaultPieChart($points, $labels, "Messages by command");
}
// End of file