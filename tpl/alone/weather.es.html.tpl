?$pronostico_hoy
	{$pronostico_hoy}
$pronostico_hoy?

?$pronostico_manana
	{$pronostico_manana}
$pronostico_manana?

?$pronostico_extendido
	{$pronostico_extendido}
$pronostico_extendido?

?$satelite
	<h2 style="{$font}">Imagen del Sat&eacute;lite - WSI Corporation</h2>
	<img src="cid:wsi" width="700"><br/>
$satelite?

?$nasa
	<h2 style="{$font}">Imagen del Sat&eacute;lite de la NASA - GOES Project Science</h2>
	<img src="cid:goes" width="700"><br/>
$nasa?

?$radar
	<h2 style="{$font}">Imagen del radar</h2>
	<img src="cid:radar">
	<p style="color:gray;">NOTA: Esta imagen es animada (GIF) y en algunos clientes de correo electr&oacute;nico no se visualiza bien como es el caso de Outlook 2010.</p>
$radar?

?$mapa
	<h2 style="{$font}">Mapa de Presi&oacute;n Superficial</h2>
	<img src="cid:pronostico"><br/>
$mapa?
<br/>
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA satelite">Imagen del sat&eacute;lite</a> {$splitter} 
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA nasa">Imagen de la NASA </a> {$splitter}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA radar">Imagen del radar</a> {$splitter} 
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA mapa">Mapa de presi&oacute;n superficial</a>
</hr>
