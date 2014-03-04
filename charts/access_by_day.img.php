<?php

include "../lib/pChart/class/pData.class.php";

Apretaste::connect();

$r = ApretasteAnalitics::getAccessByDay();
if (!$r) exit();

$d = new pData();

$points = array();
$labels = array();

if (is_array($r)) foreach($r as $item) {
	$points[] = $item['cant'];
	$labels[] = $item['dia'];
}

$g = new ApretasteDefaultLineChart("Access by day", $points, $labels, "Access", "Days");

// End of file