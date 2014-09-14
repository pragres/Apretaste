<?php

Apretaste::connect();

$email = get('email');

$email = trim(strtolower(Apretaste::extractEmailAddress($email)));

$r = q("SELECT command, count(*) as cant FROM message where extract_email(author) ='$email' group by command;");


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