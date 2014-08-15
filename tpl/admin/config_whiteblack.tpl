{= title: Black and white lists =}
{= path: "index.php?path=admin&page=config_whiteblack" =}
{% layout %}
{{page
	
	{% config_panel %}

	<table>
	<tr><td valign="top">
	<div class = "box">
		<h3>Whitelist ?$whitelist ({$whitelist}) $whitelist?</h3>
		<form action = ""  method = "post">
		<table>
		?$whitelist
			[$whitelist]
				<tr><td>{$value}</td><td><a href = "index.php?path=admin&page=config&o=del_whitelist&data={$value}">Delete</a></td></tr>
			[/$whitelist]
		$whitelist?
			<tr><td><input  class = "text"  name = "edtNewWhiteList"></td><td><input type = "submit" class="submit"  value = "Add" name = "btnAddWhiteList"></td></tr>
		</table>
		</form>
	</div>
	</td><td valign="top">
	<div class = "box">
		<h3>Blacklist ?$blacklist ({$blacklist}) $blacklist?</h3>
		<form action = ""  method = "post">
		<table>
		?$blacklist
			[$blacklist]
				<tr><td>{$value}</td><td><a href = "index.php?path=admin&page=config&o=del_blacklist&data={$value}">Delete</a></td></tr>
			[/$blacklist]
		$blacklist?
			<tr><td><input class = "text"  name = "edtNewBlackList"></td><td><input type = "submit" class="submit"  value = "Add" name = "btnAddBlackList"></td></tr>
		</table>
		</form>
	</div>
	</td></tr></table>
	
page}}