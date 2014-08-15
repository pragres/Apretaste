{= title: Configurations =}
{= path: "index.php?path=admin&page=config" =}
{% layout %}
{{page

	{% config_panel %}
	
	<div class = "box">
		<h3>Some configurations</h3>
		<form action = ""  method = "post">
		<input type = "checkbox" name = "chkEnableHistorial" ?$chkEnableHistorial checked $chkEnableHistorial?>Enable historial<br><br>
		<input type = "checkbox" name = "chkSmsFree" ?$chkSmsFree checked $chkSmsFree?>SMS Free<br><br>		
		Price RegExp: <br><input  class = "text regexp" type="text" name = "edtPriceRegExp" ?$edtPriceRegExp value ="{$edtPriceRegExp}" $edtPriceRegExp?><br><br>
		Phones RegExp: <br><input  class = "text regexp"  type="text" name = "edtPhonesRegExp" ?$edtPhonesRegExp value = "{$edtPhonesRegExp}" $edtPhonesRegExp?><br><br>
		Subscribes:<br>
		Outbox max messages: <input class="number" type ="text" name = "edtOutboxmax" ?$edtOutboxmax value = "{$edtOutboxmax}"><br>
		<input type = "submit" class="submit"  value = "Update" name = "btnUpdateConfig">
		</form>
	</div>
	
page}}