{= *AnswerSubject: $title =}
?$guest
<p>Su contacto <a href="mailto:{$guest}">{$guest}</a> ha sido invitado satisfactoriamente.</p>
@else@
{$h1}Resultado de invitar a sus contactos{$_h1}
?$addresses
[$addresses]
- <a href="mailto:{$_key}">{$_key}</a> {$value}<br/>
[/$addresses]
$addresses?
$guest?