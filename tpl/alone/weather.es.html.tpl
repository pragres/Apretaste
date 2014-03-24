?$pronostico_hoy
	<h2>Pron&oacute;stico para hoy</h2>
	<p align="jusitfy" style="{$font};text-align:justify;">{$pronostico_hoy}</p>
$pronostico_hoy?

?$pronostico_manana
	<h2>Pron&oacute;stico para ma&ntilde;ana</h2>
	<p align="jusitfy" style="{$font};text-align:justify;">{$pronostico_manana}</p>
$pronostico_manana?

?$pronostico_extendido
	<h2>Pron&oacute;stico extendido por ciudades</h2>
	{$pronostico_extendido}
$pronostico_extendido?

?$satelite
	<h2>Imagen del Sat&eacute;lite de la NASA - GOES Project Science</h2>
	<img src="cid:goes" width="700"><br/>
$satelite?

?$radar
	<h2>Imagen del radar</h2>
	<img src="cid:radar">
	<p style="color:gray;">NOTA: Esta imagen es animada (GIF) y en algunos clientes de correo electr&oacute;nico no se visualiza bien como es el caso de Outlook 2010.</p>
$radar?

?$mapa
	<h2>Mapa de Presi&oacute;n Superficial</h2>
	<img src="cid:pronostico"><br/>
$mapa?
<hr/>
<a href = "mailto:{$reply_to}?subject=CLIMA satelite">Imagen del sat&eacute;lite</a> {$splitter} 
<a href = "mailto:{$reply_to}?subject=CLIMA radar">Imagen del radar</a> {$splitter} 
<a href = "mailto:{$reply_to}?subject=CLIMA satelite">Mapa de presi&oacute;n superficial</a>