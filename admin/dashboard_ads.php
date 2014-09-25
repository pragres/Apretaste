<?php

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

$r = Apretaste::query("SELECT extract(month from send_date::date) as mes, count(*) as total FROM linker WHERE extract(year from send_date::date) = extract(year from current_date) group by mes;");

$data['linker'] = array();
for($i = 0; $i < 12; $i ++)
	$data['linker'][] = array(
			'mes' => $i + 1,
			'total' => 0
	);

if (is_array($r))
foreach ( $r as $v )
	$data['linker'][$v['mes'] - 1] = array(
			'mes' => $v['mes'],
			'total' => $v['total']
	);

// Nanotitles
$r = Apretaste::query("SELECT w1 || ' ' || w2 || ' ' ||  w3 || ' ' || w4  as nanotitle, popularity
				from nanotitles
				where levels > 2
				order by popularity desc limit 20");

$data['nanotitles'] = $r;

// Popular phrases
$data['popular_phrases'] = ApretasteAnalitics::getPopularPhrases(20, null, null, true);
