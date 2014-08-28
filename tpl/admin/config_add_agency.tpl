{= path: "index.php?path=admin&page=config_add_agency" =}
{= title: New agency =}
{= pagewidth: 600 =}
{% layout %}

{{page
	{% config_panel %}
	<h2>New agency</h2>
	<form action="{$path}" method="post">
		Name: <br/>
		<input class= "text" name="edtName"><br/>
		Phone: <br/>
		<input class="text" name="edtPhone"><br/>
		Credit line: <br/>
		<input class="number" name="edtCreditLine"><br/>
		Address: <br/>
		<input class="text" name="edtAddress"><br/>
		<fieldset>
			<legend>Adjust percents</legend>
			Sold: <input class="number" name="edtProfitPercent"> Residual: <input class="number" name="edtResidualPercent">
		</fieldset>
		<input class="submit" type="submit" name="btnAddAgency" value="Add"> &nbsp;
		<a class="button" href="index.php?path=admin&page=config_agency">Cancel</a>
	</form>
page}}
