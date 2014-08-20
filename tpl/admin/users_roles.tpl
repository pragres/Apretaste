{= title: Roles =}
{= path: index.php?path=admin&page=users_roles =}
{= pagewidth: 1024 =}
{% layout %}
{{page
	{% users_panel %}
	<table><tr><td valign = "top">
	?$roles
	<div class="box">
		<h2>Roles</h2>
	<table class="tabla">
		<tr><th>Role</th><th>Access/Permissions</th><th>Default page</th><th></th></tr>
		<tr><td>admin</td><td>[all pages]</td><td>dashboard</td><td></td></tr>
	[$roles]
		<tr><td><a href = "?path=admin&page=users_roles_edit&user_role={$user_role}">{$user_role}</a></td><td>{$access_to}</td><td>{$default_page}</td>
		<td width="32">
					<a href = "?path=admin&page=users_roles&delete={$user_role}" onclick="return confirm('Are you sure?');">{ico}delete{/ico}</a>
				</td>
		</tr>
	[/$roles]
	</table>
	</div>
	$roles?
	</td><td valign="top">
	<div class="box">
		<h2>New role</h2>
		<form action="{$path}" method="post">
			
			Role: <br/>
			<input class = "text" name="edtRole"><br/><br/>
			Default page:<br/>
			<select name="edtDefaultPage" class="text"><br/>
			[$pages]
				<option value="{$value}">{$value}</option>
			[/$pages]
			</select>
			<br/><br/>
			Access to: <br/>
			<div class="box" style="height: 200px;overflow:auto;width: 300px;">
			[$pages]
				<input type="checkbox" name="chkAccessTo[]" value="{$value}" class="checkbox"> {$value}<br/>
			[/$pages]
			</div>
			<br/><br/>
			<input type="submit" name="btnAddRole" class="submit" value="Add">
		</form>
	</div>
	</td></tr></table>
page}}