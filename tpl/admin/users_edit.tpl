{= title: "Edit admin's user" =}
{= path: index.php?q=users_edit&user_login={$user_login} =}

{% layout %}

{{blocks
	<img src="data:image/jpeg;base64,{$xuser.picture}" width="100"><br/>
	?$xuser.name {$xuser.name} $xuser.name?
	
blocks}}

{{page 
	
	{%% form-block: {
		action: $path,
		title: "Edit",
		width: '400px',
		float: 'left',
		fields: [
			{
				id: "user_login",
				type: "text",
				label: "Login",
				value: $xuser.user_login
			},{
				id: "user_role",
				label: "Role",
				type: "select",
				options: $roles,
				value: '{$user_role}',
				text: '{$user_role}',
				default: $xuser.user_role
			},{
				id: "user_email",
				type: "text",
				label: "Email",
				value: $xuser.email
			},{
				id: "user_pass",
				label: "New password",
				type: "password",
				placeholder: "Enter new password"
			},{
				id: "agency",
				label: "Agency",
				type: "select",
				options: $agencies,
				value: "{$id}",
				text: "{$name}",
				default: $xuser.agency
			}
		],
		submit: [
			{
				caption: "Add",
				name: "btnAddUser"
			},{
				caption: "Cancel",
				href: "?q=users"
			}
		]
	} %%}
page}}