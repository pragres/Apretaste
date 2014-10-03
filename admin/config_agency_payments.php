<?php

$data['agencies'] = q("SELECT * FROM agency order by name;");

$add = post("btnNewPayment");

if (! is_null($add)) {
	$agency = post("cboAgency");
	$amount = post("edtAmount");
	$date = post("edtDate");
	
	q("INSERT INTO agency_payment (agency, amount, date, user_login) VALUES ('$agency','$amount','$date', '{$data['user']['user_login']}');");
	
	$data['msg']= 'The payment was carrie out';
	$data['msg-type']= 'success';
}

if (isset($data['agencies'][0])) {
	$filter = post('cboAgency', $data['agencies'][0]['id']);
	$data['payments'] = q("SELECT * FROM agency_payment where agency = '{$filter}';");
	$data['filter'] = q("SELECT * FROM agency where id = '{$filter}';");
	$data['filter'] = $data['filter'][0];
} 
