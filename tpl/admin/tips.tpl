{= title: Tips =}
{= path: "q=tips" =}

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
		action: 'tips',
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