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

if (isset($_POST['btnAddProfit'])) {
	$user_login = post('edtUserLogin');
	$profit = post('edtProfit');
	
	if ($profit > 1)
		$profit = $profit / 100;
	
	$type = post('edtType');
	Apretaste::query("INSERT INTO agency_profit (user_login, profit, type) VALUES ('$user_login','$profit','$type');");
}

if (isset($_GET['delete_profit'])) {
	Apretaste::query("DELETE FROM agency_profit WHERE id ='{$_GET['delete_profit']}';");
}

// Load data
$data['edtProfit'] = Apretaste::getConfiguration("agency_profit", 0);
$data['edtResidualProfit'] = Apretaste::getConfiguration("agency_residual_profit", 0);
$data['profits'] = Apretaste::query("SELECT * FROM agency_profit order by moment;");
$data['agents'] = Apretaste::query("SELECT * FROM users where user_role = 'agent' order by user_login;");