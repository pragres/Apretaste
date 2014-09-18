<?php
$current_year = intval(date("Y"));
$current_month = intval(date("m"));

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
$data['email_servers'] = ApretasteAnalitics::getEmailServers(20);

$r = ApretasteAnalitics::getMessagesByCommand(null, false);

$msg_by_command = array();
foreach ( $r as $x ) {
	if (! isset($msg_by_command[$x['command']])) {
		$msg_by_command[$x['command']] = array();
		for($i = 1; $i <= 12; $i ++)
			$msg_by_command[$x['command']][$i] = 0;
	}
	$msg_by_command[$x['command']][$x['mes']] = $x['cant'];
}

$data['msg_by_command'] = $msg_by_command;

// $data['popular_phrases'] = ApretasteAnalitics::getPopularPhrases(10);
// $data['popular_terms'] = ApretasteAnalitics::getPopularKeywords(10);

$r = Apretaste::query("SELECT min(moment)::date as first_day, max(moment)::date as last_day,  extract(days from max(moment) - min(moment)) as difference FROM message;");

$data['first_day'] = $r[0]['first_day'];
$data['last_day'] = $r[0]['last_day'];
$data['days_online'] = $r[0]['difference'];

$data['messages_by_day'] = 0;
$data['messages_by_week'] = 0;
$data['messages_by_hour'] = 0;
$data['messages_by_minute'] = 0;
/*
if ($data['days_online'] > 0) {
	$data['messages_by_day'] = number_format($data['total_messages'] / $data['days_online'], 2);
	$data['messages_by_week'] = number_format($data['messages_by_day'] * 7, 2);
	$data['messages_by_hour'] = number_format($data['messages_by_day'] / 24, 2);
	$data['messages_by_minute'] = number_format($data['messages_by_hour'] / 60, 2);
}
*/
// New users
/*
$newusers = array();

for($year = $current_year - 1; $year <= $current_year; $year ++) {
	$newusers[$year] = array();
	for($month = 1; $month <= 12; $month ++) {
		$newusers[$year][$month] = ApretasteAnalitics::getCountOfNewUsers($year, $month);
	}
}

$data['newusers'] = $newusers;
*/
// Access by month
$access_by_month = array();

for($year = $current_year - 1; $year <= $current_year; $year ++) {
	$access_by_month[$year] = array();
	for($month = 1; $month <= 12; $month ++) {
		$access_by_month[$year][$month] = 0;
	}
}

$r = ApretasteAnalitics::getAccesByMonth();

foreach ( $r as $x ) {
	$access_by_month[$x['ano']][$x['mes']] = $x['total'];
}

$data['access_by_month'] = $access_by_month;

// Access by day
$atm = ApretasteAnalitics::getAccessIn($current_year, $current_month);

$atmx = array();
$last_day = 0;
if (is_array($atm))
	foreach ( $atm as $atmy ) {
		$atmx[$atmy['day']] = $atmy;
		$last_day = $atmy['day'];
	}

for($i = 1; $i <= $last_day; $i ++) {
	if (! isset($atmx[$i]))
		$atmx[$i] = 0;
}

$data['access_this_month'] = $atm;

// Access by hour
$lastdays = 15;

$access_by_hour = array();

for($i = 0; $i <= 23; $i ++) {
	$access_by_hour[$i] = array();
	for($j = 1; $j <= $lastdays; $j ++)
		$access_by_hour[$i][$j] = 0;
}

$r = ApretasteAnalitics::getAccessByHour($lastdays);

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

if (is_array($r))
	foreach ( $r as $row ) {
		$ah[$row['orden']] = $row;
		$ah[$row['orden']]['wdia'] = $wdias[$ah[$row['orden']]['wdia']];
	}

$data['access_by_hour'] = $access_by_hour;

// Answer by hour

$answer_by_hour = array();

for($i = 0; $i <= 23; $i ++) {
	$answer_by_hour[$i] = array();
	for($j = 1; $j <= $lastdays; $j ++)
		$answer_by_hour[$i][$j] = 0;
}

$r = ApretasteAnalitics::getAnswerByHour($lastdays);

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

if (is_array($r))
	foreach ( $r as $row ) {
		$ans[$row['orden']] = $row;
		$ans[$row['orden']]['wdia'] = $wdias[$ans[$row['orden']]['wdia']];
	}

$data['answer_by_hour'] = $answer_by_hour;

$data['ah'] = $ah;
$data['ans'] = $ah;
$data['lastdays'] = $lastdays;

// Best users
/*$data['best_users'] = array();

$r = ApretasteAnalitics::getBestUsers();

$data['best_users'] = $r;
*/
// Last message
/*
$r = Apretaste::query("SELECT * FROM message WHERE moment = (SELECT max(moment) FROM message);");
$r = $r[0];

$r['extra_data'] = @unserialize($r['extra_data']);
$r['author'] = str_replace("From: ", "", iconv_mime_decode("From: {$r['author']}", ICONV_MIME_DECODE_CONTINUE_ON_ERROR, "ISO-8859-1"));
$r['author'] = htmlentities($r['author']);
$r['author_email'] = Apretaste::extractEmailAddress($r['author']);

$data['last_msg'] = $r;
*/
// Last messages
/*
$r = Apretaste::query("SELECT * FROM message order by moment desc limit 20;");
if (is_array($r))
	foreach ( $r as $k => $v ) {
		$r[$k]['author'] = str_replace("From: ", "", iconv_mime_decode("From: {$r[$k]['author']}", ICONV_MIME_DECODE_CONTINUE_ON_ERROR, "ISO-8859-1"));
		$r[$k]['author'] = htmlentities($r[$k]['author']);
		$r[$k]['author_email'] = Apretaste::extractEmailAddress($r[$k]['author']);
	}
$data['last_msgs'] = $r;
*/
// Linker
/*
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
*/
// engagement and bounce
/*
$r = ApretasteAnalitics::getEngagementAndBounce();

$engagement = array();

for($j = $current_year - 1; $j <= $current_year; $j ++) {
	$engagement[$j] = array();
	for($i = 1; $i <= 12; $i ++) {
		$engagement[$j][$i] = array(
				"total" => 0,
				"engagement" => 0,
				"engagement_percent" => 0,
				"bounce_rate" => 0,
				"bounce_rate_percent" => 0
		);
	}
}

if (is_array($r))
	foreach ( $r as $row ) {
		$engagement[$row['year']][$row['month']] = $row;
	}

$data['engagement'] = $engagement;
*/
$data['current_year'] = $current_year;
$data['current_month'] = $current_month;

// Sources of traffic
//$data['sources_of_traffic'] = ApretasteAnalitics::getBestUsers(true);

/*
 * $r = Apretaste::query("SELECT servidor,mes,cant FROM source_of_traffic WHERE ano = extract(year from current_date);"); foreach ( $r as $x ) { if (! isset($data['sources_of_traffic'][$x['servidor']])) { $data['sources_of_traffic'][$x['servidor']] = array(); for($i = 1; $i <= 12; $i ++) $data['sources_of_traffic'][$x['servidor']][$i] = 0; } $data['sources_of_traffic'][$x['servidor']][$x['mes']] = $x['cant']; }
 */

// Popular phrases
//$data['popular_phrases'] = ApretasteAnalitics::getPopularPhrases(20, null, null, true);

// Total users
/*
$r = Apretaste::query("SELECT count(*) as total from messages_authors;");

$data['total_users'] = $r[0]['total'];
*/
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

// engagement and bounce
/*
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
*/
$data['current_year'] = $current_year;
$data['current_month'] = $current_month;

