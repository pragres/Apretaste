<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Recharge Cards</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
		{= path: "index.php?path=admin&page=dispatchers&sales={$email}&cards={$sale}" =}
	
	<div id = "page">
		<h1><a href = "index.php?path=admin">Apretaste!com</a> - <a href="{$path}">Recharge Cards</a></h1>
		
		{% menu %}
			<a href="index.php?path=admin&page=dispatchers&sales={$email}">&lt;&lt; Sales</a><br/>
			<table class="tabla" width="100%">
				<tr><th>Code</th><th>Amount</th><th>User</th><th>Recharge date</th></tr>
			[$cards]
			<tr>
			<td align="center">{$code:0,4}&nbsp;{$code:4,4}&nbsp;{$code:8,4}&nbsp;</td>
			<td align="center">${#amount:2.#}</td>
			<td align="center">?$email <a href="index.php?path=admin&page=user_activity&user={$email}">{$email}</a> @else@ - still - $email?</td>
			<td align="center">?$recharge_date {$recharge_date} @else@ - still -$recharge_date?</td>
			</tr>
			[/$cards]
			<tr ><td align="right">Total</td>
			<td  align="center" style="border-top:2px solid gray;padding-top:3px;">$(# {$sum:cards-amount} :2.#)</td></tr>
			</table>
			
	</div>
</body>
</html>