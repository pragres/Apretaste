<?php

$name = str_replace("'", "''", post("edtName"));

$email = Apretaste::getAddressFrom(post("edtEmail"));

if (isset($email[0]))
	$email = $email[0];
else
	$email = '';

$phone = str_replace("'", "''", post("edtPhone"));

$r = Apretaste::query("INSERT INTO agency_customer (full_name,email,phone) values ('$name','$email','$phone') RETURNING id;");

header("Location: index.php?path=admin&page=agency_customer&id={$r[0]['id']}");