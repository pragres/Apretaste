{= title: "Users" =}
{= path: "?q=users" =}

{% layout %}

{{headerdown

		{%% table: {
			title: "Admin's users",
			data: $users,
			columns: ["picture","user_login","user_role","email","agency"],
			headers: {
				user_login: "User login",
				user_role: "Role"
			},
			wrappers: {
				agency: "?$agency {$agency.name} @else@ None $agency?",
				picture: '<a href = "?path=admin&page=users&delete={$user_login}" onclick="return confirm('Are you sure?');"><span class="glyphicon glyphicon-trash"></a>&nbsp;<img src="data:image/jpeg;base64,{$picture}" width="20">',
				user_role: '<a href="index.php?q=users_roles_edit&user_role={$user_role}">{$user_role}</a>',
				user_login: '<a href = "?q=users_edit&user_login={$user_login}">{$user_login}</a>'
				
			}
		} %%}
		
		{%% form-block: {
			id: "frmNewUser",
			action: 'users',
			title: "New user",
			modal: true,
			fields: [
				{
					id: "user_login",
					type: "text",
					label: "Login"
				},{
					id: "user_role",
					label: "Role",
					type: "select",
					options: $roles,
					xvalue: '{$user_role}',
					xtext: '{$user_role}'
				},{
					id: "user_email",
					type: "text",
					label: "Email"
				},{
					id: "user_pass",
					label: "Password",
					type: "password"
				},{
					id: "agency",
					label: "Agency",
					type: "select",
					options: $agencies,
					xvalue: "{$id}",
					xtext: "{$name}"
				}
			],
			submit: {
				caption: "Add",
				name: "btnAddUser"
			}
		} %%}
headerdown}}