<?php
$id = get('id');

if (! is_null(get('update'))) {
	
	$name = str_replace("'", "''", post('edtName'));
	$email = post('edtEmail');
	$email = Apretaste::getAddressFrom($email);
	
	if (isset($email[0])) {
		$email = $email[0];
		
		$phone = str_replace("'", "''", post('edtPhone'));
		
		Apretaste::query("UPDATE agency_customer SET full_name = '$name', email = '$email', phone = '$phone' WHERE id = '$id';");
		
		header("Location: index.php?path=admin&page=agency_customer&id=$id");
	}
	
	$data['msgerror'] = "The email field is required";
}

$data['customer'] = ApretasteAdmin::getAgencyCustomer($id);
