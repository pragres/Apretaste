{= *AnswerSubject: Bienvenido a Apretaste! =}

{= menu: [
	{
		section: "Anuncios",
		desc: "Todo lo que puedes hacer con los anuncios",
		options: [
			{
				title: "Buscar auncios",
				subject: "BUSCAR poner aqui una frase de busqueda",
				body: ""
			},{
				title: "Buscar todos los anuncios relativos a una frase",
				subject: "BUSCAR poner aqui una frase de busqueda",
				body: ""
			},{
				title: "Publicar un anuncio",
				subject: "BUSCAR poner aqui una frase de busqueda",
				body: ""
			}
		]
	},{
		section: "Comunicaciones",
		desc: "Comun&iacute;cate con tus amigos y familiares",
		options: [
			{
				title: "Enviar un SMS",
				subject: "SMS [codigo del pais][numero de celular]",
				body: "Sobreescribe este texto para poner tu mensaje"
			},{
				title: "C&oacute;digos de los pa&iacute;ses",
				subject: "SMS CODIGOS",
				body: "Haz clic en Enviar(Send) para obtener los codigos"
			}
		]
	}
	
] =}

[$menu]
	{$h1}{$section}{$_h1}
	{$p}{$desc}{$_p}
	<ul>
		[$options]
		<li><a href="mailto:{$reply_to}?subject={$subject}&body={$body}">{$title}</a></li>
		[/$options]
	</ul>
[/$menu]

