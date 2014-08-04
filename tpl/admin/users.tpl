{= title: "Users" =}
{% layout %}

	{= path: "?path=admin&page=users" =}
{{page
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
page}}