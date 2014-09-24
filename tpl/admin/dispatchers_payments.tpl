{= path: "index.php?path=admin&page=dispatchers_payments" =}
{= title: "Dispatcher's payments" =}
{= pagewidth: 700 =}
{% layout %}


{{blocks
	{%% form-block: {
		action: "dispatchers_payments",
		title: "Add payment",
		fields: [
			{
				id: "edtDispatcher",
				label: "Dispatcher",
				options: $dispatchers,
				value: "{$email}",
				text: "{$name}",
				type: "select"
			},{
				id: "edtDate",
				label: "Date",
				type: "date",
				class: "date",
				value: '{/div.now:Y-m-d/}'
			},{
				id: "edtAmount",
				label: "Amount",
				type: "text",
				class: "number"
			}
		],
		submit:{
			name: "btnAddPayment",
			caption: "Add payment" 
		}	
	} %%}
blocks}}
{{page
	{% dispatchers_panel %}
	
	{%% table: {
		data: $payments,
		title: '{ico}Money{/ico} Payments',
		wrappers: {
			dispatcher: "<a href=\"index.php?path=admin&page=user_activity&user={$value}\">{$value}</a>",
			amount: '${#value:2.#}',
			id: '<a href="{$path}&delete={$value}" onclick="return confirm(\'Are you sure?\');"><span class="glyphicon glyphicon-trash"></span></a>'
		}
	} %%}
	
	
page}}