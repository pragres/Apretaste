{= path: "?q=raffles_store" =}
{= title: "Raffles's store" =}

{% layout %}

{{headerdown

	{%% table: {
		data: $sales,
		title: 'Tickets for raffles!'
	} %%}
	<br/>
	{%% form-block: {
		id: "frmNewTicketSale",
		title: "New sale of tickets",
		modal: true,
		action: 'raffles_store',
		fields: [
			{
				id: "edtTitle",
				label: "Title",
				type: "text"			
			},{
				id: "edtDescription",
				label: "Description",
				type: "textarea"
			},{
				id: "edtPrice",
				label: "Price",
				type: "number"
			}			
		],
		submit: {
			caption: "Add",
			name: "btnAddSale"
		}
	} %%}
headerdown}}