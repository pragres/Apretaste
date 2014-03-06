<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Address list</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "index.php?path=admin&page=address_list" =}
	<div id = "page">
		<h1><a href = "{$WWW}admin">Apretaste!com</a> - <a href="{$path}">Address list</a></h1>
		{% menu %}
		<cite>Manage address list</cite>
		<hr>
		?$msg
			<div id = "message" class = "{$msg-type}">{$msg}</div>
		$msg?
		
		?$providers
		[$providers]
			{$provider} - <b>({$total})</b><br/>
		[/$providers]
		@else@
			No address 
		$providers?
		
		<!--{ download area }-->
		<form action="{$path}&download=true" method="post">
		<input type="submit" value="Download" name="btnDownload">
		</form>
		<br/>
		
		<form action="{$path}" method="post">
			<fieldset><legend>New emails:</legend>
			Addresses: <br/>
			<textarea rows="20" cols="100" name="address"></textarea>&nbsp;
			<br/><input type="submit" value="Add" name="btnAdd">
			</fieldset>
			
		</form>
		</div>
</body>
</html>