{= title: "Agency" =}
{% layout %}
{{page
	{= path: "index.php?path=admin&page=agency" =}
			
		!$div.get.section
		<fieldset>
		<legend>Search for a customer</legend>
		<form action="index.php?path=admin&page=agency_search_customer" method="POST">
		Name: <input class="text" name="edtSearchName">
		Email: <input class="text" name="edtSearchEmail">
		Phone: <input class="text" name="edtSearchPhone">
		<input type="submit" value="Search" class="submit" name="edtSearch">
		</form>
		</fieldset>
		
		<a href="{$path}&section=add_customer">Add a new customer</a>
		
		@else@
		
		{?( "{$div.get.section}"=="add_customer" )?}
			<fieldset>
			<legend>New customer</legend>
		 	<form action="{$path}&page=agency_add_customer" method="POST">
		 	<table>
		 		<tr><td>Full name: </td><td><input class="text" name ="edtName"></td></tr>
		 		<tr><td>Email: </td><td><input class="text" name="edtEmail"></td></tr>
		 		<tr><td>Phone: </td><td><input class="text" name="edtPhone"></td></tr>
		 		<tr><td><a href="{$path}" class="submit">Cancel</a></td>
		 		<td><input class="submit" type="submit" name="btnAddCustomer" value="Add"></td></tr>
		 	</table>
		 	</form>
		 	</fieldset>
		{/?}
		$div.get.section!
page}}