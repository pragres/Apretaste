{= title: "Mailboxes" =}
{= path: "?path=admin&page=mailboxes" =}
{% layout %}
{{page
		<h1>Mailboxes</h1>
		<h2>Use of mailboxes (incomming messages)</h2>
		<table class="tabla">
		[$mbuse]
		<tr>
		<td valign="top" >{$servidor} <b>({$cant}) </b> </td>
		<td><div style="width:(# {$cant} / {$max:mbuse-cant} * 100 * 3:0 #)px;height: 20px; background: blue;"></div></td>
		</tr>
		[/$mbuse]
		</table>
		
		<h2>Shipments</h2>
		?$mailboxes
		<table class="tabla"><tr><th>Mailbox</th><th>Shipments</th><th>Last shipment</th><th>Last error</th></tr>
		[$mailboxes]
			<tr><td>{$mailbox}</td><td>{$shipments}</td><td>{$last_shipment_date:0,16}</td>
			<td>?$last_error {$last_error} - $last_error?  ?$last_error_date {$last_error_date:0,16} $last_error_date?</td><td><a href="{$path}&delete={$mailbox}">Delete</a></td></tr>
		[/$mailboxes]
		$mailboxes?
		</table>
		<form action="{$path}" method="post">
			<input class="text" name="mailbox"><input type="submit" name="btnAdd" value="Add">
		</form>
		<h1>Restrictions</h1>
		<table class="tabla"><tr><th>ID</th><th>From pattern</th><th>To pattern</th></tr>
		?$restrictions
			[$restrictions]
				<tr><td>{$id}</td><td>{$from_pattern}</td><td>{$to_pattern}</td><td><a href="{$path}&del_rest={$id}">Delete</a></td></tr>
			[/$restrictions]
		$restrictions?
		</table> 
		<form action="{$path}" method="post">
			New: From = <input class="text" name="from_pattern"> To = <input class="text" name="to_pattern">
			<input type="submit" name="btnAddPattern" value="Add">
		</form>
page}}