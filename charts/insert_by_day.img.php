<?php

Apretaste::connect();

$r = ApretasteAnalitics::getInsertsByDay();
if (!$r) exit();	

$points = array(); 
$labels = array();

if (is_array($r)) foreach($r as $item) {
	$points[] = $item['cant'];
	$labels[] = $item['dia'];
}

$g = new ApretasteDefaultLineChart("Inserts by day", $points, $labels, "Inserts", "Days");

// End of file