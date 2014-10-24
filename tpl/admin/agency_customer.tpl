{= title: "Customer" =}
{= path: "?q=agency_customer" =}
{= pagewidth: 1024 =}
{% layout %}

{{blocks
	{%% form-block: {
		title: "Customer details",
		action: "agency_customer&id={$customer.id}&update=true",
		explanation: '<img src="data:image/jpeg;base64,{$customer.picture}" width="100">',
		fields: [
			{
				type: "text",
				id: "edtName",
				value: $customer.full_name
			},{
				type: "text",
				id: "edtEmail",
				value: $customer.email,
				addon: '@'
			},{
				type: "text",
				id: "edtPhone",
				value: $customer.phone,
				addon: '<span class="glyphicon glyphicon-earphone"></span>'
			}			
		],
		submit: {
			caption: "Update",
			name: "btnUpdateCustomer"
		}
	} %%}

blocks}}

{{page 
		
	?$customer.contacts
		{%% table: {
			id: "table_existing_contacts",
			title: "Existing contacts",
			data: $customer.contacts,
			columns: ["picture","name","email","credit"],
			headers: {
				picture: "",
				credit: 'Credit</th><th></th>'
			},
			wrappers: {
				picture: '<img src="data:image/jpeg;base64,{$picture}" width="50" height="50">',
				credit: '${#credit:2,0#}</td><td><form action="index.php?path=admin&page=agency_pre_recharge" method="POST">
						<input type="hidden" value = "{$div.get.id}" name="edtCustomer">
						<input type="hidden" value ="{$email}" name="edtEmail">	
						<input class="form-control" size="2" class="number float" style="width: 50px;" name="edtAmount" value =""> &nbsp;
						<input name="btnRecharge" type="submit" value="Recharge" class="submit btn btn-default">
						
					</form></td>'				
			}
		} %%}
	$customer.contacts?
	
	{%% form-block: {
		id: "newContact",
		title: "New contact",
		action: "agency_pre_recharge",
		modal: true,
		fields:[
			{
				type: "hidden",
				id: "edtCustomer",
				value: $div.get.id				
			},{
				id: "edtEmail",
				label: "Email",
				type: "text"
			},{
				type: "text",
				class: "number",
				label: "Amonut",
				id: "edtAmount"
			}
		],
		submit: {
			caption: "Recharge",
			name: "btnRecharge"
		}
	} %%}
	
	{% agency_footer %}
page}}