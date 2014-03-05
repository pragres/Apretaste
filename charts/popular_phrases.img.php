<?php
Apretaste::connect();

$r = ApretasteAnalitics::getPopularPhrases(5, null, null, true);

if (! $r)
	exit();

$labels = array();
$points = array();

foreach ( $r as $s ) {
	$labels[] = $s['s'] . "({$s['n']})";
	$points[] = $s['n'];
}

$g = new ApretasteDefaultPieChart($points, $labels, "Popular phrases");

// End of file