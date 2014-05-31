<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Ad details</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "?path=admin&page=ad" =}
	<div id = "page">
		<h1><a href = "?path=admin&page=dashboard">Apretaste!com</a> - <a href="?path=admin&page=ad">Ad details</a></h1>
		{% menu %}
		?$ad
		<h1><i>{$ad.title}</i> of <a href="?path=admin&page=user_activity&user={$ad.author}">{html:ad.author}</a></h1>
		<p>
			<table width="100%">
			[$ad]
			<tr><td width="250" align="right"><b>{$_key}:</b></td>
			<td> ?$value {$value} @else@ - $value? </td></tr>
			[/$ad]
			</table>
		</p>
		$ad?
	</div>
</body>
</html>