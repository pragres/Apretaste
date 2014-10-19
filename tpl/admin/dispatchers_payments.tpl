{= path: "index.php?path=admin&page=dispatchers_payments" =}
{= title: "Dispatcher's payments" =}
{= pagewidth: 700 =}

{% layout %}
	
{{headerdown
	{% dispatchers_panel %}
	
	{%% table: {
		data: $payments,
		title: '{ico}money{/ico} Payments',
		headers: {id: ""},
		wrappers: {
			dispatcher: "<a href=\"index.php?path=admin&page=user_activity&user={$value}\">{$value}</a>",
			amount: '${#value:2.#}',
			id: '<a href="{$path}&delete={$value}" onclick="return confirm(\'Are you sure?\');"><span class="glyphicon glyphicon-trash"></span></a>'
		}
	} %%}
	
	{%% form-block: {
		action: "dispatchers_payments",
		title: "Add payment",
		modal: true,
		id: "addPayment",
		fields: [
			{
				id: "edtDispatcher",
				label: "Dispatcher",
				options: $dispatchers,
				xvalue: "{$email}",
				xtext: "{$name}",
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

headerdown}}