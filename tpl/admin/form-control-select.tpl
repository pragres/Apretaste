<select class="form-control" name="{$id}" id="{$id}">
	[$options]
	<option value="{$xvalue}" {?( "{$default}" == "{$xvalue}" )?} selected {/?}>{$xtext}</option>
	[/$options]			
</select>