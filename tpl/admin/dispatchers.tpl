<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Dispatchers</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
		{= path: "index.php?path=admin&page=dispatchers" =}
	
	<div id = "page">
		<h1><a href = "index.php?path=admin">Apretaste!com</a> - <a href="{$path}">Dispatchers</a></h1>
		
		{% menu %}
				
			<table class="tabla" width="100%">
				<tr><th>Email</th><th>Name</th><th>Contact Info</th><th colspan="2">Options</th></tr>
			[$dispatchers]
			<tr><td><a href="mailto:{$email}">{$email}</a></td><td>{$name}</td><td>{$contact}</td>
			<td><a href ="{$path}&sales={$email}">Sales({$sales})</a></td>
			<td><a href="{$path}&delete={$email}" onclick="return confirm('Are you sure?');">delete</a></td>
			</tr>
			[/$dispatchers]
			</table>
			<hr>
			
			<form action="{$path}" method="post">
			Email: <input class="edit" name="edtEmail"> 
			Name: <input class="edit"  name="edtName"> 
			Contact info: <input class="edit" name="edtContact"> 
			<input type="submit" name="btnAddDispatcher" value="Add dispatcher">
			</form>
	</div>
</body>
</html>