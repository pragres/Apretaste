{= path: index.php?path=admin&page=agency_bill =}
{= title: My bill =}
{= pagewidth: 1024 =}

{% layout %}

{{page
	{% agency_panel %}
	<h1>Summary</h1>
	<p>Credit line: ${#credit_line:2.#} | Sold: ${#sold:2.#} | Owe: ${#owe#} <a href="index.php?path=admin&page=agency_help">{ico}help{/ico}</a></p>
	<a href="#" class="button">Pay {$owe} with PayPal</a>
	<table width="100%"><tr><td width="49%"><hr/></td><td width="30">OR</td><td width="49%"><hr/></td></tr></table>
	<p align="center">Pay by check. Send your checks to Pragres Corporation, 3250 NW 13th Terr, Miami, Fl 33125</p>
	
	<h1>Details</h1>
page}}

