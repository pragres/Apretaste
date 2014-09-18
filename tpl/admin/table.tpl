<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">{$title}</h3>
	</div>
	<div class="panel-body">
		<table ?$id id = "{$id}" $id? class="table table-hover table-condensed table-responsive" ?$width width="{$width}" $width? >
		<tr>
		?$orders <th>#</th> $orders? [$data.0] !$hideColumns.{$_key} <th>?$headers.{$_key} {$headers.{$_key}} @else@ {^_key} $headers.{$_key}?</th> $hideColumns.{$_key}! [/$data.0]
		</tr>
		[$data]
			<tr>
				?$orders <td>{$_order}</td> $orders? 
				[$data.{$_key}]
					!$hideColumns.{$_key}
					{?( '{$_key}' != '_key' && '{$_key}' != '_order' )?}
					<td>
						?$wrappers.{$_key}
							{$wrappers.{$_key}}
						@else@
							?$wrappers.*
								{$wrappers.*}
							@else@
								{$value}
							$wrappers.*?
						$wrappers.{$_key}?
					</td>
					{/?}
					$hideColumns.{$_key}!
				[/$data.{$_key}]
			</tr>
		[/$data]
		</table>
	</div>
</div>