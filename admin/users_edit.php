<?php
$user_login = get('user_login');

$edit = post('btnEditUser');

if (is_null($edit)) {
	
	$data['agencies'] = ApretasteAdmin::getAgencies();
	$data['roles'] = q("SELECT * FROM users_perms ORDER BY user_role");
	
	if (! is_null($user_login)) {
		$data['xuser'] = q("SELECT * FROM users WHERE user_login = '$user_login';");
		
		if (isset($data['xuser'][0]))
			$data['xuser'] = $data['xuser'][0];
		
		$data['xuser'] = array_merge(Apretaste::getAuthor($data['xuser']['email']), $data['xuser']);
	} else
		header("Location: index.php?q=users");
} else {
	
	$n_user_login = post('user_login');
	$n_user_role = post('user_role');
	$n_email = post('user_email');
	$n_pass = trim(post('user_pass'));
	$n_agency = post('agency');
	q("UPDATE users 
	SET user_login = '{$n_user_login}',
	user_role = '{$n_user_role}',
	email = '{$n_email}',
	user_pass = " . (is_null($n_pass) || $n_pass == '' ? 'user_pass' : md5($n_pass)) . ",
	agency = '$n_agency'
	WHERE user_login = '$user_login';");
	
	header("Location: index.php?path=admin&page=users");
}