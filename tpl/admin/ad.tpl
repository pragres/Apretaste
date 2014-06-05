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
		<form metho="get" action="index.php">
			<input type="hidden" name = "path" value="admin">
			<input type="hidden" name = "page" value="ad">
			?$div.get.id
			Ad: <input class="text" name="id" value="{$div.get.id}">
			@else@
			Ad: <input class="text" name="id" value="">
			$div.get.id?
			<input style="padding:5px; border: 1px solid gray; cursor: pointer;" type="submit" value = "Show" name = "btnShowAd">
		</form> 
		?$ad
		<h1><i>{$ad.title}</i> of <a href="?path=admin&page=user_activity&user={$ad.author}">{html:ad.author}</a></h1>
		<p>
			<table width="100%">
			<!--{ [$ad]
			<tr><td width="250" align="right"><b>{$_key}:</b></td>
			<td> {$value} </td></tr>
			[/$ad] }-->
			</table>
		</p>
		@else@
			?$notfound
			<h1>Ad not found</h1>
			$notfound? 
		$ad?
	</div>
</body>
</html>