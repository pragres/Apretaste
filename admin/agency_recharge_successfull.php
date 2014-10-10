<?php
$email = get('email');

$data['customer'] = get('customer');
$data['author'] = Apretaste::getAuthor($email, false, 100);
$data['author']['credit'] = ApretasteMoney::getCreditOf($email);
$data['msg'] = "Recharge successfull for <b>$email</b>";
$data['msg-type'] = 'success';
