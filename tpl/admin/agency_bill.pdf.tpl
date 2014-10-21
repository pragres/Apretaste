{= months: {
	1:"Jan",
	2:"Feb",
	3:"Mar",
	4:"Apr",
	5:"May",
	6:"Jun",
	7:"Jul",
	8:"Aug",
	9:"Sep",
	10:"Oct",
	11:"Nov",
	12:"Dec"
} =}
<html>
	<head>
		<style>
			body{
				font-family: Arial;
				font-size: 14px;
			}
			td,th{
				border-bottom: 1px solid black;
				padding: 5px;
				
			}
		</style>
	</head>
	<body>
		<table  width="800" align="center" cellspacing="0">
			<tr>
				<td align="center" rowspan="2" border="1" colspan="3">
					<img src="static/apretaste.white.png" width="200">
				</td>
				<td colspan="4" valign="center" align="center" style="color:green;font-size: 22px;">
				<b>Payment reminder</b><br/>
				{/div.now:D, d M, Y/}
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center" valign="center" style="font-size:28px;" >
					{$agency.name}
				</td>
			</tr>
			<tr>
				<td align="center" border="1" colspan="3">
				Credit line: <b>${#agency.credit_line:2.#}</b> 
				</td>
				<td align="center" border="1" colspan="2">
				Sold: <b>${#agency.sold:2.#} </b>
				</td>				
				<td align="center" border="1" colspan="2">
				Owe: <span style="font-size: 22px;"><b>${#agency.owe:2.#}</b></span>		
				</td>
			</tr>
			<tr>
				<td colspan = "7" align="center">
				<b><i>Details</i></b>
				</td>
			</tr>
			<tr style="background: #eeeeee;"><th>Date</th><th>Week</th><th>Sales</th><th>Amount</th><th>Profit</th><th>Residuals</th><th>Owe</th></tr>
			[$weeks]
					<tr><td width="100" align="center">{$months.{$month}}, {$year}</td>
					<td align="center">{$week}</td>
					<td align="center">{$soles}</td>
					<td align="right">${#amount:2.#}</td>
					<td align="right">${#profit:2.#}</td>
					<td align="right">${#residuals:2.#}</td>
					<td align="right">{?( {$owe} > 0 )?} ${#owe:2.#} @else@ $0.00 {/?}</td>
					</tr>
			[/$weeks]
			<tr>
				<td  colspan="7" align="right">
					<b>$(# {$sum:weeks-owe} + {$sum:weeks-residuals}:2.#)</b> owes - <b>${#sum:weeks-residuals:2.0#}</b> residuals = <b>${#agency.owe:2.#}</b> current owe
				</td>
			</tr>
			<tr>
				<td colspan="7">
				<p align="center"><i>Pay by check. Send your checks to Pragres Corporation, 3250 NW 13th Terr, Miami, Fl 33125</i></p>
				</td>
			</tr>
		</table>		
		
	</body>
</html>