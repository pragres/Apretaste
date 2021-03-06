<?php

/**
 * Apretaste!com Translate Command
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 *         
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param array $images
 * @return array
 */
function cmd_translate($robot, $from, $argument, $body = '', $images = array()) {
	$argument = ' ' . trim ( $argument ) . ' ';
	$argument = str_ireplace ( ' a ', '', $argument );
	$argument = str_ireplace ( ' de ', '', $argument );
	$argument = str_ireplace ( ' del ', '', $argument );
	$argument = str_ireplace ( ' al ', '', $argument );
	$argument = trim ( $argument );
	
	$argument = Apretaste::reparaTildes ( $argument );
	
	$langs = array (
			"auto" => "auto",
			"es" => "espanol",
			"en" => "ingles",
			"it" => "italiano",
			"fr" => "frances",
			"pt" => "portugues",
			"de" => "aleman",
			"ru" => "ruso",
			"ko" => "coreano",
			"af" => "afrikaans",
			"sq" => "albanes",
			"ar" => "arabe",
			"hy" => "armenio",
			"az" => "azerbaiyani",
			"bn" => "bengali",
			"be" => "bielorruso",
			"bs" => "bosnio",
			"bg" => "bulgaro",
			"ca" => "catalan",
			"ceb" => "cebuano",
			"cs" => "checo",
			"zh-CN" => "chino simplificado",
			"zh-TW" => "chino tradicional",
			"ht" => "criollo haitiano",
			"hr" => "croata",
			"da" => "danes",
			"sk" => "eslovaco",
			"sl" => "esloveno",
			"eo" => "esperanto",
			"et" => "estonio",
			"tl" => "filipino",
			"fi" => "finlandes",
			"cy" => "gales",
			"gl" => "gallego",
			"ka" => "georgiano",
			"el" => "griego",
			"gu" => "gujarati",
			"ha" => "Hausa",
			"iw" => "hebreo",
			"hi" => "hindi",
			"hmn" => "hmong",
			"nl" => "holandes",
			"hu" => "hungaro",
			"ig" => "igbo",
			"id" => "indonesio",
			"ga" => "irlandes",
			"is" => "islandes",
			"ja" => "japones",
			"jw" => "javanes",
			"km" => "jemer",
			"kn" => "kannada",
			"lo" => "lao",
			"la" => "latin",
			"lv" => "leton",
			"lt" => "lituano",
			"mk" => "macedonio",
			"ms" => "malayo",
			"mt" => "maltes",
			"mi" => "maori",
			"mr" => "marati",
			"mn" => "mongol",
			"ne" => "nepales",
			"no" => "noruego",
			"fa" => "persa",
			"pl" => "polaco",
			"pa" => "punjabi",
			"ro" => "rumano",
			"sr" => "serbio",
			"so" => "somali",
			"sv" => "sueco",
			"sw" => "swahili",
			"th" => "tailandes",
			"ta" => "tamil",
			"te" => "telugu",
			"tr" => "turco",
			"uk" => "ucraniano",
			"ur" => "urdu",
			"eu" => "vasco",
			"vi" => "vietnamita",
			"yi" => "yiddish",
			"yo" => "yoruba",
			"zu" => "zulu" 
	);
	
	$blangs = array (
			"auto" => "Autom&aacute;tico",
			"es" => "Espa&ntilde;ol",
			"en" => "Ingl&eacute;s",
			"it" => "Italiano",
			"fr" => "Franc&eacute;s",
			"pt" => "Portugu&eacute;s",
			"de" => "Alem&aacute;n",
			"sq" => "Alben&eacute;s",
			"ar" => "&Aacute;rabe",
			"az" => "Azerbaiyan&iacute;",
			"bn" => "Bengal&iacute;",
			"bg" => "B&uacute;lgaro",
			"ca" => "Catal&aacute;n",
			"da" => "Dan&eacute;s",
			"fi" => "Finland&eacute;s",
			"cy" => "Gal&eacute;s",
			"gu" => "Gujarat&iacute;",
			"nl" => "Holand&eacute;s",
			"hu" => "H&uacute;ngaro",
			"ga" => "Irland&eacute;s",
			"is" => "Island&eacute;s",
			"ja" => "Japon&eacute;s",
			"jw" => "Javan&eacute;s",
			"la" => "Lat&iacute;n",
			"lv" => "Let&oacute;n",
			"mt" => "Malt&eacute;s",
			"mi" => "Maor&iacute;",
			"mr" => "Marat&iacute;",
			"ne" => "Nepal&eacute;s",
			"pa" => "Punjab&iacute;",
			"so" => "Somal&iacute;",
			"th" => "Tailand&eacute;s",
			"zu" => "Zul&uacute;" 
	);
	
	$hls = array (
			"auto" => "es-419" 
	);
	
	foreach ( $langs as $lang => $lname ) {
		
		if (! isset ( $hls [$lang] ))
			$hls [$lang] = 'es-419';
		
		if (! isset ( $blangs [$lang] ))
			$blangs [$lang] = ucfirst ( $lname );
	}
	
	$language = trim ( strtolower ( $argument ) );
	$languages = explode ( " ", $language );
	
	// defaults
	$lfrom = 'auto';
	$lto = 'es';
	
	if (isset ( $languages [0] ) && isset ( $languages [1] )) {
		$lfrom = array_search ( $languages [0], $langs );
		if ($lfrom === false)
			$lfrom = 'auto';
		
		$lto = array_search ( $languages [1], $langs );
		if ($lto === false)
			$lto = 'es';
	}
	
	if (isset ( $languages [0] ) && ! isset ( $languages [1] )) {
		$lto = array_search ( $languages [0], $langs );
		if ($lto === false)
			$lto = 'es';
	}
	
	if (! isset ( $langs [$lfrom] ) || ! isset ( $langs [$lto] ))
		return array (
				"answer_type" => "translate",
				"command" => "translate",
				"error" => true,
				"missing_text" => true,
				"wrong_lang" => false,
				"language" => $language,
				"title" => "No se pudo traducir",
				"textto" => '',
				"textfrom" => '',
				"compactmode" => true 
		);
	
	$hl = $hls [$lfrom];
	
	$text = $body;
	
	// Clean the text
	$robot->log ( "Cleanning/Decoding the text.." );
	
	if (! Apretaste::isUTF8 ( $text )) {
		$robot->log ( "Text is not UTF8, encoding to UTF8..." );
		$text = Apretaste::utf8Encode ( $text );
	}
	
	$text = quoted_printable_decode ( $body );
	
	$text = Apretaste::cleanText ( $text );
	
	$text = html_entity_decode ( $text, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1' );
	
	if ($text == '') {
		$robot->log ( "Text is empty after clear, try another strategy..." );
		if (! Apretaste::isUTF8 ( $body ))
			$text = Apretaste::utf8Encode ( $body );
		
		$text = quoted_printable_decode ( $body );
		
		if (! Apretaste::isUTF8 ( $text ))
			$text = Apretaste::utf8Encode ( $text );
	}
	
	$robot->log ( "Translating: $text" );
	
	// No text
	if ($text == '')
		return array (
				"answer_type" => "translate",
				"command" => "translate",
				"error" => true,
				"missing_text" => true,
				"wrong_lang" => false,
				"language" => $language,
				"title" => "No se pudo traducir",
				"textto" => '',
				"textfrom" => '',
				"compactmode" => true 
		);
	
	$textoobig = false;
	$limit = 1000;
	if (strlen ( $text ) > $limit) {
		$text = substr ( $text, 0, $limit );
		$textoobig = true;
	}
	
	// Translating...
	if ($lfrom == 'auto') {
		
		$robot->log ( "Detecting language..." );
		
		$url = "http://translate.google.com/translate_a/t?client=t&sl=auto&tl={$lto}&hl={$hl}&sc=2&ie=UTF-8&oe=UTF-8&oc=13&otf=2&ssel=3&tsel=6&q=" . cmd_translate_urlencode ( $text );
		
		$robot->log ( $url, "URL" );
		$json = file_get_contents ( utf8_encode ( $url ) );
		
		$json = div::jsonDecode ( $json );
		
		$lfrom = $json [2];
		
		if (! isset ( $langs [$lfrom] ))
			$lfrom = 'es';
		
		$robot->log ( "The language of text is -$lfrom-" );
		
		if (isset ( $hls [$lfrom] ))
			$hl = $hls [$lfrom];
		
		if ($lfrom == $lto) {
			if ($lfrom == 'es') {
				$lto = 'en';
			} else
				$lto = 'es';
			
			$robot->log ( "Redefine the 'to language' as $lto" );
		}
	}
	
	$robot->log ( "Translating the text with Google Translator from -$lfrom- to -$lto-..." );
	
	$url = "http://translate.google.com/translate_a/t?client=t&sl={$lfrom}&tl={$lto}&hl={$hl}&sc=2&ie=UTF-8&oe=UTF-8&oc=13&otf=2&ssel=3&tsel=6&q=" . cmd_translate_urlencode ( $text );
	
	$robot->log ( $url, "URL" );
	
	$json = file_get_contents ( utf8_encode ( $url ) );
	
	// echo "\n\n JSON: $json\n\n";
	
	if (! Apretaste::isUTF8 ( $json ))
		$json = utf8_encode ( $json );
	
	$arr = div::jsonDecode ( $json ); // uso este metodo porque la funcion de php no sirve
	
	$robot->log ( "Compiling results..." );
	
	$result = parse_google_translator_response ( $arr );
	
	// Send the answer
	$robot->log ( "Sending the translated text..." );
	
	if ($lto == 'ru') {
		
		$rtto = '';
		
		foreach ( $arr [0] as $sentence ) {
			$rtto .= $sentence [2];
		}
		
		$result ['textto'] = $rtto;
		$result ['richtextfrom'] = false;
		$result ['richtextto'] = false;
	}
	
	return array (
			"answer_type" => "translate",
			"command" => "translate",
			"language" => $language,
			"lto" => $lto,
			"lfrom" => $lfrom,
			"blto" => $blangs [$lto],
			"blfrom" => $blangs [$lfrom],
			"title" => "Resultado de traducir '" . substr ( $result ['textfrom'], 0, 20 ) . "...' al " . $blangs [$lto],
			"ltitle" => substr ( $result ['textfrom'], 0, 20 ) . "...' al " . $blangs [$lto],
			"textto" => $result ['textto'],
			"textfrom" => quoted_printable_decode ( $body ),
			"richtextto" => $result ['richtextto'],
			"richtextfrom" => $result ['richtextfrom'],
			"meanings" => $result ['meanings'],
			"compactmode" => true,
			"variants" => $result ['variants'],
			"toobig" => $textoobig 
	);
}

/**
 * Analyzing the Google Translator response
 *
 * @param array $response        	
 * @return array
 */
function parse_google_translator_response($response) {
	$textfrom = '';
	$textto = '';
	
	$parts = array ();
	
	$j = 0;
	
	$meanings = array ();
	
	if (isset ( $response [1] ))
		if (is_array ( $response [1] ))
			$meanings = $response [1];
	
	$meaninghtml = '';
	
	foreach ( $meanings as $meaning ) {
		$meaninghtml .= "<b>" . Apretaste::cleanText ( $meaning [0] ) . "</b><br/><ul>";
		foreach ( $meaning [1] as $k => $mean ) {
			$meaninghtml .= '<li><i>' . Apretaste::cleanText ( $mean ) . '</i>: ' . Apretaste::cleanText ( implode ( " / ", $meaning [2] [$k] [1] ) ) . '</li>';
		}
		$meaninghtml .= '</ul>';
	}
	
	if (isset ( $response [5] ))
		foreach ( $response [5] as $textpart ) {
			
			$part = $textpart [0];
			$part = str_replace ( " ?", "?", $part );
			$part = str_replace ( " .", ".", $part );
			$part = str_replace ( " !", "!", $part );
			$tips = array ();
			
			if (is_array ( $textpart [2] ))
				foreach ( $textpart [2] as $word )
					$tips [] = Apretaste::cleanText ( $word [0] );
			
			$parts [] = array (
					"text" => Apretaste::cleanText ( $part ),
					"textto" => Apretaste::cleanText ( $textpart [2] [0] [0] ),
					"tips" => $tips,
					"alldata" => $textpart 
			);
		}
	
	$original = '';
	if (is_array ( $response [0] ))
		foreach ( $response [0] as $k => $v ) {
			$original .= Apretaste::cleanText ( $v [1] );
			$v0 = Apretaste::cleanText ( $v [0] );
			$v1 = Apretaste::cleanText ( $v [1] );
			$textto .= $v0;
			$textfrom .= $v1;
		}
	
	$richtextto = '';
	$richtextfrom = '';
	
	$variants = '';
	$i = 0;
	foreach ( $parts as $part ) {
		
		$vv = $part ['text'];
		
		$lastp = null;
		
		if (strlen ( $vv ) > 1) {
			
			// random color
			$rgb = 'rgb(' . mt_rand ( 100, 250 ) . ',' . mt_rand ( 100, 250 ) . ',' . mt_rand ( 100, 250 ) . ');';
			
			// positions
			$p1 = $part ['alldata'] [3] [0] [0];
			$p2 = $part ['alldata'] [3] [0] [1];
			
			if (! is_null ( $lastp ))
				if ($p1 - $lastp - 1 > 0) {
					$richtextfrom .= substr ( $original, $lastp, $p1 - $lastp - 1 );
					$richtextto .= substr ( $original, $lastp, $p1 - $lastp - 1 );
				}
			$richtextfrom .= '<a style="cursor: pointer; border: 3px solid ' . $rgb . ';text-decoration: none;color:black;background: ' . $rgb . '" title="' . implode ( " / ", $part ['tips'] ) . '" href="' . implode ( " / ", $part ['tips'] ) . '">' . htmlentities ( cmd_translate_special_chars ( $part ['text'] ), 2 | 0, 'UTF-8', false ) . '</a>&nbsp;' . "\n";
			$richtextto .= '<a style="cursor: pointer; border: 3px solid ' . $rgb . ';text-decoration: none;color:black;background: ' . $rgb . '" title="' . implode ( " / ", $part ['tips'] ) . '" href="' . implode ( " / ", $part ['tips'] ) . '">' . htmlentities ( cmd_translate_special_chars ( $part ['textto'] ), 2 | 0, 'UTF-8', false ) . '</a>&nbsp;' . "\n";
			
			$lastp = $p2;
			
			$vv = trim ( str_replace ( array (
					"\n",
					"\r" 
			), "", trim ( "$vv" ) ) );
			
			if (strlen ( $vv ) > 1) {
				
				$variants .= "<a href=\"mailto:{\$reply_to}?subject=TRADUCIR&body=$vv\"><b>$vv</b></a>: ";
				foreach ( $part ['tips'] as $tip ) {
					$tip = str_replace ( array (
							"\n",
							"\r" 
					), "", trim ( $tip ) );
					
					if (strlen ( $tip ) > 1)
						$variants .= "<a href=\"mailto:{\$reply_to}?subject=TRADUCIR&body=$tip\">" . $tip . "</a>,\n";
				}
				$variants .= '{$br}';
			}
		} else {
			$richtextfrom .= $vv;
			$richtextto .= $part ['textto'];
		}
	}
	
	if ($i % 3 != 0)
		$variants .= '</tr>';
	$variants .= '</table>';
	
	$richtextfrom = str_replace ( " ,", ",", $richtextfrom );
	$richtextto = str_replace ( " ,", ",", $richtextto );
	
	return array (
			"textfrom" => $textfrom,
			"textto" => $textto,
			"richtextto" => $richtextto,
			"richtextfrom" => $richtextfrom,
			"variants" => $variants,
			"meanings" => $meaninghtml 
	);
}
function cmd_translate_fix_text($text) {
	if (! Apretaste::isUTF8 ( $text ))
		$text = utf8_encode ( $text );
	
	$text = html_entity_decode ( $text, ENT_COMPAT, 'UTF-8' );
	$text = htmlentities ( $text );
	
	return $text;
}
function cmd_translate_urlencode($text) {
	$text = str_replace ( "\n\r", "\n", $text );
	$text = str_replace ( "\r\n", "\n", $text );
	$text = str_replace ( "\n", " ", $text );
	$text = str_replace ( "\t", " ", $text );
	$text = str_replace ( "  ", " ", $text );
	$text = str_replace ( "  ", " ", $text );
	$text = str_replace ( "  ", " ", $text );
	$text = str_replace ( " ", "%20", $text );
	
	return $text;
}
function cmd_translate_special_chars($text) {
	return $text;
	
	/*
	 * $l = strlen($text); $ntext = ''; for($i=1025; $i<=1169;$i++){ $text = str_replace(chr($i),'&#'.$i.';',$text); } return htmlspecialchars($text,null,'KOI8-R',false);
	 */
}