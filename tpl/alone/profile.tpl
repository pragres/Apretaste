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

{= pf1: Su nombre, ejemplo: Juan Perez Gutierres%0ANOMBRE %3D {$name}%0A%0A =}
{= pf2: Fecha de nacimiento (dd/mm/aaaa), ejemplo: 23/08/1985%0ACUMPLEANOS %3D {$birthdate}%0A%0A =}
{= pf3: A que te dedicas? Resumelo en una sola palabra, ejemplo: Arquitecto%0AOCUPACION %3D {$ocupation}%0A%0A =}
{= pf4: Dinos donde vives, pon todo lo que sepas%0APROVINCIA %3D {$state}%0A =}
{= pf5: MUNICIPIO %3D {$city}%0A =}
{= pf6: REPARTO %3D {$town}%0A%0A =}
{= pf7: Escoja: Masculino, Memenino u Desconocido%0ASEXO %3D {$sex}%0A%0A =}
{= pf8: Y recuerde adjuntar su foto! =}
{= pf9: Escoja: Secundaria, Tecnico, Universidad, Master, Doctor, Otro%0ANIVEL ESCOLAR %3D{$school_level}%0A%0A =}
{= pf10: Escoja: Casado, Soltero, Divorciado, Viudo, Comprometido, Saliendo u Otro%0AESTADO CIVIL %3D {$sentimental}%0A%0A =}
{= pf11: Escoja: Rubio, Trigueno, Moreno, Negro u Otro%0APELO %3D {$hair}%0A%0A =}
{= pf12: Escoja: Blanca, negra, amarilla, india, mestiza, otra%0APIEL %3D {$skin}%0A%0A =}
{= pf13: Escoja: Verdes, pardos, azules, negros, otros%0AOJOS %3D {$eyes}%0A%0A =}
{= pf14: Intereses, separados por coma, ejemplo: Trabajo, Aviones%0AINTERESES %3D{$interest}%0A%0A =}

{?( "{$from}" == "{$email}" || "{$command}" == "state" )?}
{= edit: true =}
{/?}
 
{$h1} ?$edit Su perfil: $edit? ?$name {$name} ?$edit <a href="mailto:{$reply_to}?subject=PERFIL&body={$pf1}" style="font-size:14px;font-weight:normal;">[editar]</a> $edit? @else@ ?$email :{$email} $email? $name? {$_h1}
<table>
<tr><td valign="top">
?$picture
<img src="cid:profile_picture" style="float:left;margin-right:10px;">
$picture?
</td><td valign="top">
?$email
{$p}Email: <a href="mailto:{$email}">{$email}</a>{$_p}
$email?

?$birthdate {$p}Cumplea&ntilde;os: <b>{$birthdate}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={$pf2}">editar</a>] $edit?{$_p} $birthdate?
?$ocupation {$p}Ocupaci&oacute;n: <b>{$ocupation}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={$pf3}">editar</a>] $edit?{$_p} $ocupation?
?$state {$p}Provincia/Estado: <b>{$state}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={$pf4}">editar</a>]$edit?{$_p} $state?
?$city {$p}Municipio/Ciudad: <b>{$city}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={$pf5}">editar</a>]$edit?{$_p} $city?
?$town {$p}Localidad/Reparto/Pueblo: <b>{$town}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={$pf6}">editar</a>]$edit?{$_p} $town?
?$sex {$p}Sexo: <b>{$sex}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={$pf7}">editar</a>]$edit?{$_p} $sex?
?$school_level {$p}Nivel de escolaridad: <b>{$school_level}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={$pf9}">editar</a>]$edit?{$_p} $school_level?
?$sentimental {$p}Situaci&oacute;n sentimental: <b>{$sentimental}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={$pf10}">editar</a>]$edit?{$_p} $sentimental?
?$hair {$p}Pelo: <b>{$hair}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={$pf11}">editar</a>]$edit?{$_p} $hair?
?$skin {$p}Piel: <b>{$skin}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={$pf12}">editar</a>]$edit?{$_p} $skin?
?$eyes {$p}Ojos: <b>{$eyes}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={$pf13}">editar</a>]$edit?{$_p} $eyes?
?$interest {$p}Intereses: <b>{$interest}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={$pf14}">editar</a>]$edit?{$_p} $interest?

<!--{ {$p}Buscando pareja:  <b>?$cupid S&iacute; @else@ No $cupid? </b>{$_p} }-->
</td></tr></table>

?$friends
{$h2}?$edit Sus amigos @else@ Amigos $edit? {$_h2}
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
{$h2}¿C&oacute;mo editar mi perfil?{$_h2}
{$p}Llene todos los campos de su perfil, que funcionar&aacute; como su tarjeta de presentaci&oacute;n
 en Apretaste! Tambi&eacute;n nos ayudara a mejorar las busquedas y a personalizar Apretaste! para usted.{$_p}
{$p}Su perfil es una combinacion <b>PROPIEDAD = Valor</b>. Asigne un valor para cada PROPIEDAD despues del signo de igual (=) y envie el email. <b>Adjunte una foto de usted si quiere que aparezca como foto del perfil</b>.{$_p}
{$p}Haga clic en los siguientes botones para editar sus datos de identificaci&oacute;n y otros datos de inter&eacute;s respectivamente.{$_p}

<table><tr><td>
<table>
<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" 
href="mailto:{$reply_to}?subject=PERFIL&body=[:1,8:]{$pf{$value}}
[/]"><label style="margin: 5px;" title="Nombre, Fecha de nacimiento, ocupacion, donde vives, sexo" >Editar mi identidad</label></a></td></tr></table>
</td><td>
<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" 
href="mailto:{$reply_to}?subject=PERFIL&body=[:9,14:]{$pf{$value}}
[/]"><label style="margin: 5px;" title="Nivel escolar, estado civil, color de pelo, color de piel, color de ojos, intereses">Editar otros datos</label></a></td></tr></table>
</td></tr></table>
{$br}
{/?} 