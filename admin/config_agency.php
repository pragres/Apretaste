<?php
$data['msg-type'] = "msg-ok";

if (isset($_GET['download'])) {
	
	switch ($_GET['download']) {
		case 'bill' :
			$data['user']['agency'] = $_GET['agency'];
			
			include_once "../admin/agency_bill.php";
			
			$html = new div("../tpl/admin/agency_bill.pdf.tpl", $data);
			
			$html = "$html";
			
			include "../lib/mpdf/mpdf.php";
			
			$mpdf = new mPDF();
			
			$mpdf->WriteHTML($html);
			
			$mpdf->Output("Apretaste Payment Reminder - {$data['agency']['name']} - " . date("Y-m-d h-i-s") . ".pdf", 'D');
			
			return true;
			
			break;
	}
}

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

$data['best_amount'] = q("select (select name from agency where id = agency) as label, amount as data from agency_best_amount;");
foreach ( $data['best_amount'] as $k => $v )
	$data['best_amount'][$k]['data'] *= 1;

$data['best_recharges'] = q("select (select name from agency where id = agency) as label, recharges as data from agency_best_recharges;");
foreach ( $data['best_recharges'] as $k => $v )
	$data['best_recharges'][$k]['data'] *= 1;

$current_year = intval(date("Y"));
$current_month = intval(date("m"));

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

$r = q("SELECT extract(month from moment::date) as mes, sum(amount) as amount, count(*) as total FROM agency_recharge WHERE extract(year from current_date) = extract(year from moment::date) group by mes;");

$e = array();

for($i = 1; $i <= 12; $i ++) {
	$e[$i - 1] = array(
			"y" => $months[$i - 1],
			"a" => 0,
			"b" => 0
	);
}

foreach ( $r as $row ) {
	$e[$row['mes'] - 1]['a'] = intval($row['amount']);
	$e[$row['mes'] - 1]['b'] = intval($row['total']);
}

$data['stats_by_month'] = $e;
$data['current_year'] = $current_year;
$data['current_month'] = $current_month;

