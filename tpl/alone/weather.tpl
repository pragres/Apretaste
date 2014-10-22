{= *AnswerSubject: $title =}
{= i18n_days: {
	SATURDAY: 'S&aacute;bado',
	SUNDAY: 'Domingo',
	MONDAY: 'Lunes',
	TUESDAY: 'Martes',
	WEDNESDAY: 'Mi&eacute;rcoles',
	THURSDAY: 'Jueves',
	FRIDAY: 'Viernes'	
} =}

{$h1}{$title}{$_h1}
{$p}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA satelite">Imagen del sat&eacute;lite</a> {$separatorLinks} 
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA nasa">Imagen de la NASA </a> {$separatorLinks}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA caribe">El Caribe</a> {$separatorLinks}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA radar">Radar</a> {$br}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA sector">Sector visible</a> {$separatorLinks}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA infrarroja">Infrarroja</a> {$separatorLinks}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA vapor">Vapor de Agua</a> {$separatorLinks}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA temperatura">Temperatura del mar</a> {$br}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA superficie">Superficie del Atl&aacute;ntico y el Caribe</a> {$separatorLinks}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA atlantico">Estado del Atl&aacute;ntico</a> {$separatorLinks}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA polvo">Polvo del desierto</a> {$br}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA presion superficial">Presi&oacute;n superficial</a> 
{$_p}
{$hr}
?$provincias
	[$provincias]
		<table>
			<tr>
				<td valign="top" align="center" width="100">
					<img src="{$weather_now.weatherIcon}" width="60"/><br/>
					{$i18n.{$weather_now.weatherCode}} 
				</td>
				<td valign="top">
					{$h2}{$locality}, <a href="mailto:{$reply_to}?subject=MAPA%20{&&locality_map}"></a> $linkmap?{$br} {$weather_now.weatherTime}{$_h2}
					<strong>Temperatura:</strong> {$weather_now.weatherTemp} {$separatorLinks}
					<strong>Viento: </strong> {$weather_now.windSpeed} {$separatorLinks}
					<strong>Lluvias:</strong> {$weather_now.precipitation} {$br}
					<strong>Humedad:</strong> {$weather_now.humidity} {$separatorLinks}
					<strong>Visibilidad:</strong> {$weather_now.visibility} {$separatorLinks}
					<strong>Presi&oacute;n:</strong> {$weather_now.pressure} {$br} 
					<strong>Nubosidad:</strong> {$weather_now.cloudcover} {$br} 
				</td>
			</tr>
				<td colspan="2">
					{$hr}
					<b>Pron&oacute;stico:</b>
					<table>
						<tr>
						[$weather_forecast]
							<td valign="top">
								<table>
									<tr><td colspan="3"><b>{$i18n_days.{$weatherDay}}, {$weatherDate:3,3}</b></td></tr>
									<tr>
										<td valign="top" align="center">
										<img src="{$weatherIcon}" width="40"/>
										</td>
										<td valign="top">
											<span class="">{$i18n.{$weatherCode}}</span>{$br}
											<span class="">Viento: <b>{$windDirection}</b> a <b>{$windSpeed}</span>{$br}
										</td>
										<td valign="top">
											<span style="color: red;">{$tempMax}</span>{$br}
											<span style="color: blue;">{$tempMin}</span>
										</td>
									</tr>
								</table>
							</td>
						[/$weather_forecast]	
						</tr>
					</table>
				</td>
			</tr>
		</table>
	[/$provincias]
	@else@
	{$p}No se encontro informaci&oacute;n meteorol&oacute;gica para el lugar especificado. Verifique que introdujo bien el nombre de la ciudad y/o el pa&iacute;s{$_p}
$provincias?

?$climaimagen
	<img src="cid:climaimagen" width="700">
$climaimagen?

