<?php
$email = post("edtEmail");

$author = Apretaste::getAuthor($email);

if (! is_null($email)) {
	
	$amount = post("edtAmount");
	$customer = post('edtCustomer');
	
	$r = Apretaste::query("INSERT INTO agency_recharge (user_login, customer, email, amount)
		VALUES ('{$data['user']['user_login']}','{$customer}','{$email}','{$amount}')
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
	));
	
	if (! Apretaste::isUser($email)) {
		Apretaste::invite($customer['email'], $email);
	}
	
	// Send email to de user
	
	Apretaste::sendEmail($email, array(
			"answer_type" => "recharge_successfull",
			"recharge_agency" => true,
			"customer" => $customer,
			"amount" => $amount,
			"author" => $author,
			"newcredit" => $credit
	));
	
	$customer = $customer['id'];
}

$r = Apretaste::query("SELECT * FROM agency_recharge WHERE id = '$id';");

$data['recharge'] = $r[0];
$data['author'] = $author;

header("Location: index.php?path=admin&page=agency_customer&id=" . $customer);