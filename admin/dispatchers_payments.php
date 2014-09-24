<?php
if (isset($_POST['btnAddPayment'])) {
	
	$dispatcher = post('edtDispatcher');
	$amount = post('edtAmount');
	$date = post('edtDate');
	
	q("INSERT INTO dispatcher_payment (dispatcher, payment_date, amount) VALUES ('$dispatcher','$date',$amount);");
	$data['msg'] = "The payment was carried out";
	$data['msg-type'] = "success";
}

if (isset($_GET['delete'])) {
	q("DELETE FROM dispatcher_payment where id ='" . $_GET['delete'] . "';");
	$data['msg'] = "The payment was retired";
	$data['msg-type'] = "success";
}

$data['dispatchers'] = q("SELECT email,name FROM dispatcher;");

$data['payments'] = q("SELECT payment_date as \"date\", amount, dispatcher, id FROM dispatcher_payment order by payment_date desc limit 50;");

if (! is_array($data['payments']))
	$data['payments'] = array();
