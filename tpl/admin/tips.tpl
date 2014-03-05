<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Tips</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "tips" =}
	<div id = "page">
		<h1><a href = "{$WWW}admin">Apretaste!com</a> - <a href="tips">Tips</a></h1>
		{% menu %}
		?$msg
			<div id = "message" class = "{$msg-type}">{$msg}</div>
		$msg?
		?$tips
		[$tips]
		<p>{$tip}</p>
		<form action="tips" method="post">
		<input type="hidden" value ="{$id}" name="delete">
		<input type="submit" value ="Delete" name="btnDelete">
		</form>
		<hr>
		[/$tips]
		@else@
		No tips<hr>
		$tips?
		<form action="{$path}" method="post">
			New tip:<br/>
			<textarea rows="10" cols="80" name="tipText" style="resize:none"></textarea><br>
			<input type="submit" value="Add" name="btnAddTip">
		</form>
		</div>
</body>
</html>
