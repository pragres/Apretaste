{= *AnswerSubject: $titile =}
{$h1}{$profile.name}{$_h1}

?$profile.picture
<img src="cid:profile_picture" style="float:left;margin-right:10px;">
$profile.picture?

?$profile.birthdate {$p}Fecha de nacimiento: <b>{$profile.birthdate}</b>{$_p} $profile.birthdate?
?$profile.sex {$p}Sexo: <b>{$profile.sex}</b>{$_p} $profile.sex?
?$profile.ocupation {$p}Ocupaci&oacute;n: <b>{$profile.ocupation}</b>{$_p} $profile.ocupation?
?$profile.country {$p}Pa&iacute;s: <b>{$profile.country}</b>{$_p} $profile.country?
?$profile.state {$p}Provincia/Estado: <b>{$profile.state}</b>{$_p} $profile.state?
?$profile.city {$p}Municipio/Ciudad: <b>{$profile.city}</b>{$_p} $profile.city?
?$profile.town {$p}Localidad/Reparto: <b>{$profile.town}</b>{$_p} $profile.town?
?$profile.sentimental {$p}Situaci&oacute;n sentimental: <b>{$profile.sentimental}</b>{$_p} $profile.sentimental?
?$profile.interest {$p}Intereses: <b>{$profile.interest}</b>{$_p} $profile.interest?
{$p}Buscando pareja:  <b>?$profile.cupid S&iacute; @else@ No $profile.cupid? </b>{$_p}

