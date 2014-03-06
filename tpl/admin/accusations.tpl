<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Accusations</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "?path=admin&page=accusations" =}
	<div id = "page">
		<h1><a href = "?page=accusations">Apretaste!com</a> - <a href="?page=accusations">Accusations</a></h1>
		{% menu %}
		?$accusations
		?$msg
			<div id = "message" class = "{$msg-type}">{$msg}</div>
		$msg?
		[$accusations]
		<strong>{^^^reason}</strong><br>
		{$fa}<br>
		({$announcement}) - <strong>{$title}</strong><br>
		<a href = "mailto:{$author}">{$author}</a> accused to <a href = "mailto:{$accused}">{$accused}</a><br/>
		<table><tr><td>
		<form action = "{$path}" method="post">
		<input type="hidden" value="{$id}" name="delete">
		<input type="submit" name="btnDelete" value ="Delete">
		</form></td><td>
		<form action = "{$path}" method="post">
		<input type="hidden" value="{$id}" name="proccess">
		<input type="submit" name="btnProccess" value ="Proccess">
		</form></td></tr></table><br/>
		<hr>
		[/$accusations]
		@else@
		They have not been carried out accusations
		$accusations?
	</div>
</body>
</html>
