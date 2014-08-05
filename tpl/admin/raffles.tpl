{= title: "Raffles" =}
{= path: "?path=admin&page=raffles" =}
{% layout %}
{{page 
		?$raffles
			<table width="100%" class="tabla">
			<tr>
			<th></th>
			<th>ID</th><th>Description</th>
			<th>Date from</th><th>Date to</th><th>Active</th><th>Closed</th><th>Winners</th><th>Tickets</th><th></th></tr>
			[$raffles]
			<tr>
				<td><img width="50" src="data:image/jpg;base64,{$image}"></td>
				<td width="250" align="right"><b>{$id}</b></td>
				<td>{$description}</td>
				<td>{$date_from}</td>
				<td>{$date_to}</td>
				<td>{$active}</td>
				<td>{$closed}</td>
				<td>{$winners}</td>
				<td>{$tickets}</td>
				<td><a href="{$path}&delete={$id}">Delete</td>
			</tr>
			[/$raffles]
			</table>
		</p>
		$raffles?
		<hr/>
		<h2>New raffle</h2>
		<form action="{$path}&addraffle=true" method="post" enctype="multipart/form-data">
		Description: <input class="text" name="description">
		Date from: <input class="text" name="date_from" style="width: 150px;">
		Date to: <input class="text" name="date_to" style="width: 150px;"><br/>
		Image: <input type="file" name="image"><br/>
		<hr/>
		<input class="submit" type="submit" value="Add" name="btnAdd">
		</form>
page}}