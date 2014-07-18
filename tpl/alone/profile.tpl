{= *AnswerSubject: $titile =}

{= name: '' =}
{= sex: '' =}
{= hair: '' =}
{= skin: '' =}
{= eyes: '' =}
{= school_level: '' =}
{= state: '' =}
{= birthdate: '' =}
{= ocupation: '' =}
{= city: '' =}
{= town: '' =}
{= interest: '' =}
{= sentimental: '' =}

?$name {$h1}{$name}{$_h1} @else@ ?$email {$email} $email? $name?
<table>
<tr><td valign="top">
?$picture
<img src="cid:profile_picture" style="float:left;margin-right:10px;">
$picture?
</td><td valign="top">
?$email
{$p}Email: <a href="mailto:{$email}">{$email}</a>{$_p}
$email?

?$birthdate {$p}Cumplea&ntilde;os: <b>{$birthdate}</b>{$_p} $birthdate?
?$sex {$p}Sexo: <b>{$sex}</b>{$_p} $sex?
?$hair {$p}Pelo: <b>{$hair}</b>{$_p} $hair?
?$skin {$p}Piel: <b>{$skin}</b>{$_p} $skin?
?$eyes {$p}Ojos: <b>{$eyes}</b>{$_p} $eyes?
?$ocupation {$p}Ocupaci&oacute;n: <b>{$ocupation}</b>{$_p} $ocupation?
?$school_level {$p}Nivel de escolaridad: <b>{$school_level}</b>{$_p} $school_level?
?$state {$p}Provincia/Estado: <b>{$state}</b>{$_p} $state?
?$city {$p}Municipio/Ciudad: <b>{$city}</b>{$_p} $city?
?$town {$p}Localidad/Reparto/Pueblo: <b>{$town}</b>{$_p} $town?
?$sentimental {$p}Situaci&oacute;n sentimental: <b>{$sentimental}</b>{$_p} $sentimental?
?$interest {$p}Intereses: <b>{$interest}</b>{$_p} $interest?

<!--{ {$p}Buscando pareja:  <b>?$cupid S&iacute; @else@ No $cupid? </b>{$_p} }-->
</td></tr></table>

?$friends
{$h2}Amigos{$_h2}
<table width="100%" style="{$font}">
[$friends]
	<tr ?$_is_odd style = " background: #eeeeee; color: black;" $_is_odd?>
		<td><a href="mailto:{$reply_to}?subject=PERFIL {$xemail}">{$xname}</a></td>
		{?( "{$from}" == "{$email}" || "{$command}" == "state" )?}
		<td><a href="mailto:{$reply_to}?subject=BLOQUEAR {$xemail}">bloquear</a></td>
		{/?}
	</tr>
[/$friends]
</table>
$friends?

{?( "{$from}" == "{$email}" || "{$command}" == "state" )?}
{$br}
<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">

{= pf1: Escriba su nombre despues de la palabra Nombre, por ejemplo, Juan Perez Gutierres%0ANombre %3D {$name}%0A%0A =}
{= pf2: Escriba su fecha de nacimiento de la forma AAAA-MM-DD, por ejemplo, 1980-01-23%0ACumpleanos %3D {$birthdate}%0A%0A =}
{= pf3: Escriba su ocupacion. De ser posible use una sola palabra. Por ejemplo "Arquitecto"%0AOcupacion %3D {$ocupation}%0A%0A =}
{= pf4: Escriba el nombre de la provincia donde actualmente reside%0AProvincia %3D {$state}%0A%0A =}
{= pf5: Escriba el nombre del municipio donde actualmente vive%0AMunicipio %3D {$city}%0A%0A =}
{= pf6: Escriba el nombre del reparto o pueblo donde vive actualmente%0AReparto %3D {$town}%0A%0A =}
{= pf7: Escriba una de las siguientes opciones: casado, soltero, divorciado, viudo, comprometido, otro%0ASituacion sentimental %3D {$sentimental}%0A%0A =}
{= pf8: Escriba sus intereses separados por coma, por ejemplo: Trabajo, Aviones%0AIntereses %3D{$interest}%0A%0A =}
{= pf9: Escriba una de las siguientes opciones: masculino, femenino, desconocido%0ASexo %3D {$sex}%0A%0A =}
{= pf10: Escriba una de las siguientes opciones: rubio, trigueno, moreno, negro, otro%0APelo %3D {$hair}%0A%0A =}
{= pf11: Escriba una de las siguientes opciones: blanca, negra, amarilla, india, mestiza, otra%0APiel %3D {$skin}%0A%0A =}
{= pf12: Escriba una de las siguientes opciones: verde, pardo, azul, negro, otro%0AOjos %3D {$eyes}%0A%0A =}
{= pf11: Escriba una de las siguientes opciones: secundaria, tecnico, universidad, master, doctor, otro%0ANivel escolar%3D{$school_level}%0A%0A =}

<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" 
href="mailto:{$reply_to}?subject=PERFIL&body=[:1,11:]{$pf{$value}}[/]">
<label style="margin: 5px;">Modificar perfil</label>
</a>
</td></tr></table>
{$br}
{/?} 