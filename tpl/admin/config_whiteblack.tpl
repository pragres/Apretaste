{= title: Black and white lists =}
{= path: "index.php?path=admin&page=config_whiteblack" =}
{% layout %}

{{blocks
	{%% form-block: {
		title: "New white pattern",
		action: $path,
		fields: [
			{
				id: "edtNewWhiteList",
				label: "Pattern",
				type: "text",
			}
		],
		submit: {
			name: "btnAddWhiteList",
			caption: "Add"
		}
	} %%}
	<br/>
	{%% form-block: {
		title: "New black pattern",
		action: $path,
		fields: [
			{
				id: "edtNewBlackList",
				label: "Pattern",
				type: "text",
			}
		],
		submit: {
			name: "btnAddBlackList",
			caption: "Add"
		}
	} %%}
blocks}}
{{page

	<table width="100%">
	<tr><td valign="top" width="50%">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Whitelist ?$whitelist ({$whitelist}) $whitelist?</h3>
			</div>
			<div class="panel-body">
				<table class="table table-hover">
				?$whitelist
					[$whitelist]
						<tr><td>{$value}</td><td><a href = "{$path}&o=del_whitelist&data={$value}" onclick="return confirm('Are you sure?');"><span class="glyphicon glyphicon-trash"></span></a></td>
						</tr>
					[/$whitelist]
				$whitelist?
				</table>
			</div>
		</div>
	</td><td valign="top">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Blacklist ?$blacklist ({$blacklist}) @else@ (0) $blacklist?</h3>
			</div>
			<div class="panel-body">
				<table class="table table-hover">
				?$blacklist
					[$blacklist]
						<tr><td>{$value}</td><td><a href = "{$path}&o=del_blacklist&data={$value}"  onclick="return confirm('Are you sure?');"><span class="glyphicon glyphicon-trash"></span></a></td></tr>
					[/$blacklist]
				$blacklist?
				</table>
			</div>
		</div>
	</td></tr></table>
	
page}}