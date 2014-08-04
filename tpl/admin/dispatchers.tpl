{= title: "Dispatchers" =}
{= path: "index.php?path=admin&page=dispatchers" =}
{% layout %}
{{page
			<table class="tabla" width="100%">
				<tr><th>Email</th><th>Name</th><th>Contact Info</th><th colspan="2">Options</th></tr>
			[$dispatchers]
			<tr><td><a href="mailto:{$email}">{$email}</a></td><td>{$name}</td><td>{$contact}</td>
			<td><a href ="{$path}&sales={$email}">Sales({$sales})</a></td>
			<td><a href="{$path}&delete={$email}" onclick="return confirm('Are you sure?');">delete</a></td>
			</tr>
			[/$dispatchers]
			</table>
			<hr>
			<fieldset>
			<legend>New</legend>
			<form action="{$path}" method="post">
			Email:<br/> <input class="text" name="edtEmail"><br/> 
			Name: <br/><input class="text"  name="edtName"> <br/>
			Contact info: <br/><input class="text" name="edtContact"><br/> <br/>
			<input class="submit" type="submit" name="btnAddDispatcher" value="Add dispatcher">
			</form>
			</fieldset>
page}}