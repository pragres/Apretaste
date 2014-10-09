{= *AnswerSubject: $title =}

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

{= aboutdesc: Escriba un parrafo hablando de usted despues del simbolo igual. No debe pasar de 1000 caracteres =}
{= pf1: Su nombre, ejemplo: Juan Perez Gutierres\nNOMBRE = {$name} =}
{= pf2: Fecha de nacimiento (dd/mm/aaaa), ejemplo: 23/08/1985\nCUMPLEANOS = {$birthdate} =}
{= pf3: A que te dedicas? Resumelo en una sola palabra, ejemplo: Arquitecto\nOCUPACION = {$ocupation} =}
{= pf4: Dinos donde vives, pon todo lo que sepas\nPROVINCIA = {$state} =}
{= pf5: MUNICIPIO = {$city} =}
{= pf6: REPARTO = {$town} =}
{= pf7: Escoja: Masculino, Femenino u Desconocido\nSEXO = {$sex} =}
{= pf8: Y recuerde adjuntar su foto! =}
{= pf9: Escoja: Secundaria, Tecnico, Universidad, Master, Doctor, Otro\nNIVEL ESCOLAR = {$school_level} =}
{= pf10: Escoja: Casado, Soltero, Divorciado, Viudo, Comprometido, Saliendo u Otro\nESTADO CIVIL = {$sentimental} =}
{= pf11: Escoja: Rubio, Trigueno, Moreno, Negro u Otro\nPELO = {$hair} =}
{= pf12: Escoja: Blanca, negra, amarilla, india, mestiza, otra\nPIEL = {$skin} =}
{= pf13: Escoja: Verdes, pardos, azules, negros, otros\nOJOS = {$eyes} =}
{= pf14: Intereses, separados por coma, ejemplo: Trabajo, Aviones\nINTERESES = {$interest} =}

{= pfx: Solo envia este correo para quitar este dato de tu perfil =}
{= pfx1: NOMBRE = =}
{= pfx2: CUMPLEANOS = =}
{= pfx3: OCUPACION = =}
{= pfx4: PROVINCIA = =}
{= pfx5: MUNICIPIO = =}
{= pfx6: REPARTO =  =}
{= pfx7: SEXO = =}
{= pfx9: NIVEL ESCOLAR = =}
{= pfx10: ESTADO CIVIL = =}
{= pfx11: PELO = =}
{= pfx12: PIEL = =}
{= pfx13: OJOS = =}
{= pfx14: INTERESES = =}

{?( "{$from}" == "{$email}" || "{$command}" == "state" )?}
{= edit: true =}
{/?}
 
{$h1} Perfil: ?$name {$name} @else@ {$email} $name? ?$edit <a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf1}" style="font-size:14px;font-weight:normal;">[editar]</a> $edit? {$_h1}
<table>
<tr><td valign="top" align="center">
?$picture
	<img src="cid:profile_picture" style="float:left;margin-right:10px;" width="150"><br/>
	?$edit
	[<a href="mailto:{$reply_to}?subject=PERFIL&body=Adjunte%20una%20nueva%20foto%20para%20reemplazar%20la%20anterior">cambiar</a>]
	 &nbsp;
	[<a href="mailto:{$reply_to}?subject=PERFIL&body=QUITAR%20FOTO">quitar</a>]
	$edit?
$picture?
</td><td valign="top">
?$email
{$p}Email: <a href="mailto:{$email}">{$email}</a>{$_p}
$email?

?$birthdate {$p}Cumplea&ntilde;os: <b>{$birthdate}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf2}">editar</a>] [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pfx}%0A{&&pfx2}">borrar</a>]$edit?{$_p} $birthdate?
?$age {$p}Edad: <b>{$age} a&ntilde;os</b> {$_p} $age?
?$ocupation {$p}Ocupaci&oacute;n: <b>{$ocupation}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf3}">editar</a>] [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pfx}%0A{&&pfx3}">borrar</a>]$edit?{$_p} $ocupation?
?$state {$p}Provincia/Estado: <b>{$state}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf4}">editar</a>] [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pfx}%0A{&&pfx4}">borrar</a>]$edit?{$_p} $state?
?$city {$p}Municipio/Ciudad: <b>{$city}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf5}">editar</a>] [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pfx}%0A{&&pfx5}">borrar</a>]$edit?{$_p} $city?
?$town {$p}Localidad/Reparto/Pueblo: <b>{$town}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf6}">editar</a>] [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pfx}%0A{&&pfx6}">borrar</a>]$edit?{$_p} $town?
?$sex {$p}Sexo: <b>{$sex}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf7}">editar</a>] [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pfx}%0A{&&pfx7}">borrar</a>]$edit?{$_p} $sex?
?$school_level {$p}Nivel de escolaridad: <b>{$school_level}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf9}">editar</a>] [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pfx}%0A{&&pfx9}">borrar</a>]$edit?{$_p} $school_level?
?$sentimental {$p}Situaci&oacute;n sentimental: <b>{$sentimental}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf10}">editar</a>] [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pfx}%0A{&&pfx10}">borrar</a>]$edit?{$_p} $sentimental?
?$hair {$p}Pelo: <b>{$hair}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf11}">editar</a>] [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pfx}%0A{&&pfx11}">borrar</a>]$edit?{$_p} $hair?
?$skin {$p}Piel: <b>{$skin}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf12}">editar</a>] [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pfx}%0A{&&pfx12}">borrar</a>]$edit?{$_p} $skin?
?$eyes {$p}Ojos: <b>{$eyes}</b> ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf13}">editar</a>] [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pfx}%0A{&&pfx13}">borrar</a>]$edit?{$_p} $eyes?
?$interest {$p}Intereses: ?$edit [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pf14}">editar</a>] [<a href="mailto:{$reply_to}?subject=PERFIL&body={&&pfx}%0A{&&pfx14}">borrar</a>]$edit?<br/><b>{$interest}</b>{$_p} $interest?

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
{$h2}¿C&oacute;mo editar su perfil?{$_h2}
{$p}Llene todos los campos de su perfil, que funcionar&aacute; como su tarjeta de presentaci&oacute;n
 en Apretaste! Tambi&eacute;n nos ayudara a mejorar las busquedas y a personalizar Apretaste! para usted.{$_p}
{$p}Su perfil es una combinacion <b>PROPIEDAD = Valor</b>. Asigne un valor para cada PROPIEDAD despues del signo de igual (=) y envie el email. Si no especifica el valor, el dato ser&aacute; eliminado de su perfil, y en cualquier otro momento puede especificarlo nuevamente. <b>Adjunte una foto de usted si quiere que aparezca como foto del perfil</b>.{$_p}
{$p}Haga clic en los siguientes botones para editar sus datos de identificaci&oacute;n y otros datos de inter&eacute;s respectivamente.{$_p}

<table>
	<tr>
		<td>
			<table>
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" 
						href="mailto:{$reply_to}?subject=PERFIL&body=[:1,8:]{&&pf{$value}}%0A%0A
						[/]">
							<label style="margin: 5px;" title="Nombre, Fecha de nacimiento, ocupacion, donde vives, sexo" >
							Editar mi identidad
							</label>
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" 
						href="mailto:{$reply_to}?subject=PERFIL&body=[:9,14:]{&&pf{$value}}%0A%0A
						[/]"><label style="margin: 5px;" title="Nivel escolar, estado civil, color de pelo, color de piel, color de ojos, intereses">Editar otros datos</label>
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
						<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" 
						href="mailto:{$reply_to}?subject=PERFIL&body=ACERCA%20DE%20MI%20={&&about}"><label style="margin: 5px;" title="Describa su persona en un parrafo para que otros lo puedan conocer mejor.">Escribir acerca de m&iacute;</label>
						</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
{$br}
{/?} 

?$about
{$br}
{$h2}?$edit Acerca de usted <a href="mailto:{$reply_to}?subject=PERFIL&body={&&aboutdesc}%0AACERCA%20DE%20MI%20={&&about}" style="font-size:14px;font-weight:normal;">[editar]</a> @else@ Acerca de {$name} $edit?{$_h2}
{$p}{br:about}{$_p}
$about?

{$br}