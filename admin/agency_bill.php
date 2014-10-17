<?php
$data['agency'] = ApretasteMoney::getAgency($data['user']['agency']);

$data['weeks'] = q("select * from agency_weeks_without_payment where agency = '{$data['user']['agency']}' order by year, month, week;");

if (! is_array($data['weeks']))
	$data['weeks'] = array();
else {
	$total = 0;
	foreach ( $data['weeks'] as $v ) {
		$total += $v['owe'] * 1;
	}
	$data['weeks'][0]['owe'] -= ($total - $data['agency']['owe']);
}
