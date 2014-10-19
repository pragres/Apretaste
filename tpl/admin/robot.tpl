{= title: <span class="glyphicon glyphicon-send"></span> Simulator =}
{= path: "index.php?path=admin&page=robot" =}
{% layout %}

{{page
 ?$responses
  <h2>HTML Responses ({$responses})</h2>
 [$responses]
 	<h3>Response #{$_order}</h3>
 	To: <b><a href="index.php?path=admin&page=user_actitivy&user={$to}">{$to}</a><br/>
 	{$responseHTML}
 	<br/>
 	<hr/>
 @empty@
 No response
 [/$responses]
 $responses?
page}}

{{blocks
	?$logs
	<div class="panel panel-success" style="width: {$width}; margin: auto;">
		<div class="panel-heading">
			<h3 class="panel-title">Logs</h3>
		</div>
		<div class="panel-body">
			<div style="background:black;color:white;font-family:Lucida Console;padding:5px;">
			{br:logs}
			</div>
		</div>
	</div>
	$logs?
	<br/>
	{%% form-block: {
		id: "frmEmailClient",
		title: "<span class="glyphicon glyphicon-envelope"></span> &nbsp; Email client",
		action: 'robot',
		modal: $div.post.subject,
		fields: [
			{
				id: "from",
				type: "text",
				value: $div.post.from,
				label: "From",
				placeholder: "Type the simulated from address"
			},{
				id: "subject",
				type: "text",
				value: $div.post.subject,
				label: "Subject",
				placeholder: "Type the subject"
			},{
				id: "body",
				type: "textarea",
				value: $div.post.body,
				label: "Body",
				placeholder: "Type the body"
			}
		],
		submit: {
			caption: "Send",
			name: "btnSend"
		}
	} %%}
blocks}}