<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Users</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "?path=admin&page=users" =}
	<div id = "page">
		<h1><a href = "?page=admin">Apretaste!com</a> - <a href="users">Users</a></h1>
		{% menu %}
		?$msg
			<div id = "message" class = "{$msg-type}">{$msg}</div>
		$msg?
		<br/>
		?$users
		[$users]
			{$user_login}
			<a href = "?page=users&delete={$user_login}" style ="float:right;">Delete</a><br>
		[/$users]
		@else@
			No users<hr>
		$users?
		<hr/>
		<form action="{$path}" method="post">
			New user:<br/>
			Login: <input name = "user_login">
			Role: <input name = "user_role">
			Password: <input name = "user_pass" type="password">
			<input type="submit" value="Add" name="btnAddUser">
		</form>
		</div>
</body>
</html>