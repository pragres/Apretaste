{= title: Ads by day =}
{= path: index.php?path=admin&page=ads_by_day =}
{% layout %}

<table class="tabla" align="center">
<tr><th rowspan="2">Date</th>
<th rowspan="2">Internals</th>
<th rowspan="2">Externals</th>
<th rowspan="2">Authors</th>
<th colspan="8">Messages relative to ads</th></tr>
<tr><th>INSERT</th>
	<th>UPDATE</th><th>DELETE</th><th>SEARCH</th><th>GET</th><th>Others</th><th>Total</th><th>Remittent</th></tr>
[$ads_by_day]
	<tr>
	<td align="center">{$fecha}</td>
	<td align="center">{$internos}</td>
	<td align="center">{$externos}</td>
	<td align="center">{$authors}</td>
	<td align="center">{$insert_messages}</td>
	<td align="center">{$update_messages}</td>
	<td align="center">{$delete_messages}</td>
	<td align="center">{$search_messages}</td>
	<td align="center">{$get_messages}</td>
	<td align="center">(# {$messages} - {$insert_messages} - {$update_messages} - {$delete_messages} - {$search_messages} - {$get_messages} #)</td>
	<td align="center">{$messages}</td>
	<td align="center">{$remittent}</td>
	</tr>
[/$ads_by_day]
</table>
