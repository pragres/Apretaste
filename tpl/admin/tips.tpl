{= title: Tips =}
{= path: "index.php?path=admin&page=tips" =}

{% layout %}

{{headerdown
	{%% table: {
		data: $tips,
		columns: ['tip','id'],
		headers: {id: ''},
		wrappers: {
			id: '<a href="{$path}&delete={$id}" title="Delete" onclick="return confirm(\'Are you sure?\')">
				 <span class="glyphicon glyphicon-trash"></span></a>'
		}
	} %%}	
	
	{%% form-block: {
		id: "frmNewTip",
		title: "New tip",
		action: $path,
		modal: true,
		fields:[
			{
				type: "textarea",
				id: "tipText"
			}
		],
		submit:{
			caption: "Add",
			name: "btnAddTip"
		}
	} %%}
headerdown}}