{= title: "Raffles" =}
{= path: "?path=admin&page=raffles" =}
{% layout %}
{{page 
		?$raffles
			[$raffles]
				<img width="150" src="data:image/jpg;base64,{$image}" style="float:left;">
				ID: <b>{$id}<br/>
				<p>{$description}</p>
				From: {$date_from} to  {$date_to}<br/>
				Active: {$active} Closed: {$closed} <br/>
				{$winners}<br/>
				Tickets: {$tickets}<br/>
				<a href="{$path}&delete={$id}">Delete</a>
				<hr/>
			[/$raffles]
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