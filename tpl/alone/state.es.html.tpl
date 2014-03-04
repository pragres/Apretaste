<p align="justify" style="{$font}">A continuaci&oacute;n se muestra informaci&oacute;n sobre su estado en {$apretaste}, como es
la lista de sus anuncios y las alertas a las cuales Ud. est&aacute; subscrito. Este reporte puede cambiar durante
el tiempo, por lo que puede <a href = "mailto:{$reply_to}?subject=ESTADO&Haga clic en Enviar para obtener el reporte de su estado en {$apretaste}" style ="{$element-a}">solicitarlo nuevamente.</a></p>

{= static_sections: [
	{
		title: "Sus anuncios publicados",
		content: '{% state_ads.es.html %}'
	},{
		title: "Sus alertas por correo",
		content: '{% state_subs.es.html %}'
	}
] =}