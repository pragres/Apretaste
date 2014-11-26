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
	<body onload="(( onload ))">
		<p align="center">
		<img src="static/apretaste.white.png" width="180">
		</p>
		<h1 align="center">Vendedores deudores</h1>
		<p align="center"><b>{/div.now:d/} de {$months.{/div.now:m/}} del {/div.now:Y/}</b></p>
		<hr/>
{%% table: {
	id: "dispatchers",
	data: $dispatchers,
	hideColumns: {picture: true, name: true, options: true, cards: true, total_sold: true, profit: true},
	simple: true,
	headers: {
		owe: "Deuda",
		email: "Vendedor"			
	},
	column_width: {
		email: 300,
		contact: 300
	},
	wrappers:{
		email: '{$name} - {$value}',
		owe: '${#value:2.#}'
	},
	footer: "Total: ${#sum:dispatchers-owe:2.#}"
} %%}
</body>
</html>