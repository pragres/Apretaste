{= title: <span class="glyphicon glyphicon-send"></span> Simulator =}
{= path: "index.php?path=admin&page=robot" =}
{% layout %}

{{page
 ?$responses
  <h2>HTML Responses ({$responses})</h2>
 [$responses]
 	<h3>Response #{$_order}</h3>
 	To: <b><a href="index.php?path=admin&page=user_actitivy&user={$to}">{$to}</a><br/>
	{= space10: <div class="space_10">&nbsp;</div> =}
	{= space15: <div class="space_15" style="margin-bottom: 15px;">&nbsp;</div> =}
	{= space30: <div class="space_30" style="margin-bottom: 30px;">&nbsp;</div> =}
	{= separatorLinks: <span class="separador-links" style="color: #A03E3B;">&nbsp;|&nbsp;</span> =}
	{= hr: <hr style="border:1px solid #D0D0D0; margin:0px;"/> =}
	{= h1: <div class="header_1"><font size="5" face="Arial" color="#52B439"><b> =}
	{= _h1: </b></font><hr style="border:1px solid #D0D0D0; margin:0px;"/><font size="1" color="white"><div>&nbsp;</div></font></div> =}
	{= h2: <div class="header_2"><font size="4" face="Arial" color="#52B439"><b> =}
	{= _h2: </b></font><hr style="border:1px solid #D0D0D0; margin:0px;"/><font size="1" color="white"><div>&nbsp;</div></font></div> =}
	{= p: <div class="paragraph" style="text-align: justify;"><div style="color:#444444;"> =}
	{= _p: </div><font size="2" color="white"><div>&nbsp;</div></font></div> =}
	{= br: <font class="space_small" size="2" color="white"><div>&nbsp;</div></font> =}
	{= br2: <font class="space_medium" size="5" color="white"><div>&nbsp;</div></font> =}
	{= br3: <font class="space_big" size="7" color="white"><div>&nbsp;</div></font> =}
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
			},{
				id: "chkRealSend",
				type: "checkbox",
				label: "Real send"
			}
		],
		submit: {
			caption: "Send",
			name: "btnSend"
		}
	} %%}
blocks}}