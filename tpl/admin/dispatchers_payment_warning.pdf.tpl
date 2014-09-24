{= months: {
	m01:"Enero",
	m02:"Febrero",
	m03:"Marzo",
	m04:"Abril",
	m05:"Mayo",
	m06:"Junio",
	m07:"Julio",
	m08:"Agosto",
	m09:"Septiembre",
	m10:"Octubre",
	m11:"Noviembre",
	m12:"Diciembre"
} =}
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
		<h1 align="center">Aviso de pago</h1>
		<p align="center"><b>{/div.now:d/} de {$months.m{/div.now:m/}} del {/div.now:Y/}</b></p>
		<hr/>
		<p align="center">
		Para: <b>{$dispatcher_name}</b> ({$dispatcher_email})<br/>
		Total a pagar: <b>${#owe:2.#}</b>
		</p>
		<hr/>
		<h2 align="center">Recargas sin pagar</h2>
		<h3 align="center">Desde {$from_date} hasta {$to_date}</h3>
		<table align="center">
			<tr><th>Fecha</th><th>Usuario</th><th>C&oacute;digo</th><th>Precio</th><th>Deuda</th></tr>
			[$cards]
				<tr><td>{$date}</td><td>{$user_email}</td><td>{$code}</td><td>${#price:2.#}</td><td>${#owe:2.#}</td></tr>
			[/$cards]
				<tr><th>Totales</th><th></th><th>{$count:cards-code} recarga(s)</th><th>${#sum:cards-price:2.#}</th><th>${#sum:cards-owe:2.#}</th></tr>
		</table>
	</body>
</html>