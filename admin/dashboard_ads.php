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

// subscribes
$r = Apretaste::query("select count(*) as cant from subscribe;");

$data['subscribes_count'] = $r[0]['cant'];

// messages metrics
$data['total_internal'] = ApretasteAnalitics::getTotalInternalActiveAds();
$data['total_external'] = ApretasteAnalitics::getTotalExternalActiveAds();
$data['total_messages'] = ApretasteAnalitics::getTotalOfMessages();
$data['historial_internal'] = ApretasteAnalitics::getHistoricalInternalAds();
$data['historial_external'] = ApretasteAnalitics::getHistoricalExternalAds();
$data['total_visits'] = ApretasteAnalitics::getTotalOfVisits();

$r = Apretaste::query("SELECT extract(year from send_date) as ano, extract(month from send_date::date) as mes, count(*) as total FROM linker WHERE extract(year from send_date::date) >= extract(year from current_date)-1 group by ano, mes;");

$data['linker'] = array();
for($i = 0; $i < 12; $i ++)
	$data['linker'][$i] = array(
			"y" => $months[$i],
			"a" => 0,
			"b" => 0
	);

if (is_array($r))
	foreach ( $r as $v ) {
		$prop = 'a';
		if ($v['ano'] * 1 == $current_year)
			$prop = 'b';
		$data['linker'][$v['mes'] - 1][$prop] = $v['total'];
	}
	
	// Nanotitles
$r = Apretaste::query("SELECT w1 || ' ' || w2 || ' ' ||  w3 || ' ' || w4  as nanotitle, popularity
				from nanotitles
				where levels > 2
				order by popularity desc limit 20");

$data['nanotitles'] = $r;

// Popular phrases
$data['popular_phrases'] = ApretasteAnalitics::getPopularPhrases(20, null, null, true);

$r = ApretasteAnalitics::getPopularPhrases(5, null, null, true);

$data['popular_phrases_pie'] = array();

foreach ( $r as $s ) {
	$data['popular_phrases_pie'][] = array(
			'label' => $s['s'],
			'data' => $s['n'] * 1
	);
}

$data['current_year'] = $current_year;
$data['current_month'] = $current_month;
