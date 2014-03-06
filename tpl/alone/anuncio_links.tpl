<span style="font-size: small;font-size: small; float: left; margin-top: 10px; {$font}"> 
	<a href="mailto:{$reply_to}?subject=DENUNCIAR {$id}&body=Haga clic ahora en Enviar para denunciar este anuncio" title="¿Piensa que este anuncio no cumple funci&oacute;n alguna en el sitio?">Denunciar</a>
	{?( "{$from}" === "{$author}")?}
            {$splitter}<a href="mailto:{$reply_to}?subject=QUITAR {$id}&body=Haga clic en Enviar para enviar este correo y quitar el anuncio seleccionado">Quitar el anuncio</a>
	{/?}
</span>