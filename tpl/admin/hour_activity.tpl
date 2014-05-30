<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Hour activity</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "?path=admin&page=hour_activity" =}
	<div id = "page">
		<h1><a href = "?path=admin&page=dashboard">Apretaste!com</a> - <a href="?path=admin&page=hour_activity">Hour activity</a></h1>
		{% menu %}
		<h2>Day {$date}, hour {$hour}, {$messages} messages</h2> 
		?$messages
			<table class="tabla"><tr><th>ID</th><th>Moment</th><th>Author</th><th>Command</th><th>Subject</th><th>Answers</th>
			<th>Answer date</th>
			<th>Answer sender</th>
			<th>Answer subject</th>
			</tr>
		[$messages]
			<tr><td><a href="?path=admin&page=message&id={$id}">{$id}</a></td>
			<td>{$moment:10,6}</td><td><a href="?path=admin&page=user_activity&user={$author}">{$author}</a></td>
			<td align="center">{$command}</td>
			<td align="center">{$subject}</td>
			<td align="center">{?( {$answers} < 1 )?} <span style="color:red;">{$answers}</span> @else@ {$answers} {/?}</td>
				<td>{$answer_date:10,6}</td>
				<td>{$answer_sender}</td>
				<td>{$answer_subject}</td>
				</tr>
		[/$messages]
		</table>
		$messages?
	</div>
</body>
</html>