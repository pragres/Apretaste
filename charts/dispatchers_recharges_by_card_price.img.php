<?php

Apretaste::connect();

$r = q("select '3$' as s, sum(\"3\") as n from dispatchers_recharges_cross
	union select '5$' as s, sum(\"5\") as n from dispatchers_recharges_cross
	union select '10$' as s, sum(\"10\") as n from dispatchers_recharges_cross;");

if (! $r)
	exit();

$labels = array();
$points = array();

foreach ( $r as $s ) {
	$labels[] = $s['s'] . "({$s['n']})";
	$points[] = $s['n'];
}

$g = new ApretasteDefaultPieChart($points, $labels, "Recharges by card price");

// End of file