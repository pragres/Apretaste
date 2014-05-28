<div class="anuncio" style="{$font}">
{$br}
{$h1}{$title}{$_h1}{$br}
    <table width="100%" style="{$font}">
        <tr>
            <td valign="top">
                <table style="{$font}">
                    <tr>
                        <td valign="top">
                            ?$image
                            <img style="float: left; padding: 3px; margin-right: 10px; background-color: white; border: 2px solid #C1C1C1;max-height:300px;" width="300" height="300" alt="imagen" src="{$image_src}" />
                            $image?
                        </td>
                        <td valign="top">
                                        Identificador: <strong>{$id}</strong><br>
                                        ?$author_name
                                        Contactar con: <strong>{$author_name}</strong><br/>
                                        $author_name?
                                        ?$price
                                        Precio: <span style="{$style-price}">{$price}&nbsp;{$currency}</span><br/>
                                        $price?
                                        ?$phones
                                        Tel&eacute;fono{?( {$phones}>1 )?}s{/?}:
                                        <strong>[$phones]{$value}!$_is_last, $_is_last![/$phones]</strong><br/>
                                        $phones?
                                        ?$emails
                                        Email(s):
                                        [$emails]
                                        <a href ="mailto:{$value}">{$value}</a>&nbsp;
                                        <a href="mailto:{$reply_to}?subject={$value}" title="Buscar anuncios con esta direcci&oacute;n" style="{$font};font-size:9px;color:gray;text-decoration: none;">[?]</a>&nbsp;
                                        <a href="mailto:{$reply_to}?subject=ALERTA {$value}" title="Seguir los anuncios con esta direcci&oacute;n" style="{$font};font-size:9px;color:gray;text-decoration: none;">[&gt;&gt;]</a>
                                        !$_is_last, $_is_last!
                                        [/$emails]
                                        <br/>
                                        $emails?
                                        
                                        ?$post_date
                                        Fecha: <strong>{$post_date:10}</strong><br/>
                                        $post_date?

                                        ?$hits
                                        Veces visto: <strong>{$hits}</strong> <br/>
                                        $hits?

                                        ?$appears
                                        Veces encontrado: <strong>{$appears}</strong> <br/>
                                        $appears?

                            <span style="font-size: small;font-size: small; float: left; margin-top: 0px;">
                                {?( "{$from}" === "{$author}")?}
                                <a href="mailto:{$reply_to}?subject=QUITAR {$ticket}">Quitar el anuncio</a>
                                @else@
                                <a href="mailto:{$reply_to}?subject=DENUNCIAR {$id}&body=Haga clic en Enviar para denunciar el anuncio" title="&iquest;Piensa que este anuncio no cumple funci&oacute;n alguna en el sitio?">Denunciar</a>
                                {/?}
                            </span>
                        </td>
                    </tr>
                </table>

                {$hr}
                ?$body
                {$body}
                $body?
            </td>
        </tr>
    </table>
</div>