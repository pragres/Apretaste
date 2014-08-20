<?php
if (post('btnEditRole', false)) {
	$user_role = post('edtRole');
	$access_to = post('chkAccessTo', array());
	$access_to = implode(" ", $access_to);
	$default_page = post('edtDefaultPage');
	
	$sql = "UPDATE users_perms 
	SET user_role ='$user_role', 
		access_to = '$access_to' ,
		default_page = '$default_page'
	WHERE user_role = '{$_GET['user_role']}';";
	
	q($sql);
	
	header('Location: index.php?path=admin&page=users_roles');
	exit();
}

if (! isset($_GET['user_role'])) {
	header('Location: index.php?path=admin&page=users_roles');
	exit();
}

$data['role'] = q("SELECT * FROM users_perms WHERE user_role = '{$_GET['user_role']}';");

if (! $data['role']) {
	header('Location: index.php?path=admin&page=users_roles');
	exit();
}

$data['role'] = $data['role'][0];
$data['pages'] = ApretasteAdmin::getAdminPages();