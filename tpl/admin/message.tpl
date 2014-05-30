<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Message detail</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "?path=admin&page=message" =}
	<div id = "page">
		<h1><a href = "?path=admin&page=dashboard">Apretaste!com</a> - <a href="?path=admin&page=message">Message detail</a></h1>
		{% menu %}
		 
		?$message
		<p>
			<table width="100%">
			
			[$message]
			<tr><td width="250" align="right"><b>{$_key}:</b></td><td> ?$value {$value} @else@ unknown $value? </td></tr>
			[/$message]
			</table>
		</p>
		$message?
	</div>
</body>
</html>