{= path: "index.php?path=admin&page=subscribes" =}
{= title: Subscribes =}
{= pagewidth: 1024 =}

{% layout %}

{{headerdown			
	
	{%% table: {
		data: $subscribes,
		title: "Browse subscribes",
		headers: {id: "ID", email: "User", moment: "Post date", last_alert: "Last alert" },
		wrappers: {
			email: '<a href="?path=admin&page=user_activity&user={$email}">{$email}</a>',
			id: '<a href="index.php?path=admin&page=subscribes&delete={$id}" onclick="return confirm(\'Are you sure?\');"><span class="glyphicon glyphicon-trash"></span></a> {$id}'
		}
	} %%}

headerdown}}

