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

$newusers = array();

for($i = 1; $i <= 12; $i ++) {
	$newusers[$i - 1] = array(
			"y" => $months[$i - 1],
			"a" => ApretasteAnalitics::getCountOfNewUsers($current_year - 1, $i),
			"b" => ApretasteAnalitics::getCountOfNewUsers($current_year, $i)
	);
}

$data['new_users'] = $newusers;
$data['current_year'] = $current_year;
$data['current_month'] = $current_month;
// Total users
$r = Apretaste::query("SELECT count(*) as total from messages_authors;");

$data['total_users'] = $r[0]['total'];
