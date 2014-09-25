{= title: "Agency" =}
{= pagewidth: 1024 =}
{= path: "index.php?path=admin&page=agency" =}

{% layout %}

{{blocks
	{%% form-block: {
		action: $path,
		title: "Search customer",
		explanation: "Insert part of the name, phone or email",
		fields: [
			{
				id: "edtSearch",
				placeholder: "Type search phrase here",
				type: "text",
				addon: '<i class="fa fa-search"></i>'
			}
		],
		submit: {
			caption: 'Search',
			name: "btnSearch"
		}
	} %%}
blocks}}

{{page
			?$searchresults
			{%% table: {
				data: $searchresults,
				title: "Customers",
				hideColumns: {id: true, date_registered: true},
				headers: {full_name: "Name", last_recharge: "Last recharge", picture: ""},
				wrappers: {
					picture: '<img src="data:image/jpeg;base64,{$picture}" width="50">',
					full_name: '<a href="index.php?path=admin&page=agency_customer&id={$id}">{$full_name}</a>',
					last_recharge: '?$last_recharge {$last_recharge} @else@ Never $last_recharge?'
				}
			} %%}
			$searchresults?	
			
			?$div.post.edtSearch
			<p align="center">
			Can't find the person ?$searchresults in the list $searchresults? ? 
			
			{%% form-block: {
				id: "new_customer",
				title: "New customer",
				action: "{$path}&page=agency_add_customer" ,
				modal: true,
				width: 400,
				fields: [
					{
						id: "edtName",
						label: "Full name",
						type: "text"
					},{
						id: "edtEmail",
						label: "Email",
						type: text
					},{
						id: "edtPhone",
						label: "Phone",
						type: text
					}
				],
				submit: {
					caption: "Create new customer",
					name: 
				},
				explanation: "The fields name and email are required. We need the customer's email to send them a confirmation once they shop. This information will be collected only once in their lifetime."
			} %%}
			</p>
			$div.post.edtSearch?
		
		
		{% agency_footer %}
page}}


			
			?$customer_exists
			[[customer_exists

				<h1>Customer exists</h1>
				<table><tr>
				?$picture
				<td valign="top" style="padding:10px;">
				<img src="data:image/jpeg;base64,{$picture}" width="100">
				</td>
				$picture?
				<td valign="top">
				Full name: <br/><b>{$full_name}</b><br/><br/>
				Email: <br/><b>{$email}</b><br/><br/>
				?$phone Phone: <br/><b>{$phone}</b> $phone?<br/> 
				</td></tr></table>
				<a class ="button" href="index.php?path=admin&page=agency_customer&id={$id}">This is the customer?</a>

			customer_exists]]
			$customer_exists?

