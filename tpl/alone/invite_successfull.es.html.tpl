?$guest
<p>Su contacto <a href="mailto:{$guest}">{$guest}</a> ha sido invitado satisfactoriamente.</p>
@else@
<p>Sus contactos han sido invitados satisfactoriamente</p>
?$addresses
[$addresses]
- <a href="mailto:{$value}">{$value}</a><br/>
[/$addresses]
$addresses?
$guest?