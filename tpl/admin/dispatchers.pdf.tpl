<html>
	<head>
		<style>
			body{
				font-family: Verdana;
			}
			td{
				border-right: 1px solid gray;
				border-bottom: 1px solid gray;
				padding: 5px;
			}
			
			tr td:first-child{
			border-left: 1px solid gray;
			}
			
			th{
				background: #eeeeee;
				padding: 5px;
			}
		</style>
	</head>
	<body>
		<p align="center">
		<img src="static/apretaste.white.png" width="300">
		</p>
		<h1 align="center">Vendedores deudores</h1>
		<p align="center"><b>{/div.now:d/} de {$months.{/div.now:m/}} del {/div.now:Y/}</b></p>
		<hr/>
{%% table: {
	id: "dispatchers",
	data: $dispatchers,
	hideColumns: {picture: true, name: true, options: true},
	simple: true,
	headers: {
		picture: "Picture",
		total_sold: "Sold",
		contact: "Contact info",
		options: "Options",
		email: "Dispatcher"			
	},
	column_width: {
		email: 300,
		contact: 300
	},
	wrappers:{
		email: '<table width="100%" cellspacing="0" cellpadding="0"><tr><td width="35"><img height="100%" src="data:image/jpeg;base64,{$picture}"></td><td align="left">{$name}&nbsp;<br/><a href="index.php?path=admin&page=user_activity&user={$value}" target="_blank">{$value}</a></td></tr></table>',
		cards: '<a href="{$path}_card_sales&sales={$email}">{$value} pkgs</a>',
		total_sold: '${#value:2.#}',
		owe: '<a href="index.php?path=admin&page=dispatchers_payment_warning&dispatcher={$email}" title="View payment warning">${#value:2.#}</a>'
	}
} %%}
</body>
</html>