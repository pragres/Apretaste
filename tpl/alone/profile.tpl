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

?$profile.picture
<img src="cid:profile_picture" style="float:left;margin-right:10px;">
$profile.picture?

?$email
{$p}Email: <a href="mailto:{$email}">{$email}</a>{$_p}
$email?

?$profile.birthdate {$p}Cumplea&ntilde;os: <b>{$profile.birthdate}</b>{$_p} $profile.birthdate?
?$profile.sex {$p}Sexo: <b>{$profile.sex}</b>{$_p} $profile.sex?
?$profile.ocupation {$p}Ocupaci&oacute;n: <b>{$profile.ocupation}</b>{$_p} $profile.ocupation?
?$profile.state {$p}Provincia/Estado: <b>{$profile.state}</b>{$_p} $profile.state?
?$profile.city {$p}Municipio/Ciudad: <b>{$profile.city}</b>{$_p} $profile.city?
?$profile.town {$p}Localidad/Reparto/Pueblo: <b>{$profile.town}</b>{$_p} $profile.town?
?$profile.sentimental {$p}Situaci&oacute;n sentimental: <b>{$profile.sentimental}</b>{$_p} $profile.sentimental?
?$profile.interest {$p}Intereses: <b>{$profile.interest}</b>{$_p} $profile.interest?
<!--{ {$p}Buscando pareja:  <b>?$profile.cupid S&iacute; @else@ No $profile.cupid? </b>{$_p} }-->

?$profile.friends
{$h2}Amigos{$_h2}
<table width="100%" style="{$font}">
[$profile.friends]
	<tr ?$_is_odd style = " background: #eeeeee; color: black;" $_is_odd?>
		<td><a href="mailto:{$reply_to}?subject=PERFIL {$address}">{$name}</a></td><td><a href="mailto:{$reply_to}?subject=BLOQUEAR {$address}">bloquear</a></td><td></td></tr>
[/$profile.friends]
</table>
$profile.friends?

{?( "{$from}" == "{$email}" || "{$command}" == "state" )?}
<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=PERFIL&body=Nombre:{$profile.name}%0ACumpleanos = {$profile.birthdate}%0AOcupacion: {$profile.ocupation}%0AProvincia/Estado: {$profile.state}%0AMunicipio/Ciudad:{$profile.city}%0AReparto/Pueblo/Localidad:{$profile.town}%0ASituacion sentimental = {$profile.sentimental}%0AIntereses = {$profile.interest}">
<label style="margin: 5px;">Modificar perfil</label>
</a>
</td></tr></table>
{$br}
{/?} 