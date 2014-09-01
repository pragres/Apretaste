<?php

$email = post("edtEmail");
$user = Apretaste::getAuthor($email);
$user['picture'] = Apretaste::resizeImage($user['picture'], 200);
$amount = post("edtAmount");

$amount = $amount * 1;

if ($amount < 0)
	$amount = 0;


$agency = ApretasteAdmin::getAgency($data['user']['agency']);

//if ($agency['credit']<$amount)
	

$customer = post('edtCustomer');

$data['author'] = $user;
 
