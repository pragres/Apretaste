{= splitter: " | " =}
<!--{  Preparing the data }-->

?$showminimal 
	{= tpl: "searchfull_result" =}
@else@
	{= tpl: "search_result" =}
$showminimal?

<!--{  Show the result statistics }-->
?$limit 
	?$search_results
		<p style = "margin-top: 0px;font-size:12px; color: gray;" align="right">
		{?( {$limit} > {$search_results} )?} 
			{$search_results} 
		@else@ 
			{$limit} 
		{/?} de {$total}
		{?( {$total} > 1 )?} 
		anuncios encontrados 
		@else@ 
		anuncio encontrado 
		{/?} 
		en {#time_search:2,#} segundos  
		</p>
	$search_results?
$limit?

<!--{  Show the did you mean tip }-->
?$didyoumean
	<p>Quiz&aacute;s quiso decir o desee buscar: 
	?$forweb 
		?$full
		<a href = "{$WWW}{$BACK_PATH}?full=true&subject={$didyoumean}">{$didyoumean}</a>
		@else@
		<a href = "{$WWW}{$BACK_PATH}?subject={$didyoumean}">{$didyoumean}</a>
		$full?
	@else@
		<a href = "mailto:{$reply_to}?subject=BUSCAR {$didyoumean}&body=Le sugerimos buscar '{$didyoumean}'. Haga clic en Enviar para obtener los resultados.">{$didyoumean}</a>
	$forweb?
	</p>
$didyoumean?

<!--{  Show the search results }-->
?$search_results
	{% tpl %}
        
@else@
	<p style="{$font}">Su b&uacute;squeda "<strong>{$query}</strong>" no produjo resultados.</p>
$search_results?

<hr/>
?$pricing
					<h2 style="margin-top: 0px; margin-bottom: 0px; font-size: 20px; color: green;{$font}">Precios</h2><br/>
					<table align="center">
						<tr>
							<!--{<th style="border-right: 1px solid gray;">Altos</th>}-->
							[$pricing] price =>
							?$price.0
							<td style="{$font}; font-size: 14px; color: black; ">$<strong>{$price.0}</strong> &nbsp; </td>
							$price.0?
							[/$pricing]
						</tr>
					</table>
					<br/>
					$pricing?
					<br/>
                    ?$related_phrases
                    <h2 style="margin-top: 0px; margin-bottom: 0px; font-size: 20px; color: green;{$font}">Lo que otros usuarios han buscado</h2>
                    <br/>                      
                        [$related_phrases]
                        <a title = "Clic para buscar con esta frase" href="mailto:{$reply_to}?subject=BUSCAR {$phrase}&body=Haga clic en Enviar para buscar">{$phrase}</a>
                        !$_is_last {$splitter} $_is_last!
                        [/$related_phrases]
                    $related_phrases?
                    <br/><br/>
                    <!--{  Show the another distinctive ad's words }-->
					<br/>
                    {?( {$limit} < {$total} )?}
                            ?$dwords
                                    <h2 style="margin-top: 0px; margin-bottom: 0px; font-size: 20px; color: green;">Puede ser m&aacute;s preciso</h2>
                                    
                                    <p align = "justify" style="{$font}">
                                            Para encontrar resultados m&aacute;s espec&iacute;ficos puede utilizar
                                            las siguientes palabras en su frase de b&uacute;squeda:
                                    </p>
                                    {= url_search: mailto:{$reply_to}?body=Haga clic en Enviar para obtener los resultados&subject={$query} =}
	
                                    [$dwords]
                                            <a href="{$url_search} {$value}">{$value}</a> 
                                            !$_is_last {$splitter} $_is_last!
                                    [/$dwords]
                                    
                            $dwords?
                    {/?}
                    <br/>
                    	
					?$recommended_phrases
						<br/>
                        <h2 style="margin-top: 0px; margin-bottom: 0px;	font-size: 20px; color: green;{$font};">B&uacute;squedas recomendadas</h2>
                        <br/>
                        [$recommended_phrases]
                            <a style="{$font};" title = "Clic para buscar con esta frase" href="mailto:{$reply_to}?subject=BUSCAR {$value}&body=Haga clic en Enviar para buscar">{$value}</a>
                            !$_is_last {$splitter} $_is_last!
                        [/$recommended_phrases]
   
                 $recommended_phrases?
                
        <!--{
		[$allads]
			{$nanotitle} ({$cant})<br/>
		[/$allads]
		}-->