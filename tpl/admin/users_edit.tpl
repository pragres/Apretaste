{= title: Edit user =}
{= path: index.php?path=admin&page=users_edit&user_login{$user_login} =}
{= pagewidth: 780 =}
{% layout %}

{{page 
	{% users_panel %}
	<div class="box">
		<h2> Edit user</h2>
		<form action="" method="post">
			Login: <br/>
			<input class = "text" name = "user_login" value="{$xuser.user_login}"><br/>
			Role: <br/>
			<input class = "text" name = "user_role" value="{$xuser.user_role}"><br/>
			Email: <br/>
			<input class = "text" name = "user_email" ?$xuser.email value="{$xuser.email}" $xuser.email?><br/>
			New password: <br/>
			<input class = "text" name = "user_pass" type="password"><br/>
			?$agencies
			Agencies: <br/>
			<select name="agency">
				[$agencies]
				<option value="{$id}" {?( "{$xuser.agency}" == "{$id}" )?} selected {/?}>{$name}</option>
				[/$agencies]
			</select>
			$agencies?
			<input class = "submit" type="submit" value="Ok" name="btnEditUser">
			<a href="index.php?path=admin&page=users" class="button">Cancel</a>
		</form>
	</div>
page}}