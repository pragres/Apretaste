<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | Dictionary</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "" =}
	<div id = "page">
		<h1><a href = "{$WWW}admin">Apretaste!com</a> - <a href="synonyms">Dictionary</a></h1>
		{% menu %}
		<cite>Manage synonyms and thesaurus</cite>
		<hr>
		?$msg
			<div id = "message" class = "{$msg-type}">{$msg}</div>
		$msg?
		
		?$synonyms
		[$synonyms]
		<form action="{$path}" method="post">
		<p>{$word} = {$synonym}
		<input type ="hidden" name="delete" value = "{$id}">
		<input type = "submit" name="btnDelete"  style ="float:right;" value ="Delete"></a>
		</p>
		</form>
		[/$synonyms]
		@else@
		No synonyms<hr>
		$synonyms?
		<hr>
		
		<form action="{$path}" method="post">
		<fieldset>	<legend>New synonym or thesaurus:</legend>
			Word: <input name="word"> = Synonym: <input name="synonym">&nbsp;<input type="submit" value="Add" name="btnAdd">
			</fieldset>
		</form>
		</div>
</body>
</html>