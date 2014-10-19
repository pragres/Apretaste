{= title: "Dictionary" =}
{= path: "?q=dictionary" =}
{% layout %}
{{page
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
		<input type = "submit" class="submit"  name="btnDelete"  style ="float:right;" value ="Delete"></a>
		</p>
		</form>
		[/$synonyms]
		@else@
		No synonyms<hr>
		$synonyms?
		<hr>
		
		<form action="{$path}" method="post">
		<fieldset>	<legend>New synonym or thesaurus:</legend>
			Word: <input name="word" class="text"> = Synonym: <input class="text" name="synonym">&nbsp;<input type="submit" class="submit"  value="Add" name="btnAdd">
			</fieldset>
		</form>
page}}