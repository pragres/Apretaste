<?php
$data['msg-type'] = "msg-ok";

$submit = post('btnAddUser');

if (! is_null($submit)) {
	$login = post('user_login');
	$pass = post('user_pass');
	$role = post('user_role');
	
	Apretaste::query("INSERT INTO users (user_login,user_pass, user_role) VALUES ('$login',md5('$pass'),'$role');");
	
	// $user = new UsersEntity(array("user_login" => $login, "user_pass" => $pass));
	$data['msg'] = "The user $login was inserted successfull.";
}

$delete = get('delete');

if (! is_null($delete)) {
	Apretaste::query("DELETE FROM users WHERE user_login='$delete';");
	$data['msg'] = "The user $delete was deleted successfull.";
}

$users = Apretaste::query("SELECT * FROM users;");
$data['users'] = $users;
