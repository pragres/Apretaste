{= title: "Dispatchers" =}
{= path: "index.php?path=admin&page=dispatchers" =}

{% layout %}
{{blocks
	{%% form-block:{
		action: "dispatchers",
		title: "New dispatcher",
		fields: [
			{
				type: "text",
				id: "edtEmail",
				label: "Email"
			},{
				type: "text",
				id: "edtName",
				label: "Name"
			},{
				type: "text",
				id: "edtContact",
				label: "Contact info"
			}
		],
		submit: {
			name: "btnAddDispatcher",
			caption: "Add dispatcher"
		}
		
	} %%}
blocks}}
{{page
		{%% table: {
			data: $dispatchers,
			wrappers:{
				email: '<a href="index.php?path=admin&page=user_activity&user={$value}" target="_blank">{$value}</a>',
				picture: '<img src="data:image/jpeg;base64,{$value}">',
				cards: '{$value} pkgs',
				options: '<a href="{$path}&sales={$value}">view pkgs</a> &nbsp; <a href="{$path}&delete={$value}" onclick="return confirm(\'Are you sure?\');"><span class="glyphicon glyphicon-trash"></span></a>'
			}
		} %%}
page}}