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
<div class="panel panel-success" style="width: {$width}; margin: auto; ?$float float: {$float}; $float?">
	<div class="panel-heading">
		<h3 class="panel-title">{$title}</h3>
	</div>
	<div class="panel-body">
$modal?
		?$explanation
		<p>{$explanation}</p>
		$explanation?
		<form role="form" action = "index.php?path=admin&page={$action}" method = "?$method {$method} @else@ post $method?" id="{$id}" ?$enctype enctype="{$enctype}" $enctype?>
		?$alert
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &times; </button> 
			{$alert}
		</div>
		$alert?
		[$fields]
		<div class="form-group ?$addon input-group $addon?">
			?$label <label for="{$id}">{$label}</label> $label?
			
			{= controls: {
				select: '<select class="form-control" name="{$id}" id="{$id}">
							[$options]
							<option value="{$value}" {?( "{$default}" == "{$value}" )?} selected {/?}>{$text}</option>
							[/$options]			
						</select>',
				multichecks: '<div class="panel panel-default" style="height: 300px; overflow: auto;">
							[$options]
							<input type="checkbox" name="{$id}[]" value="{$id}" class="checkbox" style="">{$text}<br/>
							[/$options]			
						</div>',
				textarea: '<textarea class="form-control" ?$rows rows="{$rows}" $rows? name="{$id}" id="{$id}" ?$placeholder placeholder="{$placeholder}" $placeholder? ?$help title="{$help}" $help?>?$value {$value} $value?</textarea>',
				text: '?$addon <span class="input-group-addon">{$addon}</span> $addon?
				<input type="text" class="form-control {$class}" name="{$id}" id="{$id}" ?$placeholder placeholder="{$placeholder}" $placeholder? ?$value value="{$value}" $value? ?$help title="{$help}" $help?>',
				number: '?$addon <span class="input-group-addon">{$addon}</span> $addon?
					<input type="text" class="form-control number {$class}" name="{$id}" id="{$id}" ?$placeholder placeholder="{$placeholder}" $placeholder? ?$value value="{$value}" $value? ?$help title="{$help}" $help?>',
				password: '<input type="password" class="form-control {$class}" name="{$id}" id="{$id}" ?$placeholder placeholder="{$placeholder}" $placeholder? ?$value value="{$value}" $value? ?$help title="{$help}" $help?>',
				hidden: '<input type="hidden" class="form-control {$class}" name="{$id}" id="{$id}" ?$placeholder placeholder="{$placeholder}" $placeholder? ?$value value="{$value}" $value? ?$help title="{$help}" $help?>',
				open_fieldset: '<fieldset><legend>{$legend}</legend>',
				close_fieldset: '</fieldset>',
				file: '<input type="file" name="{$id}" id = "{$id}" class="{$class}" ?$placeholder placeholder="{$placeholder}" $placeholder?>',
				
			} =}
			
			{$controls.{$type}}
			
		</div>
		[/$fields]
		?$modal
		</div>
		<div class="modal-footer"> 
			<button type="submit" name="{$submit.name}" class="btn btn-default">{$submit.caption}</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> 
		</div> 
		@else@
			?$submits
				[$submits]
					?$href
						<a href="{$href}" class="btn btn-default">{$caption}</a>
					@else@
						<button type="submit" name="{$name}" class="btn btn-default">{$caption}</button> &nbsp;
					$href?
				[/$submits]
			@else@
				<button type="submit" name="{$submit.name}" class="btn btn-default">{$submit.caption}</button>
			$submits?
		$modal?
		</form>
	</div>
</div>
?$modal </div> $modal?