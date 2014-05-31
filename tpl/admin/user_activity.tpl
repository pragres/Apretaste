<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | User activity</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "?path=admin&page=user_activity" =}
	<div id = "page">
		<h1><a href = "?path=admin&page=dashboard">Apretaste!com</a> - <a href="?path=admin&page=user_activity">User activity</a></h1>
		{% menu %}
		 <hr/>
		<form metho="get" action="index.php">
			<input type="hidden" name = "path" value="admin">
			<input type="hidden" name = "page" value="user_activity">
			?$div.get.user
			User: <input class="text" name="user" value="{$div.get.user}">
			@else@
			<input class="text" name="user" value="">
			$div.get.user?
			<input style="padding:5px; border: 1px solid gray; cursor: pointer;" type="submit" value = "Show" name = "btnShowUser">
		</form> 
		<hr>
		?$client
			<h1>Activity of {$client.email}</h1>
			
			 <fieldset style="background:green;color:white;font-weight:bold">Credit: ${$client.credit}</fieldset>
			 <h2>Last messages</h2>
			 ?$client.messages
			<table class="tabla"><tr><th width="200">ID</th><th>Moment</th><th>Command</th><th>Subject</th><th>Answers</th>
			<th>Answer date</th>
			<th>Answer sender</th>
			<th>Answer subject</th>
			</tr>
			[$client.messages]
				<tr><td style="font-family:Courier"><a href="?path=admin&page=message&id={$id}">{$id}</a></td>
				<td>{$moment:0,16}</td>
				<td align="center">{$command}</td>
				<td align="center">{$subject}</td>
				<td align="center">{?( {$answers} < 1 )?} <span style="color:red;">{$answers}</span> @else@ {$answers} {/?}</td>
				<td>{$answer_date:0,16}</td>
				<td>{$answer_sender}</td>
				<td>{$answer_subject}</td>
				</tr>
			[/$client.messages]
			</table>
			$client.messages?
			<hr>
			<h2>Ads</h2>
			?$client.ads
			<table width="100%" class="tabla">
			<tr><th width="200">ID</th><th>Title</th><th>Post date</th><th>Image</th></tr>
			[$client.ads]
			<tr><td style="font-family:Courier"><a href="?path=admin&page=ad&id={$id}">{$id}</a></td>
			<td>{$title}</td>
			<td>{$post_date}</td>
			<td>?$image Yes @else@ No $image?</td>
			</tr>
			[/$client.ads]
			</table>
			$client.ads?
			 
			 
			 ?$client.subscribes
			 <h2>Subscribes</h2>
			 	<table width="100%" class="tabla">	
			 	<tr><th width="200">ID</th><th>Phrase</th><th>Last shipment</th></tr>
			 	[$client.subscribes]
			 	<tr><td style="font-family:Courier">{$id}</td>
			 	<td>{$phrase}</td>
			 	<td>{$last_alert:0.16}</td>
			 	</tr>
			 	[/$client.subscribes]
			 	</table>
			 $client.subscribes? 
		$client? 
	</div>
</body>
</html>