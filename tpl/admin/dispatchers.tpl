{= title: "Dispatchers" =}
{= path: "index.php?path=admin&page=dispatchers" =}

{% layout %}

{{headerdown
		{%% table: {
			id: "dispatchers",
			data: $dispatchers,
			hideColumns: {picture: true, name: true},
			headers: {
				picture: "Picture",
				total_sold: "Sold",
				contact: "Contact info",
				options: "Options",
				email: "Dispatcher"			
			},
			column_width: {
				email: 300,
				contact: 300
			},
			wrappers:{
				email: '<table width="100%" cellspacing="0" cellpadding="0"><tr><td ><img height="100%" src="data:image/jpeg;base64,{$picture}"></td><td align="left">{$name}&nbsp;<br/><a href="index.php?path=admin&page=user_activity&user={$value}" target="_blank">{$value}</a></td></tr></table>',
				cards: '<a href="{$path}_card_sales&sales={$email}">{$value} pkgs</a>',
				options: '<a href="{$path}&delete={$value}" onclick="return confirm(\'Are you sure?\');"><span class="glyphicon glyphicon-trash"></span></a>',
				total_sold: '${#value:2.#}',
				owe: '<a href="index.php?path=admin&page=dispatchers_payment_warning&dispatcher={$email}" title="View payment warning">${#value:2.#}</a>'
			}
		} %%}
		
		{%% form-block:{
			id: "form-dispatcher",
			modal: true,
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
					type: "textarea",
					id: "edtContact",
					label: "Contact info"
				}
			],
			submit: {
				name: "btnAddDispatcher",
				caption: "Add dispatcher"
			}
			
		} %%}
headerdown}}