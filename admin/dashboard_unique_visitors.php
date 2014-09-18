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

$r = q("SELECT * FROM visitors_by_month WHERE year >= extract(year from current_date)-1;");

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
	if ($row['year'] == $current_year)
		$prop = "current";
	$visitors[$row['month'] - 1][$prop] = intval($row['authors']);
}

$data['unique_visitors'] = $visitors;
$data['current_year'] = $current_year;
$data['current_month'] = $current_month;

