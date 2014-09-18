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

$r = ApretasteAnalitics::getAccesByMonth();

$visitors = array();

for($i = 1; $i <= 12; $i ++) {
	$visitors[$i - 1] = array(
			"period" => $current_year.'-'.$i,
			"last" => 0,
			"current" => 0
	);
}

foreach ( $r as $row ) {
	$prop = "last";
	if ($row['ano'] == $current_year)
		$prop = "current";
	$visitors[$row['mes'] - 1][$prop] = intval($row['total']);
}

$data['visitors'] = $visitors;
$data['current_year'] = $current_year;
$data['current_month'] = $current_month;

