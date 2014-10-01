{= title: Agencies =}
{= path: "index.php?path=admin&page=config_agency" =}

{% layout %}

{{blocks
	{%% form-block: {
		action: "config_agency",
		title: "Adjust percents",
		fields: [
			{
				id: "edtProfit",
				value: "{$edtProfit}",
				label: "Sold",
				type: "text",
				class: "number"	,
				placeholder: "Type the sold %"				
			},{
				id: "edtResidualProfit",
				value: "{$edtResidualProfit}",
				type: "text",
				label: "Residual",
				class: "number",
				placeholder: "Type the residual %" 
			}
		],
		submit: {
			name: "Update agency",
			caption: "Update" 
		}
	} %%}
	<br/>
	{%% form-block: {
		action: "config_agency",
		title: "Agency percents",
		fields: [
			{
				id: "cboAgencyPercents",
				label: "Agency",
				type: "select",
				options: $agency_percents,
				value: '{$id}', 
				text: '{$name} ((# {$profit_percent} *100:2. #)% | (# {$residual_percent}*100:2.#)%)' 
			},
			{
				id: "edtAgencyProfitPercent",
				label: "Sold",
				type: "text",
				class: "number",
				placeholder: "Type the sold %",
				help: "The profit percent to give by agency"
			},{
				id: "edtAgencyResidualPercent",
				type: "text",
				label: "Residual",
				class: "number",
				placeholder: "Type the residual %" 
			}
		],
		submit: {
			name: "btnUpdateAgencyPercents",
			caption: "Update"
		}
	} %%}
blocks}}

{{page

	{%% table: {
		data: $agencies,
		title: "Agencies",
		hideColumns: {id: true, profit_percent: false, residual_percent: false, address: false},
		headers: {
			credit_line: "Credit",
			residual: "Residuals"			
		},
		wrappers: {
			credit_line: '${#value:2.#}',
			sold: '${#value:2.#}',
			residual: '${#value:2.#}',
			owe: '<a href="index.php?path=admin&page=config_agency_bill&agency={$id}" title="View the bill">${#value:2.#}</a>'
		}
	} %%}

	{%% form-block: {
		title: "New agency",
		modal: true,
		id: "newAgency",
		action: "index.php?path=admin&page=config_add_agency",
		fields: [
			{
				id: "edtName",
				type: "text",
				label: "Name"
			},{
				id: "edtPhone",
				type: "text",
				label: "Phone"
			},{
				id: "edtCreditLine",
				type: "text",
				class: "number",
				label: "Credit line"
			},{
				id: "edtAddress",
				type: "text",
				label: "Address"
			},{
				type: 'open_fieldset',
				legend: 'Adjust percents'				
			},{
				id: "edtProfitPercent",
				type: "text", 
				label: "Sold",
				class: "number"
			},{
				id: "edtResidualPercent",
				type: "text", 
				label: "Residual",
				class: "number"
			}
			
		], 
		submit:{
			caption: "Add",
			name: "btnAddAgency"
		}
	} %%}
page}}