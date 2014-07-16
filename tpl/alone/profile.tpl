{= *AnswerSubject: $titile =}

{= profile.name: '' =}
{= profile.birthdate: '' =}
{= profile.cupid: '' =}
{= profile.ocupation: '' =}
{= profile.country: '' =}
{= profile.city: '' =}
{= profile.town: '' =}
{= profile.interest: '' =}
{= profile.sentimental: '' =}

?$profile.name {$h1}{$profile.name}{$_h1} @else@ ?$email {$email} $email? $profile.name?
<table>
<tr><td valign="top">
?$profile.picture
<img src="cid:profile_picture" style="float:left;margin-right:10px;">
$profile.picture?
</td><td valign="top">
?$email
{$p}Email: <a href="mailto:{$email}">{$email}</a>{$_p}
$email?

?$profile.birthdate {$p}Cumplea&ntilde;os: <b>{$profile.birthdate}</b>{$_p} $profile.birthdate?
?$profile.sex {$p}Sexo: <b>{$profile.sex}</b>{$_p} $profile.sex?
?$profile.hair {$p}Pelo: <b>{$profile.hair}</b>{$_p} $profile.hair?
?$profile.skin {$p}Piel: <b>{$profile.skin}</b>{$_p} $profile.skin?
?$profile.eyes {$p}Ojos: <b>{$profile.eyes}</b>{$_p} $profile.eyes?
?$profile.ocupation {$p}Ocupaci&oacute;n: <b>{$profile.ocupation}</b>{$_p} $profile.ocupation?
?$profile.school_level {$p}Nivel de escolaridad: <b>{$profile.school_level}</b>{$_p} $profile.school_level?
?$profile.state {$p}Provincia/Estado: <b>{$profile.state}</b>{$_p} $profile.state?
?$profile.city {$p}Municipio/Ciudad: <b>{$profile.city}</b>{$_p} $profile.city?
?$profile.town {$p}Localidad/Reparto/Pueblo: <b>{$profile.town}</b>{$_p} $profile.town?
?$profile.sentimental {$p}Situaci&oacute;n sentimental: <b>{$profile.sentimental}</b>{$_p} $profile.sentimental?
?$profile.interest {$p}Intereses: <b>{$profile.interest}</b>{$_p} $profile.interest?

<!--{ {$p}Buscando pareja:  <b>?$profile.cupid S&iacute; @else@ No $profile.cupid? </b>{$_p} }-->
</td></tr></table>

?$profile.friends
{$h2}Amigos{$_h2}
[[profile
<table width="100%" style="{$font}">
[$friends]
	<tr ?$_is_odd style = " background: #eeeeee; color: black;" $_is_odd?>
		<td><a href="mailto:{$reply_to}?subject=PERFIL {$xemail}">{$name}</a></td><td><a href="mailto:{$reply_to}?subject=BLOQUEAR {$xemail}">bloquear</a></td>
	</tr>
[/$friends]
</table>
profile]]
$profile.friends?

{?( "{$from}" == "{$email}" || "{$command}" == "state" )?}
<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=PERFIL&body=Nombre:{$profile.name}%0ACumpleanos = {$profile.birthdate}%0AOcupacion: {$profile.ocupation}%0AProvincia/Estado: {$profile.state}%0AMunicipio/Ciudad:{$profile.city}%0AReparto/Pueblo/Localidad:{$profile.town}%0ASituacion sentimental = {$profile.sentimental}%0AIntereses = {$profile.interest}">
<label style="margin: 5px;">Modificar perfil</label>
</a>
</td></tr></table>
{$br}
{/?} 