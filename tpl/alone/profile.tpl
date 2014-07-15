{= *AnswerSubject: "Su perfil en Apretaste!" =}
{$h1}{$profile.name}{$_h1}
?$profile.picture
<img src="cid:profile_picture">
$profile.picture?
?$profile.birthdate {$p}Fecha de nacimiento: <b>{$profile.birthdate}</b>{$_p} $profile.birthdate?
?$profile.sex {$p}Sexo: <b>{$profile.sex}</b>{$_p} $profile.sex?
?$profile.ocupation {$p}Ocupaci&oacute;n: <b>{$profile.ocupation}</b>{$_p} $profile.ocupation?
?$profile.pais {$p}Pa&iacute;s: <b>{$profile.pais}</b>{$_p} $profile.pais?
?$profile.state {$p}Provincia/Estado: <b>{$profile.state}</b>{$_p} $profile.state?
?$profile.city {$p}Municipio/Ciudad: <b>{$profile.city}</b>{$_p} $profile.city?
?$profile.town {$p}Localidad/Reparto: <b>{$profile.town}</b>{$_p} $profile.town?

