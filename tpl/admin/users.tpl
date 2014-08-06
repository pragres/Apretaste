{= title: "Users" =}
{% layout %}

	{= path: "?path=admin&page=users" =}
{{page
		?$msg
			<div id = "message" class = "{$msg-type}">{$msg}</div>
		$msg?
		<br/>
		?$users
			<table class="tabla">
			<tr><th>User login</th><th>Role</th><th></th></tr>
		[$users]
			<tr><td>{$user_login}</td><td>{$user_role}</td>
			<td><a href = "?page=users&delete={$user_login}" style ="float:right;">Delete</a></td></tr>
		[/$users]
		</table>
		@else@
			No users<hr>
		$users?
		<hr/>
		<fieldset>
			<legend>New user:</legend>
			<form action="{$path}" method="post">
			Login: <br/>
			<input class = "text" name = "user_login"><br/>
			Role: <br/>
			<input class = "text" name = "user_role"><br/>
			Password: <br/>
			<input class = "text" name = "user_pass" type="password"><br/>
			<input class = "submit" type="submit" value="Add" name="btnAddUser">
			</form>
		</fieldset>
page}}