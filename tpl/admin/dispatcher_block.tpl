<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">{$name}</h3>
	</div>
	<div class="panel-body">
		<img src="data:image/jpeg;base64,{$picture}"><br/>
		<a href="mailto:{$email}">{$email}</a><br/>
		Owe:<br/>
		<b>${#owe:2.#}</b>
	</div>
</div>