<?php

u("pChart/class/pData.class");

Apretaste::connect();

$r = ApretasteAnalitics::getAdsByDay();
if (!$r) exit();	

$d = new pData();

$points = array(); 
$labels = array();

if (is_array($r)) foreach($r as $item) {
	$points[] = $item['cant'];
	$labels[] = $item['dia'];
}

$graph = new ApretasteDefaultLineChart("Ads by day", $points, $labels, "Ads", "Days");
