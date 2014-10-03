{= path: "index.php?path=admin&page=config_agency_payments" =}
{= title: "Agency's payments" =}

{% layout %}

{{blocks
{%% form-block: {
	action: $path,
	title: "Filter by agency",
	fields: [
		{
			id: "cboAgency",
			type: "select",
			options: $agencies,
			value: '{$id}',
			text: '{$name}',
			label: "Agency",
			default: $filter.id
		}
	],
	submit: {
		caption: "Filter",
		name: "btnFitlerBy"
	}
} %%}
blocks}}

{{page

	
	{%% table: {
		data: $payments,
		hideColumns: {id: true, agency: true},
		title: "Payments of <i>{$filter.name}</i>",
		headers: {
			user_login: "Submitted by",
			moment: "Submitted date"			
		},
		wrappers: {
			amount: '${#amount:2.#}'
		}
	} %%}

	{%% form-block: {
		id: "newAgencyPayment",
		title: "New payment",
		modal: true,
		action: $path,
		fields: [
			{
				id: "cboAgency",
				type: "select",
				options: $agencies,
				value: '{$id}',
				text: '{$name}',
				label: "Agency"
			},{
				id: "edtAmount",
				type: "text",
				class: "number",
				label: "Amount"			
			},{
				id: "edtDate",
				type: "text",
				class: "datepicker",
				label: "Date"			
			}
		],
		submit: {
			caption: "Add",
			name: "btnNewPayment"
		}
	} %%}
	
page}}