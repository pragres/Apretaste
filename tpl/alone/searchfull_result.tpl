<table width = "100%">
[$search_results]
	?$cota
		?$_is_first
			<tr><td><i>Solo se encontraron anuncios relacionados con <b>{$query}</b></i><br/><br/></td></tr>
		@else@
			<tr><td><hr/><h2 style="{$element-h2}"><i>Se encontraron anuncios relacionados con <b>{$query}</b></i></h2></td></tr>
		$_is_first?
		$cota?	
	<tr><td ?$_is_odd style = "background: #eeeeee; padding: 5px;" @else@ style = "background: white; padding: 5px;" $_is_odd?>
	<div class="anuncio">
		<table cellspacing = "0" cellpadding="0" width="100%">
			<tr>
				<td width = "5%">
                ?$tax  <a href="mailto:{$reply_to}?subject=BUSCAR {$tax}">{$tax}</a> {$separatorLinks} $tax?
				<a href = "mailto:{$reply_to}?subject=ANUNCIO {$id}&body=Presione o haga clic en Enviar para obtener el anuncio seleccionado." style="{$font}; font-size: 12px;"><b>{^title}</b></a>?$price {$separatorLinks} <label style="{$font};{$style-price}; width: 30px; text-align:right;">{$price}&nbsp;{$currency}</label> $price? &nbsp;|&nbsp;
				<span style="font-size: small;">
					?$phones Tel: <b>{$phones.0}</b> {$separatorLinks} $phones?				
					?$emails <a href ="mailto:{$emails.0}">{$emails.0}</a> {$separatorLinks} $emails?
					?$image <span style = "color: #5dbd00;">(foto)</span> {$separatorLinks} $image?
					{$post_date:10}
					{$separatorLinks} <a href="mailto:{$reply_to}?subject=COMPARTIR ANUNCIO {$id}">Compartir</a>
				</span>
				</td> 
			</tr>
		</table>
	</div>
	</td></tr>
[/$search_results]
</table>