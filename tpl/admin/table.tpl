<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">{$title}</h3>
	</div>
	?$body
	<div class="panel-body">
		{$body}
	</div>
	$body?
	<table ?$id id = "{$id}" $id? class="table table-hover table-condensed table-responsive" ?$width width="{$width}" $width? >
	<tr>		
	<?
	
		if (!isset($columns)){
			$columns = array();
			foreach($data as $k => $v){
				if (is_object($v)) 
					$v = get_object_vars($v);
				$columns = array_keys($v);
				break;
			}
		}
		
		if (isset($orders)) if ($orders==true) 
			echo "<th>#</th>";

		foreach ($columns as $field){
			if (!isset($hideColumns->$field)){
				echo '<th>';
				if (isset($headers->$field))
					echo $headers->$field;
				else
					echo ucfirst($field);
				echo '</th>';
			}
		}
		
		echo '</tr>';
		
		$_order = 0;
		
		foreach($data as $_key => $row){
			echo '<tr>';
			
			if (isset($orders)) if ($orders==true) 
				echo "<td>{$_order}</td>";
			
			if (!is_array($row)) $row = get_object_vars($row);
			
			foreach($row as $field => $value){
				if (!isset($hideColumns->$field)){
					echo '<td>';
						if (isset($wrappers)){
							if (isset($wrappers->$field)){
								$row['value'] = $value;
								echo div($wrappers->$field, $row);
							}
							else echo $value;
						} else echo $value;
						
					echo '</td>';
				}
			}
			echo '</tr>';
		}
	?>
	</table>
	?$footer
	<div class="panel-footer">
		{$footer}
	</div>
	$footer?
</div>