<?php

$name = str_replace("'", "''", post('edtName'));
$phone = str_replace("'", "''", post('edtPhone'));
$credit_line = post('edtCreditLine');
$address = str_replace("'", "''", post('edtAddress'));
$profit_percent = post('edtProfitPercent');
$residual_percent = post('edtResidualPercent');

if (empty($profit_percent))
	$profit_percent = "null";

if (empty($residual_percent))
	$residual_percent = "null";

q("INSERT INTO agency (name,phone,credit_line,address,profit_percent,residual_percent) 
			VALUES ('$name','$phone','$credit_line','$address', $profit_percent,$residual_percent);");

header("Location: index.php?path=admin&page=config_agency");
