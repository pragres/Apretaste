<?php
$email = post("edtEmail");

$user = Apretaste::getAuthor($email);

$amount = post("edtAmount");

$amount = $amount * 1;
if ($amount < 0)
	$amount = 0;

$customer = post('edtCustomer');

$data['author'] = $user;
 
