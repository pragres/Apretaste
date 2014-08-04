{= title: Accusations =}
{= path: "?path=admin&page=accusations" =}
{% layout %}
	{{page
		
		?$accusations
		?$msg
			<div id = "message" class = "{$msg-type}">{$msg}</div>
		$msg?
		[$accusations]
		<strong>{^^^reason}</strong><br>
		{$fa}<br>
		({$announcement}) - <strong>{$title}</strong><br>
		<a href = "mailto:{$author}">{$author}</a> accused to <a href = "mailto:{$accused}">{$accused}</a><br/>
		<table><tr><td>
		<form action = "{$path}" method="post">
		<input type="hidden" value="{$id}" name="delete">
		<input type="submit" name="btnDelete" value ="Delete">
		</form></td><td>
		<form action = "{$path}" method="post">
		<input type="hidden" value="{$id}" name="proccess">
		<input type="submit" name="btnProccess" value ="Proccess">
		</form></td></tr></table><br/>
		<hr>
		[/$accusations]
		@else@
		They have not been carried out accusations
		$accusations?
page}}