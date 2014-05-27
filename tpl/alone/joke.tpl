{= *AnswerSubject: Un chiste, un chiste! =}
{$h1}Un chiste, un chiste!{$_h1}
?$joke
{$p}{$joke}{$_p}
@else@
No encontramos un buen chiste, vuelve a probar.
$joke?
<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
<a style="{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=CHISTE">
<label style="margin: 5px;">Otro chiste, otro chiste!</label>
</a>
</td></tr></table>
{$br}