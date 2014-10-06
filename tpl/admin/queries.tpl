{= path: "index.php?path=admin&page=queries" =}
{= title: "Database Query Tool" =}

{% layout %}

{{headerdown
	
	{%% form-block: {
		id: "frmQuery",
		action: $path,
		title: "Edit query",
		modal: $results,
		fields: [
			{
				type: "textarea",
				id: "edtQuery",
				label: "Query",
				value: $query
			}
		],
		submit: {
			name: "btnRun",
			caption: "Run"
		}
	} %%}
	
	<br/>
	
	?$results
		<div class="panel panel-success"> 
			<div class="panel-heading">Query</div> 
			<div class="panel-body">
				{html:query}
			</div>
		</div>
		<br/>
		{%% table: {
			title: "Results",
			data: $results
		} %%}
	$results?
	
	
	
	
headerdown}}