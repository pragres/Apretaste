?$modal
<button type="button" class="btn btn-default" onclick="$('#{$id}-modal').modal('show');">{$title}</button>
<div class="modal fade tooltips" id="{$id}-modal" tabindex="-1" role="dialog" aria-labelledby="{$id}-label" aria-hidden="true"> 
	<div class="modal-dialog" style="width:{$width}px;"> 
		<div class="modal-content"> 
				<div class="modal-header"> 
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
					<h4 class="modal-title" id="{$id}-label">{$title}</h4>
				</div>
				<div class="modal-body"> 
@else@
<div class="panel panel-success tooltips" style="width: {$width}; margin: auto; ?$float float: {$float}; $float?">
	<div class="panel-heading">
		<h3 class="panel-title">{$title}</h3>
	</div>
	<div class="panel-body">
$modal?
		?$explanation
		<p>{$explanation}</p>
		$explanation?
		<form role="form" action = "?q={$action}" method = "?$method {$method} @else@ post $method?" id="{$id}" ?$enctype enctype="{$enctype}" $enctype?>
		?$alert
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &times; </button> 
			{$alert}
		</div>
		$alert?
		[$fields]
		<div class="form-group ?$addon input-group $addon?">
			?$label <label for="{$id}">{$label}</label> $label?
			
			{%% form-control-{$type}: $value %%}
					
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