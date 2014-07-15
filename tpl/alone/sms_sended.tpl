{= AnswerSubject: "SMS enviado correctamente" =}
{$h1}{$AnswerSubject}{$_h1}
{$br}
{$p}Su cr&eacute;dito actual es de <b>${#newcredit:2.#}</b>.{$_p}
?$bodyextra
{$p}Se enviaron solamente los primeros 160 caracteres. El texto en negrita no fue enviado:{$_p}
{$p}{$bodysended}<b>{$bodyextra}</b>{$_p}
$bodyextra?