{= title: Configurations =}
{= path: "index.php?q=config" =}
{% layout %}
{{headerdown
<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">General options</h3>
	</div>
	<div class="panel-body">
		
		<form role="form" action = "{$path}"  method = "post">
			<fieldset>
				<legend>Classified service</legend>
				<div class="checkbox">
					<label><input type = "checkbox" name = "chkEnableHistorial" ?$chkEnableHistorial checked $chkEnableHistorial?>Enable historial</label> 
				</div>
				<div class="form-group">	
					<label for="edtPriceRegExp">Price regular expression:</label>
					<input class="form-control" type="text" id="edtPriceRegExp" name = "edtPriceRegExp" ?$edtPriceRegExp value ="{$edtPriceRegExp}" $edtPriceRegExp?/>
				</div>
				<div class="form-group">
					<label for="edtPriceRegExp">Phones regular expression:</label>
					<input class="form-control" type="text" name = "edtPhonesRegExp" id = "edtPhonesRegExp" ?$edtPhonesRegExp value = "{$edtPhonesRegExp}" $edtPhonesRegExp?/>
				</div>
				<div class="form-group">
					<label for="edtPriceRegExp">Max messages in outbox's alerts:</label>
					<input class="form-control" size="3" style="width: 100px;" type ="number" name = "edtOutboxmax" ?$edtOutboxmax value = "{$edtOutboxmax}"><br>
				</div>
			</fieldset>
			<fieldset>
				<legend>Comunications</legend>
				<div class="checkbox">
					<label><input type = "checkbox" name = "chkSmsFree" ?$chkSmsFree checked $chkSmsFree?>SMS Free</label>
				</div>
			</fieldset>
			<input type = "submit" class="btn btn-default" value = "Update" name = "btnUpdateConfig">
		</form>	
	</div>
</div>
headerdown}}