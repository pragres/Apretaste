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
		<h1><a href = "index.php?path=admin">Apretaste!com</a> - <a href="{$path}">Address list</a></h1>
		
		{% menu %}
				
		Download from: <a href="{$path}&download=true">All ({$total_address})</a> | 
		<a href="{$path}&download=true&filter=*.cu">Domain .cu</a> |  
		<a href="{$path}&download=true&filter=apretaste.public.announcement">Internal ads</a> | 
		<a href="{$path}&download=true&filter=apretaste.public.external_ads">External ads</a> |
		<a href="{$path}&download=true&filter=apretaste.public.invitations">Invitations</a> | 
		<a href="{$path}&download=true&filter=apretaste.public.external_ads">Guests</a> |
		<a href="{$path}&download=true&filter=apretaste.public.authors">Authors</a> |
		<a href="{$path}&download=true&filter=apretaste.public.messages">Messages</a> |
		<a href="{$path}&download=true&filter=apretaste.public.admin">Admin (manual inserts)</a>
		<hr/>
		Operations: <a href="{$path}&nourish=true">Nourish the list from all sources</a>
		<hr/>	
		<table>
			<tr>
			<?
			
			$i = 0;
			foreach ($providers as $p){
				$i++;
				echo '<td>';
				echo '<a href="index.php?path=admin&page=address_list&download=true&filter=@'.$p['provider'].'">';
				if ($p['national']) echo '<b>'.$p['provider'].'</b>'; else echo $p['provider']; 
				echo '</a>';
				echo ' <b>('.$p['total'].')</b></td>';
				if ($i % 4 == 0)
					echo '</tr><tr>';
			}
			?>
		</tr>
		</table>
		?$msg
			<div id = "message" class = "{$msg-type}">{$msg}</div>
		$msg?
		
		<!--{ download area }-->
		<hr/>
				
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