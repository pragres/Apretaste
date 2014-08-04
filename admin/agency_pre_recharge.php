<?php 

$email = post("edtEmail");

$user = Apretaste::getAuthor($email);

$amount = post("edtAmount");

$customer = post('edtCustomer');

$data['author'] = $user;
 
