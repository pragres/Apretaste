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

?$provincias
	[$provincias]
		   
		<table>
			<tr>
				<td valign="top" align="center" width="100">
					<img src="{$weather_now.weatherIcon}" width="60"/><br/>
					{$i18n.{$weather_now.weatherCode}} 
				</td>
				<td valign="top">
					<h2>{$locality}, {$weather_now.weatherTime}</h2>
					<strong>Temperatura:</strong> {$weather_now.weatherTemp} {$splitter}
					<strong>Viento: </strong> {$weather_now.windSpeed} {$splitter}
					<strong>Lluvias:</strong> {$weather_now.precipitation} {$splitter}
					<strong>Humedad:</strong> {$weather_now.humidity}<br/>
					<strong>Visibilidad:</strong> {$weather_now.visibility} {$splitter}
					<strong>Presi&oacute;n:</strong> {$weather_now.pressure} {$splitter}
					<strong>Nubosidad:</strong> {$weather_now.cloudcover} {$splitter}<br/>
					<hr/>
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
											<span class="">{$i18n.{$weatherCode}}</span><br/>
											<span class="">Viento: <b>{$windDirection}</b> a <b>{$windSpeed}</span><br/>
										</td>
										<td valign="top">
											<span style="color: red;">{$tempMax}</span><br/>
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
$provincias?

?$climaimagen
	{$h1}{$title}{$_h1}
	<img src="cid:climaimagen" width="700">{$br}
$climaimagen?

<br/>
{$p}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA satelite">Imagen del sat&eacute;lite</a> {$splitter} 
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA nasa">Imagen de la NASA </a> {$splitter}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA radar">Imagen del radar</a> {$br}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA temperatura">An&aacute;lisis de la temperatura del mar</a> {$splitter}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA superficie">An&aacute;lisis de la superficie del Atl&aacute;ntico y el Caribe</a> {$splitter}
<a style="{$font}" href = "mailto:{$reply_to}?subject=CLIMA atlantico">An&aacute;lisis del estado del Atl&aacute;ntico</a> {$splitter}
{$_p}