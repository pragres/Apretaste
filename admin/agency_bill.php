<?php

if (!isset($_GET['zoom']))
$_GET['zoom'] = 'week';

switch($_GET['zoom']){
	case 'week':
		$data['weeks'] = q("select * from agency_weeks_without_payment where agency = '{$data['user']['agency']}' order by year, month, week;");
		break;
	case 'day':
		$data['weeks'] = q("select agency, 
			extract(day from date)::varchar || ', ' || extract(year from date)::varchar as year,
			extract(month from date) as month, extract(week from date) as week, soles, 
			recharges_amount as amount, profit, residuals, payment_amount as payment, owe, owe_cumul from agency_days_without_payment
			where agency = '{$data['user']['agency']}' order by date;");
		break;
}

$data['agency'] = ApretasteMoney::getAgency($data['user']['agency']);



if (! is_array($data['weeks']))
	$data['weeks'] = array();
else {
	$total = 0;
	foreach ( $data['weeks'] as $v ) {
		$total += $v['owe'] * 1;
	}
	
	$data['weeks'][0]['owe'] -= ($total - $data['agency']['owe']);
}

foreach ( $data['weeks'] as $k => $v ) {
	if ($v['owe'] * 1 < 0)
		$data['weeks'][$k]['owe'] = 0;
}

if (isset($_GET['download'])) {

	switch ($_GET['download']) {
		case 'bill' :
				
			$html = new ApretasteView("../tpl/admin/agency_bill.pdf.tpl", $data);

			$html = "$html";

			include "../lib/mpdf/mpdf.php";

			$mpdf = new mPDF();

			$mpdf->WriteHTML($html);

			$mpdf->Output("Apretaste Payment Reminder - {$data['agency']['name']} - " . date("Y-m-d h-i-s") . ".pdf", 'D');

			return true;

			break;
	}
}
