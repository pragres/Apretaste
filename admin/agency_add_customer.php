<?php
$name = str_replace("'", "''", post("edtName"));

$email = Apretaste::getAddressFrom(post("edtEmail"));

if (isset($email[0])) {
	$email = $email[0];
	$phone = str_replace("'", "''", post("edtPhone"));
	
	$r = Apretaste::query("INSERT INTO agency_customer (full_name,email,phone) values ('$name','$email','$phone') RETURNING id;");
	
	header("Location: index.php?path=admin&page=agency_customer&id={$r[0]['id']}");
}

$data = array_merge($data, array(
		"div.get.section" => 'add_customer',
		"edtName" => str_replace('"', '', post('edtName')),
		"edtEmail" => $email,
		"edtPhone" => str_replace('"', '', post('edtPhone')),
		"msgerror" => "The customer were not inserted because the <b>Email</b> field is required."
));

echo new div('../tpl/admin/agency.tpl', $data);

exit();