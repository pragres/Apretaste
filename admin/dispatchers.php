<?php

/**
 * Apretaste!com Administration
 *
 * Dispatchers
 */
if (isset($_POST['btnAddDispatcher'])) {
	$r = ApretasteMoney::addDispatcher(strtolower(trim($_POST['edtEmail'])), $_POST['edtName'], $_POST['edtContact']);
	
	if ($r == false) {
		$data['msg'] = 'The dispatcher <b>' . $_POST['edtEmail'] . '</b> already exists';
		$data['msg-type'] = 'danger';
	} else {
		$data['msg'] = 'The dispatcher <b>' . $_POST['edtEmail'] . '</b> was inserted successfull';
		$data['msg-type'] = 'info';
	}
}

if (isset($_GET['delete'])) {
	ApretasteMoney::delDispatcher($_GET['delete']);
}

$data['dispatchers'] = array();

$r = ApretasteMoney::getDispatchers(30, isset($_GET['pdf']));

foreach ( $r as $row ) {
	$data['dispatchers'][] = array(
			"picture" => $row['picture'],
			"email" => $row['email'],
			"name" => $row['name'],
			"contact" => $row['contact'],
			"cards" => $row['sales'],
			"total_sold" => $row['total_sold'],
			"profit" => $row['profit'],
			"owe" => $row['owe'] < 0 ? 0 : $row['owe'],
			"options" => $row['email']
	);
}

if (isset($_GET['pdf'])) {
	
	$html = new ApretasteView("../tpl/admin/dispatchers.pdf.tpl", $data);
	$html = "$html";
	
	include "../lib/mpdf/mpdf.php";
	$mpdf = new mPDF();
	$mpdf->WriteHTML($html);
	
	$mpdf->Output("Apretaste - Vendedores - Deudores - " . date("Y-m-d h-i-s") . ".pdf", 'D');
	
	return true;
}