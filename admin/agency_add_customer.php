<?php

/**
 * Apretaste Agency Section
 *
 * Add a new customer
 * @author rafa <rafa@pragres.com>
 */

$name = trim(str_replace("'", "''", post("edtName")));

$email = Apretaste::getAddressFrom(post("edtEmail"));

if (isset($email[0]))
	$email = $email[0];
else
	$email = null;

$data = array_merge($data, array(
		"div.get.section" => 'add_customer',
		"edtName" => str_replace('"', '', post('edtName')),
		"edtEmail" => $email,
		"edtPhone" => str_replace('"', '', post('edtPhone'))
));

if (! is_null($email) && trim($name) != '') {
	
	$phone = str_replace("'", "''", post("edtPhone"));
	
	$r = Apretaste::query("SELECT * FROM agency_customer WHERE email = '$email';");
	if (! isset($r[0])) {
		
		$r = Apretaste::query("INSERT INTO agency_customer (full_name,email,phone) values ('$name','$email','$phone') RETURNING id;");
		
		header("Location: index.php?path=admin&page=agency_customer&id={$r[0]['id']}");
	} else {
		$data["msgerror"] = "The customer were not inserted because their email already exists in the database.";
		$data["customer_exists"] = ApretasteAdmin::getAgencyCustomer($r[0]['id']);
	}
} else
	$data["msgerror"] = "The customer were not inserted because the <b>Email</b> and <b>Full Name</b> fields are required.";

echo new ApretasteView('../tpl/admin/agency.tpl', $data);

exit();