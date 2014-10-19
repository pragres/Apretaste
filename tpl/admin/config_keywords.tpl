{= title: Keywords black list =}
{= path: "index.php?q=config_keywords" =}
{% layout %}

{{blocks
	{%% form-block:{
		title: "New black keyword",
		action: 'config_keywords',
		fields:[
			{
				id: "edtNewBlackKeyword",
				label: "Keyword:",
				type: "text"
			}
		],
		submit: {
			name: "btnAddBlackKeyword",
			caption: "Add" 
		}
	} %%}
	
	
blocks}}
{{page
	
<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">Keywords blacklist ?$kwblacklist ({$kwblacklist}) $kwblacklist?</h3>
	</div>
	<div class="panel-body">
		<table class="table table-hover">
			?$kwblacklist
			<tr>
			[$kwblacklist]
				<td><a href = "index.php?path=admin&page=config_keywords&o=del_kw_bl&data={$value}" title="Click to delete" onclick="return confirm('Are you sure?');" >{$value}</a></td>
				{?( {$_order} % 3 == 0 )?}</tr> !$_is_last <tr> $_is_last!{/?}
			[/$kwblacklist]
			$kwblacklist?
			{?( {$_order} % 3 !== 0 )?}</tr>{/?}
		</table>
	</div>
</div>
page}}