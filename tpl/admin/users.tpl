{= title: "Users" =}
{= path: "?path=admin&page=users" =}
{= pagewidth: 780 =}
{% layout %}

{{page
		{% users_panel %}
		<br/>
		?$users
			<table class="tabla" width="100%">
			<tr><th>User login</th><th>Role</th><th>Email</th><th>Agency</th><th></th></tr>
		[$users]
			<tr>
				<td valign="center">?$picture <img src="data:image/jpeg;base64,{$picture}" width="20"> $picture?<a href = "?path=admin&page=users_edit&user_login={$user_login}">{$user_login}</a></td>
				<td><a href="index.php?path=admin&page=users_roles_edit&user_role={$user_role}">{$user_role}</a></td>
				<td>{$email}</td>
				<td>?$agency {$agency.name} @else@ None $agency?&nbsp;</td>
				<td>
					<a href = "?path=admin&page=users&delete={$user_login}" onclick="return confirm('Are you sure?');">{ico}delete{/ico}</a>
				</td>
			</tr>
		[/$users]
		</table>
		@else@
			No users<hr>
		$users?
	<br/>
		<div class="box">
			<h2>New user:</h2>
			<form action="{$path}" method="post">
			Login: <br/>
			<input class = "text" name = "user_login"><br/>
			
			Role: <br/>
			<select name ="user_role">
			[$roles]
			<option value="{$user_role}">{$user_role}</option>
			[/$roles]
			</select>
			<br/>
			Email: <br/>
			<input class = "text" name = "user_email"><br/>
			Password: <br/>
			<input class = "text" name = "user_pass" type="password"><br/>
			?$agencies
			Agencies: <br/>
			<select name="agency">
				[$agencies]
				<option value="{$id}">{$name}</option>
				[/$agencies]
			</select>
			$agencies?
			<input class = "submit" type="submit" value="Add" name="btnAddUser">
			</form>
		</div>
page}}