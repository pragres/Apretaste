<?php
$email = post("edtEmail");

$author = Apretaste::getAuthor($email);

if (! is_null($email)) {
	
	$amount = post("edtAmount");
	$customer = post('edtCustomer');
	
	$u = q("SELECT agency FROM users WHERE user_login = '{$data['user']['user_login']}';");
	
	$agency = $u[0]['agency'];
	
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
	
	Apretaste::sendEmail($email, array(
			"answer_type" => "recharge_successfull",
			"recharge_agency" => true,
			"customer" => $customer,
			"amount" => $amount,
			"author" => $author,
			"newcredit" => $credit
	), true);
	
	$customer = $customer['id'];
}

$r = Apretaste::query("SELECT * FROM agency_recharge WHERE id = '$id';");

$data['recharge'] = $r[0];
$data['author'] = $author;

header("Location: index.php?path=admin&page=agency_customer&id=" . $customer);