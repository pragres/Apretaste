<?php

$data['agency'] = ApretasteMoney::getAgency($data['user']['agency']);
$data['weeks'] = q("select * from agency_week_details where agency = '{$data['user']['agency']}' order by year desc, month desc, week desc;");

if (!is_array($data['weeks']))
	$data['weeks'] = array();

