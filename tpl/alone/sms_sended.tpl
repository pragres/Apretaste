{= AnswerSubject: "SMS enviado correctamente" =}
{$h1}{$AnswerSubject}{$_h1}
{$br}
{$p}Su cr&eacute;dito actual es de <b>${$newcredit}</b>.{$_p}
?$bodyextra
{$p}Se enviaron solamente los primeros 160 caracteres. El siguiente texto no fue enviado:{$_p}
{$p}<b>{$bodyextra}</b>{$_p}
$bodyextra?