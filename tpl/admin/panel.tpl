<div class="box">
	<table><tr>
	[$options]
	<td valign="bottom" class="panel-button">
		<a onclick="$(this).highlight();" href="index.php?path=admin&page={$p}"><img src="static/icons/{$i}.png"><br/>{$d}</a>
	</td>
	[/$options]
	</tr></table>
</div>
?$msg
	<div id = "message" class = "{$msg-type}" style="vertical-align:center;">
	<table width="100%">
		<tr>
			<td width="50"><img src="static/icons/{$msg-type}.png"></td>
			<td>{$msg}</td>
			<td width="10"><a onclick="$('#message').fadeOut();" style="cursor:pointer;">x</a></td>
		</tr>
	</table>
	</div>
$msg?