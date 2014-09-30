<?php

$data['agency'] = ApretasteMoney::getAgency($data['user']['agency']);
$data['weeks'] = q("select * from agency_weeks_without_payment where agency = '{$data['user']['agency']}' order by year desc, week desc;");

if (!is_array($data['weeks']))
	$data['weeks'] = array();

