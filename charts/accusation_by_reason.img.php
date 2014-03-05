<?php

Apretaste::connect();

$servers = ApretasteAnalitics::getAccusationsByReason();

$labels = array();
$points = array();

foreach($servers as $s) {
	$labels[] = $s['reason'];
	$points[] = $s['cant'];
}

$g = new ApretasteDefaultPieChart($points, $labels, "Accusations");

// End of file