{= *AnswerSubject: $titile =}

{= name: '' =}
{= birthdate: '' =}
{= cupid: '' =}
{= ocupation: '' =}
{= country: '' =}
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
		<td><a href="mailto:{$reply_to}?subject=BLOQUEAR {$xemail}">bloquear</a></td>
	</tr>
[/$friends]
</table>
$friends?

{?( "{$from}" == "{$email}" || "{$command}" == "state" )?}
{$br}
<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=PERFIL&body=Nombre%3D{$name}%0ACumpleanos%3D{$birthdate}%0AOcupacion%3D{$ocupation}%0AProvincia/Estado%3D{$state}%0AMunicipio/Ciudad%3D{$city}%0AReparto/Pueblo/Localidad%3D{$town}%0ASituacion sentimental%3D{$sentimental}%0AIntereses%3D{$interest}">
<label style="margin: 5px;">Modificar perfil</label>
</a>
</td></tr></table>
{$br}
{/?} 