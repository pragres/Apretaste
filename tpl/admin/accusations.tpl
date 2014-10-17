{= title: Accusations =}
{= path: "?path=admin&page=accusations" =}
{= pagewidth: 1024 =}

{% layout %}

{{headerdown

	{%% table: {
		data: $accusations,
		headers: {
			fa: "Date",
			announcement: "Ad",
			id: ""
		},
		columns: ['fa','announcement','author','title','reason','accused', 'id'],
		wrappers: {
			author: '<a href="?q=user_activity&user={$author}">{$author}</a>',
			id: '<a href="?q=accusations&delete={$id}" title ="Ignore this subscribe" onclick="return confirm(\'Are you sure?\');"><span class="glyphicon glyphicon-trash"></span></a> 
			<a href="?q=accusations&proccess={$id}" title ="Proccess this subscribe" onclick="return confirm(\'Are you sure?\');"><span class="glyphicon glyphicon-cog"></span></a>',
			announcement: '<a href="?q=ad&id={$announcement}">{$announcement}</a>&nbsp;<a href="?q=ad&delete={$announcement}" onclick="return confirm(\'Are you sure?\');" title="Delete the ad"><span class="glyphicon glyphicon-trash"></span></a>'
		}
	} %%}
	
headerdown}}