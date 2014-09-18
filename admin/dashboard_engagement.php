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

$r = ApretasteAnalitics::getEngagementAndBounce();

$engagement = array();

for($i = 1; $i <= 12; $i ++) {
	$engagement[$i - 1] = array(
			"y" => $months[$i - 1],
			"a" => 0,
			"b" => 0
	);
}

foreach ( $r as $row ) {
	$prop = "a";
	if ($row['year'] == $current_year)
		$prop = "b";
	$engagement[$row['month'] - 1][$prop] = intval($row['engagement_percent']);
}

$data['engagement'] = $engagement;
$data['current_year'] = $current_year;
$data['current_month'] = $current_month;

