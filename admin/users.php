<?php
$data['msg-type'] = "msg-ok";

$submit = post('btnAddUser');

if (! is_null($submit)) {
	$login = post('user_login');
	$pass = post('user_pass');
	$role = post('user_role');
	$agency = post('agency', '');
	
	q("INSERT INTO users (user_login,user_pass, user_role, agency) VALUES ('$login',md5('$pass'),'$role','$agency');");
	
	// $user = new UsersEntity(array("user_login" => $login, "user_pass" => $pass));
	$data['msg'] = "The user $login was inserted successfull.";
}

$delete = get('delete');

if (! is_null($delete)) {
	q("DELETE FROM users WHERE user_login='$delete';");
	$data['msg'] = "The user $delete was deleted successfull.";
}

$users = q("SELECT * FROM users;");
foreach ( $users as $k => $v ) {
	$users[$k]['agency'] = q("SELECT * FROM agency WHERE id = '{$v['agency']}';");
	if ($v['email'] != '') {
		$users[$k] = array_merge(Apretaste::getAuthor($v['email'], true, 20), $users[$k]);
	}
}
$data['users'] = $users;
$data['agencies'] = ApretasteAdmin::getAgencies();
