{= *AnswerSubject: "SMS enviado correctamente" =}
{$h1}{$AnswerSubject}{$_h1}
?$bodyextra
	<i>Se enviaron solamente los primeros 160 caracteres. El texto que aparece abajo en negrita no fue enviado:</i>
	{$p}Mensaje enviado:{$_p}
	{$p}{$bodysent}<b>{$bodyextra}</b> <a href="mailto:{$reply_to}?subject=SMS%20{$cellnumber}&body={&&bodyextra}">[clic aqu&iacute; para enviar el texto en negrita</a>]{$_p}
	{$p}Destinatario: {$br}<b>{$cellnumber}</b> <a href="mailto:{$reply_to}?subject=SMS%20{$cellnumber}&body={&&bodysent}">[enviar otro mensaje]</a>{$_p}
@else@
	{$p}Mensaje enviado:{$br} <b>{$bodysent}</b>{$_p}
	{$p}Destinatario: {$br}<b>{$cellnumber}</b> <a href="mailto:{$reply_to}?subject=SMS%20{$cellnumber}&body={&&bodysent}">[enviar otro mensaje]</a>{$_p}
$bodyextra?
{$p}Su cr&eacute;dito actual es de <b>${#newcredit:2.#}</b>.{$_p}
{$br}
{$h1}<span style="color:black;">&rArr; Apretaste!</span> es mucho m&aacute;s que SMS &iquest;Lo sab&iacute;as?</b>{$_h1}
{$p}
	Somos una pasarela de servicios por <i>email</i> que te permite:
	<ul>
		<li>Revisar <a href="mailto:{$reply_to}?subject=BUSCAR%20televisor%20lcd">que se compra y que se vende</a></li>  
		<li><a href="mailto:{$reply_to}?subject=TRADUCIR%20al%20ingles&body=Este es un texto que sera traducido al ingles">Traducir documentos</a> a varios idiomas</li>  
		<li>Leer <a href="mailto:{$reply_to}?subject=ARTICULO%20jose%20marti">material enciclop&eacute;dico</a></li>
		<li>Ver <a href="mailto:{$reply_to}?subject=MAPA%20capitolio,%20havana,%20cuba">mapas y lugares famosos</a></li> 
		<li>Seguir el <a href="mailto:{$reply_to}?subject=CLIMA">estado del tiempo</a></li>
		<li>Pasar un buen rato leyendo <a href="mailto:{$reply_to}?subject=CHISTE">chistes</a></li>
	</ul>
	entre muchos <a href="mailto:{$reply_to}?subject=SERVICIOS">otros servicios</a>; y todo desde tu email, sin necesidad de Internet. 
{$_p}
{$p}
	<b>&iquest;Ya lo sab&iacute;as? &iquest;Te gusta?</b> 
	<a href="mailto:{$reply_to}?subject=INVITAR%20amigo@direccion.cu&body=Cambie%20'amigo@direccion.cu'%20en%20el%20asunto%20por%20el%20email%20de%20su%20amigo%20y%20mande%20este%20correo">Comp&aacute;rtelo con tus amigos</a> 
	y -adem&aacute;s de hacer el bien- ganar&aacute;s tickets para nuestra
	<a href="mailto:{$reply_to}?subject=RIFA">rifa</a>.
{$_p}
