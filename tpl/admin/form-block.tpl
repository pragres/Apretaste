<div class="panel panel-success" style="width: {$width}; margin: auto;">
	<div class="panel-heading">
		<h3 class="panel-title">{$title}</h3>
	</div>
	<div class="panel-body">
		<form role="form" action = "index.php?path=admin&page={$action}" method = "post" id="{$id}">
		?$alert
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &times; </button> 
			{$alert}
		</div>
		$alert?
		[$fields]
		<div class="form-group">	
			<label for="{$id}">{$label}</label>
			{?( "{$type}" == "select" )?}
			<select class="form-control" name="{$id}" id="{$id}">
				[$options]
				<option value="{$value}">{$text}</option>
				[/$options]			
			</select>
			@else@
			<input type="{$type}" class="form-control {$class}" name="{$id}" id="{$id}" ?$placeholder placeholder="{$placeholder}" $placeholder? ?$value value="{$value}" $value? ?$help title="{$help}" $help?>
			{/?}
		</div>
		[/$fields]
		<button type="submit" name="{$submit.name}" class="btn btn-default">{$submit.caption}</button>
		</form>
	</div>
</div>
      