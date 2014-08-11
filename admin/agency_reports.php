<?php

$profit_percent = 0.2;
$debt_percent = 0.2;

$user = ApretasteAdmin::getUser();

$lastdays = 20;

$data['lastdays'] = $lastdays;

$sales_by_hour = array();

for($i = 0; $i <= 23; $i ++) {
	$sales_by_hour[$i] = array();
	for($j = 1; $j <= $lastdays; $j ++)
		$sales_by_hour[$i][$j] = 0;
}

$amount_by_hour = array();

for($i = 0; $i <= 23; $i ++) {
	$amount_by_hour[$i] = array();
	for($j = 1; $j <= $lastdays; $j ++)
		$amount_by_hour[$i][$j] = 0;
}

$sql = "
			select 
				moment::date - current_date + " . ($lastdays - 1) . " + 1 as orden,
				extract(day from moment::date) as dia, 
				extract(hour from moment) as hora,
				count(*) as total,
				sum(amount) as amount
			from agency_recharge
			where 
			user_login = '{$user['user_login']}' AND
			moment::date >= current_date - " . ($lastdays - 1) . "
			group by orden, dia, hora
			order by orden, dia, hora;";

$r = Apretaste::query($sql);

foreach ( $r as $rx ){
	$sales_by_hour[$rx['hora']][$rx['orden']] = intval($rx['total']);
	$amount_by_hour[$rx['hora']][$rx['orden']] = intval($rx['amount']);
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

foreach ( $r as $row ) {
	$ah[$row['orden']] = $row;
	$ah[$row['orden']]['wdia'] = $wdias[$ah[$row['orden']]['wdia']];
}

$data['sales_by_hour'] = $sales_by_hour;
$data['amount_by_hour'] = $amount_by_hour;
$data['ah'] = $ah;
$data['ans'] = $ah;

$sql = "select  
extract(year from moment::date) as year,
extract(month from moment::date) as mes,
count (*) as total,
sum(amount) as amount,
sum(amount)* $profit_percent as profit,
sum(amount)* $debt_percent as debt
from agency_recharge
where 
user_login = '{$user['user_login']}'
group by year, mes
order by year, mes";

$r = Apretaste::query($sql);

$data['profits'] = $r;