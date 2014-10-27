<div class="panel panel-default tooltips">
	<div class="panel-heading">
		{$title}
		(( {$id}-title-right ))
	</div>
	!$simple<div class="panel-body">$simple!
	?$body
		?$simple<div class="panel-body">$simple?
		{$body}
		<br/>
		?$simple</div>$simple?
	$body?
	
	!$id
		{{id (# uniqid() #) id}}
	@else@
		{{id {$id} id}}
	$id!
	
	<table id = "(( id ))" class="table table-condensed table-hover !$simple dataTables $simple!" ?$width width="{$width}" $width? >
	
	<thead>
	<tr>		
	<?
	
		if (!isset($columns)){
			$columns = array();
			if (is_array($data)) foreach($data as $k => $v){
				if (is_object($v)) 
					$v = get_object_vars($v);
				$columns = array_keys($v);
				break;
			}
		}
		
		if (isset($orders)) if ($orders==true) 
			echo "<th>#</th>";

		if (is_array($columns)) foreach ($columns as $field){
			if (!isset($hideColumns->$field)){
				echo '<th>';
				if (isset($headers->$field))
					echo $headers->$field;
				else
					echo ucfirst($field);
				echo '</th>';
			}
		}
		
		echo '</tr></thead><tbody>';
		
		$_order = 0;
		
		if (is_array($data)) foreach($data as $_key => $row){
			echo '<tr>';
			
			if (isset($orders)) if ($orders==true) 
				echo "<td>{$_order}</td>";
			
			if (!is_array($row)) $row = get_object_vars($row);
			$rkeys = array_keys($row);
			$xrow = array();
			$i = 0;
			
			foreach($columns as $col){
				if (isset($row[$col]))
					$xrow[$col] = $row[$col];
				else 
					if (isset($rkeys[$i]))
						if (isset($row[$rkeys[$i]]))
							$xrow[$col] =  $row[$rkeys[$i]]; 
				$i++;
			}
			
			if (is_array($row)) foreach($xrow as $field => $value){
				if (!isset($hideColumns->$field)){
					echo '<td valign="center">';
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
	</tbody>
	</table>
	!$simple </div> $simple!
	?$footer
	<div class="panel-footer">
		{$footer}
	</div>
	$footer?
</div>
{{onload
	!$simple
	$('#(( id ))').dataTable();
	$simple!
onload}}