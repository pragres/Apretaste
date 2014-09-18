<?php 

$current_year = intval(date("Y"));
$current_month = intval(date("m"));

$months = array(
		"Jan",
		"Feb",
		"Mar",
		"Apr",
		"May",
		"Jun",
		"Jul",
		"Aug",
		"Sep",
		"Oct",
		"Nov",
		"Dec"
);

$data['month'] = $months;

// Best users
$data['best_users'] = array();

$r = ApretasteAnalitics::getBestUsers();

$data['best_users'] = $r;
