<?php
$data['msg-type'] = "msg-ok";

if (isset($_POST['btnUpdateAgency'])) {
	
	$profit = post("edtProfit");
	
	if ($profit > 1)
		$profit = $profit / 100;
	
	c("agency_profit", $profit, true);
	
	$profit = post("edtResidualProfit");
	
	if ($profit > 1)
		$profit = $profit / 100;
	
	c("agency_residual_profit", $profit, true);
}

if (post("btnUpdateAgencyPercents", false)) {
	$profit = post('edtAgencyProfitPercent', 0.2);
	$residual = post('edtAgencyResidualPercent', 0.05);
	
	if ($profit >= 1)
		$profit = number_format($profit / 100, 2) * 1;
	if ($residual >= 1)
		$residual = number_format($residual / 100, 2) * 1;
	
	$id = post('cboAgencyPercents');
	
	q("update agency set profit_percent = $profit, residual_percent = $residual where id = '$id';");
}

// Load data
$data['edtProfit'] = c("agency_profit", 0);
$data['edtResidualProfit'] = c("agency_residual_profit", 0);
$data['agents'] = q("SELECT * FROM users where user_role = 'agent' order by user_login;");
$data['agency_percents'] = q("select * from agency_percents order by name;");
$data['agencies'] = q("select * from agency_expanded;");