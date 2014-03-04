<?php

Apretaste::connect();

$r = ApretasteAnalitics::getHelpsByDay();

if (!$r) exit();	

$points = array(); 
$labels = array();

if (is_array($r)) foreach($r as $item) {
	$points[] = $item['cant'];
	$labels[] = $item['dia'];
}

$g = new ApretasteDefaultLineChart("Helps by day",$points,$labels,"Helps","Days");

// End of file