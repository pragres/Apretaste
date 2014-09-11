{= AnswerSubject: Su agenda telef&oacute;nica =}
{$h1}{$AnswerSubject}{$_h1}
?$phonebook
	<table width="100%" style="{$font}">
	<tr><th>Nombre</th><th>Tel&eacute;fono</th><th></th></tr>
	[$phonebook]
		<tr ?$_is_odd style = " background: #eeeeee; color: black;" $_is_odd?>
		<td align="center">{$name}</td>
		<td align="center"><a title="Clic para mandar un SMS" href="mailto:{$reply_to}?subject=SMS%20{$phone}&body=Hola%20{$name}">{$phone}</td>
		<td><a href="mailto:{$reply_to}?subject=AGENDA&body={$name}%20=%20{$phone}">editar</a></td>
		</tr> 
	[/$phonebook]
	</table>
	
	
$phonebook?

<table>
	<tr>
		<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
			<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" 
			href="mailto:{$reply_to}?subject=AGENDA&body=Escriba%20el%20nombre%20a%20la%20izquierda%20del%20igual(=)%20y%20el%20telefono%20a%20la%20derecha%0ANombre%20=%20Telefono">
				<label style="margin: 5px;" title="Agregar un contacto a su agenda" >
				Agregar contacto
				</label>
			</a>
		</td>
	</tr>
</table>