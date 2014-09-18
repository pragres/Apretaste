{= title: "" =}

{% layout %}
	
{{headerup
	<div class="col-md-12">
	<p align="center">{% ../alone/logohtml %}</p>
	</div>
headerup}}

{{headerdown

	?$div.get.error 
		{= alert: 'Access denied' =}
	@else@
		{= alert: false =}
	$div.get.error?
	
	{%% form-block: {
		id: "form-auth",
		title: 'Authentication',
		action: 'auth',
		width: '300px',
		fields: [
			{
				id: 'user',
				label: 'User',
				type: 'text',
				placeholder: 'Enter user login'
			},{
				id: 'pass',
				label: 'Password',
				type: 'password',
				placeholder: 'Enter password'
			}
		],
		submit: {
			name: 'login',
			caption: 'Login'
		},
		alert: $alert
	} %%}
	
headerdown}}