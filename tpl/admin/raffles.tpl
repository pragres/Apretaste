<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Raffles</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "?path=admin&page=raffles" =}
	<div id = "page">
		<h1><a href = "?path=admin&page=dashboard">Apretaste!com</a> - <a href="?path=admin&page=raffles">Raffles</a></h1>
		{% menu %}
		?$raffles
			<table width="100%" class="tabla">
			<tr>
			<th></th>
			<th>ID</th><th>Description</th>
			<th>Date from</th><th>Date to</th><th>Active</th><th>Closed</th></tr>
			[$raffles]
			<tr>
				<td><img width="50" src="data:image/jpg;base64,{$image}"></td>
				<td width="250" align="right"><b>{$id}</b></td>
				<td>{$description}</td>
				<td>{$date_from}</td>
				<td>{$date_to}</td>
				<td>{$active}</td>
				<td>{$closed}</td>
				<td><a href="{$path}&delete={$id}">Delete</td>
			</tr>
			[/$raffles]
			</table>
		</p>
		$raffles?
		<hr/>
		<h2>New raffle</h2>
		<form action="{$path}&addraffle=true" method="post" enctype="multipart/form-data">
		Description: <input class="text" name="description">
		Date from: <input class="text" name="date_from" style="width: 150px;">
		Date to: <input class="text" name="date_to" style="width: 150px;"><br/>
		Image: <input type="file" name="image"><br/>
		<hr/>
		<input type="submit" value="Add" name="btnAdd">
		</form>
	</div>
</body>
</html>