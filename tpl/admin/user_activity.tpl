<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | User activity</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "?path=admin&page=user_activity" =}
	<div id = "page">
		<h1><a href = "?path=admin&page=dashboard">Apretaste!com</a> - <a href="?path=admin&page=user_activity">User activity</a></h1>
		{% menu %}
		 
		<form metho="get" action="index.php">
			<input type="hidden" name = "path" value="admin">
			<input type="hidden" name = "page" value="user_activity">
			?$div.get.user
			<input class="text" name="user" value="{$div.get.user}">
			@else@
			<input class="text" name="user" value="">
			$div.get.user?
			<input type="submit" value = "Show" name = "btnShowUser">
		</form> 
		
		?$client
			<h1>{$client.email}</h1>
			 Credit: ${$client.credit}
			 <h2>Last messages</h2>
			 ?$client.messages
			<table><tr><th>ID</th><th>Moment</th><th>Author</th><th>Command</th><th>Subject</th><th>Answers</th></tr>
			[$client.messages]
				<tr><td><a href="?path=admin&page=message&id={$id}">{$id}</a></td><td>{$moment}</td><td>{$author}</td>
				<td align="center">{$command}</td>
				<td align="center">{$subject}</td>
				<td>{?( {$answers} < 1 )?} <span style="color:red;">{$answers}</span> @else@ {$answers} {/?}</td></tr>
			[/$client.messages]
			</table>
			$client.messages? 
		$client? 
	</div>
</body>
</html>