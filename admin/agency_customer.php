<?php
$id = get('id');

if (! is_null(get('update'))) {
	
	$name = str_replace("'", "''", post('edtName'));
	$email = post('edtEmail');
	$email = Apretaste::getAddressFrom($email);
	if (isset($email[0]))
		$email = $email[0];
	else
		$email = '';
	$phone = str_replace("'", "''", post('edtPhone'));
	
	Apretaste::query("UPDATE agency_customer SET full_name = '$name', email = '$email', phone = '$phone' WHERE id = '$id';");
	
	header("Location: index.php?path=admin&page=agency_customer&id=$id");
}

$r = Apretaste::query("SELECT id, full_name, to_char(date_registered, 'Day DD, Month YYYY, HH12:MI:SS') as date_registered, email, phone FROM agency_customer WHERE id = '$id';");

$data['customer'] = $r[0];

$r = Apretaste::query("SELECT email FROM agency_recharge WHERE customer = '{$data['customer']['id']}' group by email;");

$arr = array();

if (is_array($r))
	foreach ( $r as $row ) {
		$arr[] = Apretaste::getAuthor($row['email']);
	}

$data['customer']['contacts'] = $arr;
