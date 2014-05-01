{= *AnswerSubject: $title =}
<h1 style="{$font}">Sudoku</h1>
<p align="justify" style="{$font}"><b>Instrucciones</b>: Rellene las celdas vac&iacute;as con un n&uacute;mero del <b>1 al 9</b>
de tal forma <b>que no se repitan</b> en cada columna, fila y cuadrante. 
Los cuadrantes est&aacute;n delimitados por los borders negros.
</p>
<table><tr><td style="font-family: Arial,Helvetica,sans-serif;background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;">
<a style="mouse:pointer;{$font};background: green; color: white; padding: 5px;text-decoration: none;font-weight: bold;" href="mailto:{$reply_to}?subject=SUDOKU">
<label style="margin: 5px;">Otro Sudoku!</label>
</a>
</td></tr></table>
<p style="{$font}">Despl&aacute;cese hacia abajo para ver la soluci&oacute;n</p>
<p style="{$font}"><a href="mailto:{$reply_to}?subject=ARTICULO sudoku">Clic aqu&iacute; para conocer m&aacute;s sobre este juego</a></p> 
<hr/>
  
<h2 style="{$font}">Completar desde su correo</h2>

<!--[if mso ]>
<p>Usted est&aacute; usando una versi&oacute;n posterior a Outlook 2007, por lo que posiblemente no pueda responder el sudoku en esta ventana. Si observa arriba hay un enlace de Outlook que empieza diciendo <i>"Si hay problemas con el modo en que se muestra este mensaje,..."</i>. Haga clic en ese mensaje para abrir el sudoku en un navegador web.</p>
<![endif]-->

{$problem}
<hr/>
<h2 style="{$font}">Imprimir</h2>
{$problem_print}
<hr/>
<br/><br/><br/>
<h2 style="{$font}">Soluci&oacute;n</h2>
{$solution}
<br/>