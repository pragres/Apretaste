<?php
$name = post('edtSearchName', '');
$email = post('edtSearchEmail', '');
$phone = post('edtSearchPhone', '');

$email = Apretaste::extractEmailAddress($email);

$name = str_replace("'", "''", $name);
$phone = str_replace("'", "''", $phone);

if (isset($email[0]))
	$email = $email[0];
else
	$email = '';


$data['searchresults'] = array();

if (trim($phone . $email . $name) != '') {
	$r = Apretaste::query("
		SELECT * FROM agency_customer 
		WHERE 
		(email ~* '$email' OR '$email' = '')  
		AND (phone ~* '$phone' or '$phone' = '')
		AND (full_name ~* '$name' or '$name' = '');");

	if (isset($r[1])) {
		$data['searchresults'] = $r;
		echo new div("../tpl/admin/agency.tpl", $data);
		exit();
	} else if (isset($r[0]))
		if (isset($r[0]['id'])) {
			header("Location: index.php?path=admin&page=agency_customer&id=" . $r[0]['id']);
			exit();
		}
}

header("Location: index.php?path=admin&page=agency&customer_not_found=true");
