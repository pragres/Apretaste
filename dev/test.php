<?php

// put here test code

// $r = ApretasteSMS::splitNumber('5930987867343');
// var_dump($r);
$body = '&aacute;COMO TU ESTAS MI HERMA. DIME COMO ANDA LA COSA POR ALL=C1. ESTOY =
PROBANDO UN SERVICIO DE SMS POR CORREO. TE ENV=CDE UNOS CORREOS QUE YA =
DEBES HABER VISTO. DALE BESOS AL NI=D1O Y SALUDOS A YOSLAN. BESOS, PAVEL.
=0A--=0A=0AEste mensaje le ha llegado mediante el servicio de correo electronico que ofrece Infomed para respaldar el cumplimiento de las misiones del Sistema Nacional de Salud. La persona que envia este correo asume el compromiso de usar el servicio a tales fines y cumplir con las regulaciones establecidas=0A=0AInfomed: http://www.sld.cu/=0A=0A ';

$body = str_replace("\n", " ", $body);
$body = str_replace("\r", " ", $body);
$body = str_replace("  ", " ", $body);

if (! Apretaste::isUTF8($body))
	$body = utf8_encode($body);

$body = quoted_printable_decode($body);

$body = trim(strip_tags($body));

$body = htmlentities($body);
$body = str_replace('&', '', $body);
$body = str_replace('tilde;', '', $body);
$body = str_replace('acute;', '', $body);
$body = html_entity_decode($body);

$p = strrpos($body, "--");

if ($p !== false)
	$body = substr($body, 0, $p);

$body = trim($body);

echo $body;
