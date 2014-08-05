{= title: "Message details" =}
{= path: "?path=admin&page=message" =}
{% layout %}

{{page
		?$message
		<p>
			<table width="100%">
			
			[$message]
			<tr><td width="250" align="right"><b>{$_key}:</b></td>
			<td> ?$value {$value} @else@ - $value? </td></tr>
			[/$message]
			</table>
		</p>
		$message?
page}}