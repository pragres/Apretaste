{= title: Roles =}
{= path: "index.php?q=users_roles" =}

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

	$roles?

		{%% form-block: {
			id: "frmNewRole",
			title: "New role",
			action: "users_roles",
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
					xvalue: "{$value}",
					xtext: "{$value}",
					label: "Default page"
				}, {
					id: "chkAccessTo",
					label: "Access to:",
					type: "multichecks",
					options: $pages,
					xvalue: "{$value}",
					xtext: "{$value}"
				}
			],
			submit: {
				name: "btnAddRole",
				caption: "Add"
			}
		} %%}
headerdown}}	
	

