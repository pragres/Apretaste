<div class="box">
	<table><tr>
	[$options]
	<td valign="bottom" class="panel-button">
		<a href="index.php?path=admin&page={$p}"><img src="static/icons/{$i}.png"><br/>{$d}</a>
	</td>
	[/$options]
	</tr></table>
</div>
?$msg
	<div id = "message" class = "{$msg-type}">{$msg}</div>
$msg?