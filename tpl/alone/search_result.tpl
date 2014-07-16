<table width="100%" style="{$font}">
[$search_results]

		?$cota
		?$_is_first
			<tr><td><i>Solo se encontraron anuncios relacionados con <b>{$query}</b></i><br/><br/></td></tr>
		@else@
			<tr><td><hr/><h2 style="{$element-h2}"><i>Se encontraron anuncios relacionados con <b>{$query}</b></i></h2></td></tr>
		$_is_first?
		$cota?			
				
        <tr><td valign="top">
		<span>
                    <b>
                    <font size="4">
                    <a href="mailto:{$reply_to}?subject=ANUNCIO {$id}&body=Haga clic en Enviar para obtener el anuncio seleccionado.">{^title}</a>
                    </font>
                    </b>
		</span>
		</td></tr><tr>
		<td valign="top">
		<table style ="{$font}; border-bottom: 1px solid #eeeeee;">
		<tr><td valign="top">
			<table width="100%"><tr>
			?$image 
			<td width="100" valign="top">
				<img style="width:100px; padding: 3px; margin-right: 10px; background-color: white; border: 2px solid #C1C1C1;"	alt="imagen" src="{$image_src}" height="100" width="100"/>
			</td>
			$image? 
			<td valign="top">
			?$body
				<p align="justify" style="margin: 0px;{$font}">
					{$body:~300}
					{?( {%body} > 300 )?} ... {/?}
				</p>
			$body?
			</td></tr><tr><td colspan="2">
			<span style="font-size: small; float: left; margin-top: 10px;">
			?$tax  <a href="mailto:{$reply_to}?subject=BUSCAR {$tax}">{$tax}</a> {$splitter} $tax?
				?$price <span style="{$style-price}">{$price}&nbsp;{$currency}</span> {$splitter} $price? 
				?$phones Tel&eacute;fono: <b>{$phones.0}</b> {$splitter} $phones?
				?$emails <a href ="mailto:{$emails.0}">{$emails.0}</a> {$splitter} $emails?
				?$hits {$hits} {?( {$hits} > 1)?} veces @else@ vez {/?} visto {$splitter} $hits?
				{$post_date:10} {$splitter}
				<span style="font-size: small;font-size: small; margin-top: 10px;"> 
				<a href="mailto:{$reply_to}?subject=DENUNCIAR {$id}&body=Haga clic en Enviar para denunciar el anuncio." title="¿Piensa que este anuncio no cumple funci&oacute;n alguna en el sitio?">Denunciar</a>
				{$splitter}
				{?( "{$from}" === "{$author}")?}
					<a href="mailto:{$reply_to}?subject=QUITAR {$id}">Quitar el anuncio</a> {$splitter}
				{/?}
				<a href="mailto:{$reply_to}?subject=COMPARTIR ANUNCIO {$id}">Compartir</a>
				</span>
			</span>
			</td>
			</tr></table>
		</td>
		</tr>
		</table>
	</td></tr>
[/$search_results]
</table>