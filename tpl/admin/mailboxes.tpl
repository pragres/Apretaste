<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Mailboxes</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "?path=admin&page=mailboxes" =}
	<div id = "page">
		<h1><a href = "?path=admin&page=dashboard">Apretaste!com</a> - <a href="?path=admin&page=mailboxes">Mailboxes</a></h1>
		{% menu %}
		<h1>Mailboxes</h1>
		?$mailboxes
		<table class="tabla"><tr><th>Mailbox</th><th>Shipments</th><th>Last shipment</th><th>Last error</th></tr>
		[$mailboxes]
			<tr><td>{$mailbox}</td><td>{$shipments}</td><td>{$last_shipment_date:0,16}</td>
			<td>{$last_error} - {$last_error_date:0,16}</td><td><a href="{$path}&delete={$mailbox}">Delete</a></td></tr>
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
	</div>
</body>
</html>