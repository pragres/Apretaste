<?php
$email = post("edtEmail");

$author = Apretaste::getAuthor($email);
$data['success'] = false;

if (! is_null($email)) {
	
	$amount = post("edtAmount");
	$customer = post('edtCustomer');
	
	$u = q("SELECT agency FROM users WHERE user_login = '{$data['user']['user_login']}';");
	
	$agency = $u[0]['agency'];
	
	$procede = ApretasteMoney::checkCreditLine($agency, $amount);
	
	if ($procede === true) {
		
		if (trim($agency) == '')
			$agency = 'null';
		else
			$agency = "'$agency'";
		
		$r = q("INSERT INTO agency_recharge (user_login, customer, email, amount, agency)
		VALUES ('{$data['user']['user_login']}','{$customer}','{$email}','{$amount}',$agency)
		RETURNING id;");
		
		$id = $r[0]['id'];
		
		$customer = ApretasteAdmin::getAgencyCustomer($customer);
		
		$credit = ApretasteMoney::getCreditOf($email);
		
		// Send email to the customer
		Apretaste::sendEmail($customer['email'], array(
				"answer_type" => "recharge_thankyou",
				"recharge_angecy" => true,
				"customer" => $customer,
				"amount" => $amount,
				"author" => $author,
				"newcredit" => $credit,
				"user_email" => $email
		), true);
		
		if (! Apretaste::isUser($email))
			Apretaste::invite($customer['email'], $email, true, true);
			
			// Send email to de user
		
		ob_start();
		Apretaste::sendEmail($email, array(
				"answer_type" => "recharge_successfull",
				"recharge_agency" => true,
				"customer" => $customer,
				"amount" => $amount,
				"author" => $author,
				"newcredit" => $credit
		), true);
		ob_end_clean();
		
		$data['msg'] = "Recharge successfull for <b>$email</b>";
		$data['msg-type'] = 'success';
		$data['success'] = true;
	} else {
		$data['msg'] = 'This recharge exceeds the credit limit of your agency. Your agency must pay the debt of <b>${#owe:2.#}</b> to recharge over <b>${#max_amount:2.#}</b>.';
		$data['msg-type'] = 'danger';
		$data['owe'] = $procede['owe'];
		$data['max_amount'] = $procede['max_amount'];
	}
	
	$data['customer'] = post('edtCustomer');
} else {
	$data['msg'] = "The user's email was required";
	$data['msg-type'] = "danger";
} 

