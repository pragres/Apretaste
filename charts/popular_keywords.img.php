<?php

Apretaste::connect();

$r = ApretasteAnalitics::getPopularKeywords();
if(!$r) exit();

$labels = array();
$points = array();

foreach($r as $s) {
	$labels[] = $s['s'];
	$points[] = $s['n'];
}

$g = new ApretasteDefaultPieChart($points, $labels, "Popular keywords");

// End of file