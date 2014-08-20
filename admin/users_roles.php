<?php

if (isset($_POST['btnAddRole'])) {
	
	$user_role = post('edtRole');
	$access_to = post('chkAccessTo', array());
	$access_to = implode(" ", $access_to);
	$default_page = post('edtDefaultPage');
	
	$sql = "INSERT INTO users_perms (user_role, access_to, default_page)
			VALUES ('$user_role','$access_to','$default_page');";
	
	q($sql);
	
	header('Location: index.php?path=admin&page=users_roles');
	exit();
}

if (isset($_GET['delete'])) {
	$ur = $_GET['delete'];
	$ur = str_replace("'", "", $ur);
	q("DELETE FROM users_perms WHERE user_role ='$ur';");
	header('Location: index.php?path=admin&page=users_roles');
	exit();
}

$data['roles'] = q("SELECT * FROM users_perms ORDER BY user_role");
$data['pages'] = ApretasteAdmin::getAdminPages();
