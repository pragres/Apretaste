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
	
	{%% form-block: {
		id: "frmSaveQuery",
		title: "Save query",
		action: "queries",
		modal: true,
		fields: [
			{
				type: "text",
				id: "edtTitle",
				label: "Title",
			},{
				type: "textarea",
				id: "edtQuery",
				value: $query,
				label: "Query"
			},{
				type: "text",
				id: "edtParams",
				label: "Params"
			}
		],
		submit: {
			name: "btnAdd",
			caption: "Add"
		}
	} %%}
	
	?$params
	{%% form-block: {
			title: 'Params',
			modal: true,
			action: "queries&run={$query_id}",
			fields: $params,
			submit: {
				caption: "Run",
				name: "run"
			}
	} %%}
	$params?
	<br/>
	
	?$results
		<div class="panel panel-success"> 
			<div class="panel-heading">Query</div> 
			<div class="panel-body">
				{html:query}
			</div>
		</div>
		<br/>
		
		<br/>
		{%% table: {
			title: $query_title,
			data: $results
		} %%}
	@else@
		?$queries
		{%% table: {
			data: $queries,
			title: "Queries",
			headers: {id: ""},
			wrappers: {
				id: '<a href="?q=queries&run={$id}"><span class="glyphicon glyphicon-cog"></span></a>'
			}
		} %%}
		$queries?
	$results?
	
	
	
	
headerdown}}