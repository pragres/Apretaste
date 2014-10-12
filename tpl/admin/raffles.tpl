{= title: "Raffles" =}
{= path: "?path=admin&page=raffles" =}

{@ [true,'TRUE'] @}
{@ [false,'FALSE'] @}
{@ ["t","TRUE"] @}
{@ ['f','FALSE'] @}
{% layout %}
{{headerdown 
		?$raffles
			[$raffles]
				<img width="150" src="data:image/jpg;base64,{$image}" style="float:left;margin: 5px;">
				ID: <b>{$id}</b><br/>
				<p>{$description}</p>
				From: {$date_from} to  {$date_to}<br/>
				Active: {$active} Closed: {$closed} <br/>
				Winners: {$winners}<br/>
				Tickets: {$tickets}<br/>
				!$winners
				<a href="{$path}&delete={$id}" onclick="return confirm('Are you sure?');">Delete</a>
				$winners!
				<hr/>
			[/$raffles]
		$raffles?
		
		<br/>
		
		{%% form-block: {
			id: "frmNewRaffle",
			title: "New raffle",
			action: "{$path}&addraffle=true",
			enctype: "multipart/form-data",
			modal: true,
			fields: [
				{
					id: "description",
					label: "Description",
					type: "textarea"					
				},{
					id: "date_from",
					label: "Date from",
					type: "text",
					value: "{/div.now:Y-m-d/}"
				},{
					id: "date_to",
					label: "Date to",
					type: "text"					
				},{
					id: "image",
					label: "Image",
					type: "file"					
				}
			],
			submit: {
				caption: "Add",
				name: "btnAdd"
			}
		} %%}
		
headerdown}}