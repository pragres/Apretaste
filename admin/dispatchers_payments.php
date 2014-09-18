<?php

if (isset($_POST['btnAddPayment'])){
	
	$dispatcher = post('edtDispatcher');
	$amount = post('edtAmount');
	$date = post('edtDate');
	
	q("INSERT INTO dispatcher_payment (dispatcher, payment_date, amount) VALUES ('$dispatcher','$date',$amount);");
	
}

$data['dispatchers'] = q("SELECT email,name FROM dispatcher;");

$data['payments'] = q("SELECT payment_date as \"date\", amount, dispatcher FROM dispatcher_payment order by payment_date desc limit 50;");

