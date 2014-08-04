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
	
}

$r = Apretaste::query("SELECT * FROM agency_recharge WHERE id = '$id';");

$data['recharge'] = $r[0];
$data['author'] = $author;