{= title: Keywords black list =}
{= path: "index.php?path=admin&page=config_keywords" =}
{% layout %}
{{page

	{% config_panel %}
	
	<div class = "box">
		<h3>Keywords blacklist ?$kwblacklist ({$kwblacklist}) $kwblacklist?</h3>
		<form action = ""  method = "post">
		<table width="100%">
			?$kwblacklist
			<tr>
			[$kwblacklist]
				<td><a href = "index.php?path=admin&page=config&o=del_kw_bl&data={$value}" title="Click to delete" >{$value}</a></td>
				{?( {$_order} % 3 == 0 )?}</tr> !$_is_last <tr> $_is_last!{/?}
			[/$kwblacklist]
			$kwblacklist?
			{?( {$_order} % 3 !== 0 )?}</tr>{/?}
		</table>
		<input class = "text" name = "edtNewBlackKeyword">
		<input type = "submit" class="submit"  value = "Add" name = "btnAddBlackKeyword">
		</form>
	</div>
page}}