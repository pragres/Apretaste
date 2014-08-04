{= title: Tips =}
{= path: "tips" =}
{% layout %}
{{page
		?$msg
			<div id = "message" class = "{$msg-type}">{$msg}</div>
		$msg?
		?$tips
		[$tips]
		<p>{$tip}</p>
		<form action="tips" method="post">
		<input type="hidden" value ="{$id}" name="delete">
		<input class ="submit" type="submit" value ="Delete" name="btnDelete">
		</form>
		<hr>
		[/$tips]
		@else@
		No tips<hr>
		$tips?
		<form action="{$path}" method="post">
			New tip:<br/>
			<textarea rows="10" cols="80" name="tipText" style="resize:none"></textarea><br>
			<input class ="submit" type="submit" value="Add" name="btnAddTip">
		</form>
page}}