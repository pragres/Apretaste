<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Agency </title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
		<script src="static/jquery.min.js" type="text/javascript"></script>
	</head>
<body>


	{= path: "index.php?path=admin&page=agency" =}
	
	<div id = "page">
		<h1><a href = "index.php?path=admin">Apretaste!com</a> - <a href="{$path}">Agency</a></h1>
		
		{% menu %}
		!$div.get.section
		<fieldset>
		<legend>Search for a customer</legend>
		<form action="{$path}&section=customers" method="POST">
		Name: <input class="text" name="edtSearchName"> Email: <input class="text" name="edtSearchEmail"> Phone: <input class="text" name="edtSearchPhone">
		</form>
		</fieldset>
		
		<a href="{$path}&section=add_customer">Add a new customer</a>
		
		@else@
		
		{?( "{$div.get.section}"=="add_customer" )?}
			<fieldset>
			<legend>New customer</legend>
		 	<form action="{$path}&section=add_customer">
		 	<table>
		 		<tr><td>Full name: </td><td><input class="text" name ="edtName"></td></tr>
		 		<tr><td>Email: </td><td><input class="text" name="edtEmail"></td></tr>
		 		<tr><td>Phone: </td><td><input class="text" name="edtPhone"></td></tr>
		 		<tr><td><a href="{$path}" class="submit">Cancel</a></td>
		 		<td><input class="submit" type="submit" name="btnAddCustomer" value="Add"></td></tr>
		 	</table>
		 	</form>
		 	</fieldset>
		{/?}
		$div.get.section!
		
</body>
</html>