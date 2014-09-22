?$modal
<button type="button" class="btn btn-default" onclick="$('#{$id}-modal').modal('show');">{$title}</button>
<div class="modal fade" id="{$id}-modal" tabindex="-1" role="dialog" aria-labelledby="{$id}-label" aria-hidden="true"> 
	<div class="modal-dialog" style="width:{$width}px;"> 
		<div class="modal-content"> 
				<div class="modal-header"> 
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
					<h4 class="modal-title" id="{$id}-label">{$title}</h4>
				</div>
				<div class="modal-body"> 
@else@
<div class="panel panel-success" style="width: {$width}; margin: auto;">
	<div class="panel-heading">
		<h3 class="panel-title">{$title}</h3>
	</div>
	<div class="panel-body">
$modal?
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
				{?( "{$type}" == "textarea" )?}
				<textarea class="form-control" ?$rows rows="{$rows}" $rows? name="{$id}" id="{$id}" ?$placeholder placeholder="{$placeholder}" $placeholder? ?$help title="{$help}" $help?>?$value {$value} $value?</textarea>
				@else@
				<input type="{$type}" class="form-control {$class}" name="{$id}" id="{$id}" ?$placeholder placeholder="{$placeholder}" $placeholder? ?$value value="{$value}" $value? ?$help title="{$help}" $help?>
				{/?}
			{/?}
		</div>
		[/$fields]
		?$modal
		</div>
		<div class="modal-footer"> 
			<button type="submit" name="{$submit.name}" class="btn btn-default">{$submit.caption}</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> 
		</div> 
		@else@
		<button type="submit" name="{$submit.name}" class="btn btn-default">{$submit.caption}</button>
		$modal?
		</form>
	</div>
</div>
?$modal </div> $modal?