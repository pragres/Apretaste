{= title: Roles =}
{= path: "?q=users_roles" =}

{% layout %}
{{headerdown

	?$roles

	<h2>Roles</h2>
	<table class="table">
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
<!--{
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
	}-->
	$roles?

		{%% form-block: {
			id: "frmNewRole",
			title: "New role",
			action: $path,
			modal: true,
			width: '300px',
			fields: [
				{
					id: "edtRole",
					type: "text",
					label: "Role"					
				},{
					id: "edtDefaultPage",
					type: "select",
					options: $pages,
					id: "{$value}",
					text: "{$value}",
					label: "Default page"
				}, {
					id: "chkAccessTo",
					label: "Access to:",
					type: "multichecks",
					options: $pages,
					id: "{$value}",
					text: "{$value}"
				}
			],
			submit: {
				name: "btnAddRole",
				caption: "Add"
			}
		} %%}
headerdown}}	
	

