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

{$p}Llene todos los campos de su perfil, que funcionar&aacute; como su tarjeta de presentaci&oacute;n
 en Apretaste! Tambi&eacute;n nos ayudara a mejorar las busquedas y a personalizar Apretaste! para usted.{$_p}
{$p}Su perfil es una combinacion <b>PROPIEDAD = Valor</b>. Asigne un valor para cada PROPIEDAD despues del signo de igual (=) y envie el email. Adjunte una foto de usted si quiere que aparezca como foto del perfil.{$_p}{$br}

{= pf3: Su nombre, ejemplo: Juan Perez Gutierres%0ANOMBRE %3D {$name}%0A%0A =}
{= pf4: Fecha de nacimiento (dd/mm/aaaa), ejemplo: 23/08/1985%0ACUMPLEANOS %3D {$birthdate}%0A%0A =}
{= pf5: A que te dedicas? Resumelo en una sola palabra, ejemplo: Arquitecto%0AOCUPACION %3D {$ocupation}%0A%0A =}
{= pf6: Dinos por donde vives, llena todo lo que sepas%0APROVINCIA %3D {$state}%0A =}
{= pf7: MUNICIPIO %3D {$city}%0A =}
{= pf8: REPARTO %3D {$town}%0A%0A =}
{= pf9: Escoja: Casado, Soltero, Divorciado, Viudo, Comprometido, Saliendo u Otro%0AESTADO CIVIL %3D {$sentimental}%0A%0A =}
{= pf10: Intereses, separados por coma, ejemplo: Trabajo, Aviones%0AINTERESES %3D{$interest}%0A%0A =}
{= pf11: Escoja: Masculino, Memenino u Desconocido%0ASEXO %3D {$sex}%0A%0A =}
{= pf12: Escoja: Rubio, Trigueno, Moreno, Negro u Otro%0APELO %3D {$hair}%0A%0A =}
{= pf13: Escoja: Blanca, negra, amarilla, india, mestiza, otra%0APIEL %3D {$skin}%0A%0A =}
{= pf14: Escoja: Verdes, pardos, azules, negros, otros%0AOJOS %3D {$eyes}%0A%0A =}
{= pf15: Escoja: Secundaria, Tecnico, Universidad, Master, Doctor, Otro%0ANIVEL ESCOLAR %3D{$school_level}%0A%0A =}
{= pf16: Y recuerde adjuntar su foto! =}

<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" 
href="mailto:{$reply_to}?subject=PERFIL&body=[:3,16:]{$pf{$value}}
[/]">
<label style="margin: 5px;">Editar perfil</label>
</a>
</td></tr></table>
{$br}
{/?} 