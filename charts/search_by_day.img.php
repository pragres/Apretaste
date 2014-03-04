<?php

u("pChart/class/pData.class");

Apretaste::connect();

$r = ApretasteAnalitics::getSearchByDay();
if (!$r) exit();

$d = new pData();

$points = array(); 
$labels = array();

if (is_array($r)) foreach($r as $item) {
	$points[] = $item['cant'];
	$labels[] = $item['dia'];
}

$g = new ApretasteDefaultLineChart("Searchs by day", $points, $labels, "Searchs", "Days");

// End of file