<?php

$lastdays = 15;
$data['lastdays'] = $lastdays;

// National

$access_by_hour = array();

for($i = 0; $i <= 23; $i ++) {
	$access_by_hour[$i] = array();
	for($j = 1; $j <= $lastdays; $j ++)
		$access_by_hour[$i][$j] = 0;
}

$r = ApretasteAnalitics::getSMSByHour($lastdays);

if (is_array($r))
	foreach ( $r as $rx ) {
		$access_by_hour[$rx['hora']][$rx['orden']] = intval($rx['total']);
	}

$sql = "
SELECT
q::date - current_date + " . ($lastdays - 1) . " + 1 as orden,
q::date as date,
				extract(day from q) as dia,
				extract(dow from q) as wdia
			FROM generate_series(current_date - " . ($lastdays - 1) . ", current_date, '1 day') as q;";

$r = Apretaste::query($sql);

$wdias = array(
		'Su',
		'Mo',
		'Tu',
		'We',
		'Tr',
		'Fr',
		'Sa'
);

$ah = array();

foreach ( $r as $row ) {
	$ah[$row['orden']] = $row;
	$ah[$row['orden']]['wdia'] = $wdias[$ah[$row['orden']]['wdia']];
}

$data['access_by_hour'] = $access_by_hour;
$data['ah'] = $ah;

// International
$answer_by_hour = array();

for($i = 0; $i <= 23; $i ++) {
	$answer_by_hour[$i] = array();
	for($j = 1; $j <= $lastdays; $j ++)
		$answer_by_hour[$i][$j] = 0;
}

$r = ApretasteAnalitics::getSMSByHour($lastdays, false);

if (is_array($r))
	foreach ( $r as $rx ) {
		$answer_by_hour[$rx['hora']][$rx['orden']] = intval($rx['total']);
	}

$sql = "
SELECT
q::date - current_date + " . ($lastdays - 1) . " + 1 as orden,
extract(day from q) as dia,
extract(dow from q) as wdia
			FROM generate_series(current_date - " . ($lastdays - 1) . ", current_date, '1 day') as q;";

$r = Apretaste::query($sql);

$wdias = array(
		'Su',
		'Mo',
		'Tu',
		'We',
		'Tr',
		'Fr',
		'Sa'
);

foreach ( $r as $row ) {
	$ans[$row['orden']] = $row;
	$ans[$row['orden']]['wdia'] = $wdias[$ans[$row['orden']]['wdia']];
}

$data['answer_by_hour'] = $answer_by_hour;

$data['ah'] = $ah;
$data['ans'] = $ah;
$data['lastdays'] = $lastdays;

$data['servers'] = Apretaste::query("
				select get_email_domain(extract_email(author)) as servidor, count(*) as cant
						from message
		where command = 'sms'
		group by servidor
		order by cant desc
		limit 20;");
