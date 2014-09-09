{= width: 500 =}
<table class="tabla" width="{$width}">
<tr>
?$orders <th>#</th> $orders? [${$data}.0]<th>{^_key}</th>[/${$data}.0]
</tr>
[${$data}]
	<tr>
		?$orders <td>{$_order}</td> $orders? 
		[${$data}.{$_key}]
			{?( '{$_key}' != '_key' )?}
			<td>
				?$wrappers.{$_key}
					{$wrappers.{$_key}}
				@else@
					{$value}
				$wrappers.{$_key}?
			</td>
			{/?}
		[/${$data}.{$_key}]
	</tr>
[/${$data}]
</table>