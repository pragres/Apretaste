{= title: "Agency" =}
{= pagewidth: 1024 =}
{= path: "index.php?path=admin&page=agency" =}

{% layout %}

{{page
	

	{% agency_panel %}
		
		?$div.get.customer_not_found
		<div class="msg-error">Customer not found</div>
		$div.get.customer_not_found? 	
		
		?$msgerror
		<div class="msg-error">{$msgerror}</div>
		$msgerror?
				
		
		!$div.get.section
		
		<form action="index.php?path=admin&page=agency_search_customer" method="POST">
		<p align="center">
		Insert part of the name, phone or email<br/>
		<input class="text" name="edtSearch"><input type="submit" value="Search" class="submit" name="btnSearch">
		</p>
		</form>
		
		?$searchresults
		
		&nbsp;
		[$searchresults]
			?$_is_first
			<table align="center" class="tabla"><tr><th>Name</th><th>Email</th><th>Phone</th><th>Last recharge</th></tr>
			$_is_first?
			
			<tr><td><a href="index.php?path=admin&page=agency_customer&id={$id}">{$full_name}</a></td><td>{$email}</td><td>{$phone}</td><td>?$last_recharge {$last_recharge} @else@ Never $last_recharge?</td></tr>
			
			?$_is_last
			</table>
			$_is_last?
		@empty@
		<!--{ Do nothing }-->
		[/$searchresults]
		
		<p align="center">
		Can't find the person in the list? <a class="button" href="index.php?path=admin&page=agency&section=add_customer">Add new customer</a>
		</p>
		$searchresults?
		
		
		
		@else@
		
		{?( "{$div.get.section}"=="add_customer" )?}
			{= pagewidth: 500 =}
			<table><tr><td valign="top"  style="padding: 10px;">
			<h1>New customer</h1>

		 	<form action="{$path}&page=agency_add_customer" method="POST">
		 	Full name: <br/>
			<input class="text" name ="edtName" ?$edtName value="{$edtName}" $edtName?><br/>
			Email:  <br/>
			<input class="text" name="edtEmail" ?$edtEmail value="{$edtEmail}" $edtEmail?><br/>
		 	Phone:  <br/>
			<input class="text" name="edtPhone" ?$edtPhone value="{$edtPhone}" $edtPhone?><br/>

			<input class="submit" type="submit" name="btnAddCustomer" value="Create new customer"> &nbsp; <a href="{$path}" class="button">Cancel</a></td>
		 	</form>
			</td>
			
			?$customer_exists
			[[customer_exists
			<td valign="top"  style="border-left: 2px solid black;padding: 10px;">
				<h1>Customer exists</h1>
				<table><tr>
				?$picture
				<td valign="top" style="padding:10px;">
				<img src="data:image/jpeg;base64,{$picture}" width="100">
				</td>
				$picture?
				<td valign="top">
				Full name: <br/><b>{$full_name}</b><br/><br/>
				Email: <br/><b>{$email}</b><br/><br/>
				?$phone Phone: <br/><b>{$phone}</b> $phone?<br/> 
				</td></tr></table>
				<a class ="button" href="index.php?path=admin&page=agency_customer&id={$id}">This is the customer?</a>
			</td>
			customer_exists]]
			@else@
			<td valign="middle" width="50%"  style="border-left: 2px solid black;padding: 10px;">
				<p>The fields name and email are required. We need the customer's email to send 
				them a confirmation once they shop. This information will be collected only 
				once in their lifetime.</p>
			</td>
			$customer_exists?
			</tr></table>
		{/?}
		$div.get.section!
		
		{% agency_footer %}
page}}