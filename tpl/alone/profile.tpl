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

?$profile.name {$h1}{$profile.name}{$_h1} $profile.name?

?$profile.picture
<img src="cid:profile_picture" style="float:left;margin-right:10px;">
$profile.picture?

?$profile.birthdate {$p}Fecha de nacimiento: <b>{$profile.birthdate}</b>{$_p} $profile.birthdate?
?$profile.sex {$p}Sexo: <b>{$profile.sex}</b>{$_p} $profile.sex?
?$profile.ocupation {$p}Ocupaci&oacute;n: <b>{$profile.ocupation}</b>{$_p} $profile.ocupation?
?$profile.country {$p}Pa&iacute;s: <b>{$profile.country}</b>{$_p} $profile.country?
?$profile.state {$p}Provincia/Estado: <b>{$profile.state}</b>{$_p} $profile.state?
?$profile.city {$p}Municipio/Ciudad: <b>{$profile.city}</b>{$_p} $profile.city?
?$profile.town {$p}Localidad/Reparto/Pueblo: <b>{$profile.town}</b>{$_p} $profile.town?
?$profile.sentimental {$p}Situaci&oacute;n sentimental: <b>{$profile.sentimental}</b>{$_p} $profile.sentimental?
?$profile.interest {$p}Intereses: <b>{$profile.interest}</b>{$_p} $profile.interest?
{$p}Buscando pareja:  <b>?$profile.cupid S&iacute; @else@ No $profile.cupid? </b>{$_p}

{?( "{$from}" == "{$email}" )?}
<a href="mailto:{$reply_to}?subject=PERFIL&body=Nombre:{$profile.name}%0AFecha de nacimiento: {$profile.birthdate}%0AOcupacion: {$profile.ocupation}%0APais: {$profile.country}%0AProvincia/Estado: {$profile.state}%0AMunicipio/Ciudad:{$profile.city}%0AReparto/Pueblo/Localidad:{$profile.town}%0ASituacion sentimental:{$profile.sentimental}%0AIntereses: {$profile.interest}%0ABusco pareja: {$profile.cupid}">Modificar</a>{$br}
{/?} 