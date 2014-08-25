<?php
$data['msg-type'] = "msg-ok";

if (isset($_POST['btnUpdateAgency'])) {
	
	$profit = post("edtProfit");
	
	if ($profit > 1)
		$profit = $profit / 100;
	
	Apretaste::setConfiguration("agency_profit", $profit);
	
	$profit = post("edtResidualProfit");
	
	if ($profit > 1)
		$profit = $profit / 100;
	
	Apretaste::setConfiguration("agency_residual_profit", $profit);
}

// Load data
$data['edtProfit'] = Apretaste::getConfiguration("agency_profit", 0);
$data['edtResidualProfit'] = Apretaste::getConfiguration("agency_residual_profit", 0);
$data['agents'] = Apretaste::query("SELECT * FROM users where user_role = 'agent' order by user_login;");
$data['agency_percents'] = q("select * from agency_percents;");
$data['agencies'] = q("select * from agency_expanded;");