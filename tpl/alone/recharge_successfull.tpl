{= AnswerSubject: "Su cuenta ha sido recargada satisfactoriamente" =}
{$h1}Su cuenta ha sido recargada satisfactoriamente{$_h1}

?$recharge_agency
{$p}{$customer.full_name} le ha recargado su cr&eacute;dito con {$amount} USD desde el exterior. 
Puedes enviarle <a href="mailto:{$customer.email}">un email</a> o <a href="mailto:{$reply_to}?subject=SMS%20{$customer.phone}&body=Gracias%20por%20la%20recarga%20de%20mi%20cr&eacute;dito%20en%20Apretaste!">un sms</a> como agradecimiento.{$_p}
?$newcredit 
{$p}Su cr&eacute;dito actual es de <b>${#newcredit:2,#}</b>.{$_p}
$newcredit?
@else@
{$p}Su cuenta ha sido recargada satisfactoriamente con <b>{$amount} USD</b>. {$_p}
$recharge_agency?

{$p}Nuevamente:{$_p}
{$p}<b>Gracias por usar Apretaste!</b>{$p}