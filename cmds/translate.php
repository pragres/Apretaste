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
function cmd_translate($robot, $from, $argument, $body = '', $images = array()){
	$langs = array(
			"auto" => "auto",
			"es" => "espanol",
			"en" => "ingles",
			"it" => "italiano",
			"fr" => "frances",
			"pt" => "portugues"
	);
	
	$blangs = array(
			"auto" => "Autom&aacute;tico",
			"es" => "Espa&ntilde;ol",
			"en" => "Ingl&eacute;s",
			"it" => "Italiano",
			"fr" => "Franc&eacute;s",
			"pt" => "Portugu&eacute;s"
	);
	
	$hls = array(
			"auto" => "es-419",
			"es" => "es-419",
			"en" => "es-419",
			"it" => "es-419",
			"fr" => "es-419",
			"pt" => "es-419"
	);
	
	$language = trim(strtolower($argument));
	$languages = explode(" ", $language);
	
	// defaults
	$lfrom = 'auto';
	$lto = 'es';
	
	if (isset($languages[0]) && isset($languages[1])) {
		$lfrom = array_search($languages[0], $langs);
		if ($lfrom === false)
			$lfrom = 'auto';
		
		$lto = array_search($languages[1], $langs);
		if ($lto === false)
			$lto = 'es';
	}
	
	if (isset($languages[0]) && ! isset($languages[1])) {
		$lto = array_search($languages[0], $langs);
		if ($lto === false)
			$lto = 'es';
	}
	
	if (! isset($langs[$lfrom]) || ! isset($langs[$lto]))
		return array(
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
	
	$hl = $hls[$lfrom];
	
	// Clean the text
	$robot->log("Cleanning/Decoding the text..");
	$text = strip_tags($body);
	$text = ApretasteEncoding::fixUTF8($text);
	$text = html_entity_decode($text);
	$text = Apretaste::reparaTildes($text);
	$text = substr(iconv_mime_decode("From: $text", ICONV_MIME_DECODE_CONTINUE_ON_ERROR, "ISO-8859-1"), 6);
	$text = quoted_printable_decode($text);
	$text = trim($text);
	
	// No text
	if ($text == '')
		return array(
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
		
		// Translating...
	if ($lfrom == 'auto') {
		
		$robot->log("Detecting language...");
		
		$url = "http://translate.google.com/translate_a/t?client=t&sl={$lfrom}&tl={$lto}&hl={$hl}&sc=2&ie=UTF-8&oe=UTF-8&oc=13&otf=2&ssel=3&tsel=6&q=" . urlencode($text);
		$robot->log($url, "URL");
		$json = file_get_contents($url);
		$json = div::jsonDecode($json);
		$lfrom = $json[2];
		$robot->log("The language of text is -$lfrom-");
		$hl = $hls[$lfrom];
		
		if ($lfrom == $lto) {
			if ($lfrom == 'es') {
				$lto = 'en';
			} else
				$lto = 'es';
			
			$robot->log("Redefine the 'to language' as $lto");
		}
	}
	
	$robot->log("Translating the text with Google Translator from -$lfrom- to -$lto-...");
	
	$url = "http://translate.google.com/translate_a/t?client=t&sl={$lfrom}&tl={$lto}&hl={$hl}&sc=2&ie=UTF-8&oe=WINDOWS-1252&oc=13&otf=2&ssel=3&tsel=6&q=" . urlencode($text);
	$robot->log($url, "URL");
	$json = file_get_contents($url);
	$arr = div::jsonDecode($json); // uso este metodo porque la funcion de php no sirve
	
	$robot->log("Compiling results...");
	
	$result = parse_google_translator_response($arr);
	
	// Send the answer
	$robot->log("Sending the translated text...");
	
	return array(
			"answer_type" => "translate",
			"command" => "translate",
			"language" => $language,
			"lto" => $lto,
			"lfrom" => $lfrom,
			"blto" => $blangs[$lto],
			"blfrom" => $blangs[$lfrom],
			"title" => "Resultado de traducir '" . substr($result['textfrom'], 0, 20) . "...' al " . $blangs[$lto],
			"textto" => $result['textto'],
			"textfrom" => $result['textfrom'],
			"richtextto" => $result['richtextto'],
			"richtextfrom" => $result['richtextfrom'],
			"meanings" => $result['meanings'],
			"compactmode" => true,
			"variants" => $result['variants']
	);
}

/**
 * Analyzing the Google Translator response
 *
 * @param array $response
 * @return array
 */
function parse_google_translator_response($response){
	$textfrom = '';
	$textto = '';
	
	$parts = array();
	
	$j = 0;
	
	$meanings = array();
	
	if (isset($response[1]))
		if (is_array($response[1]))
			$meanings = $response[1];
	
	$meaninghtml = '';
	
	foreach ( $meanings as $meaning ) {
		$meaninghtml .= "<b>{$meaning[0]}</b><br/><ul>";
		foreach ( $meaning[1] as $k => $mean ) {
			$meaninghtml .= '<li><i>' . $mean . '</i>: ' . implode(" / ", $meaning[2][$k][1]) . '</li>';
		}
		$meaninghtml .= '</ul>';
	}
	
	if (isset($response[5]))
		foreach ( $response[5] as $textpart ) {
			
			$part = $textpart[0];
			$part = str_replace(" ?", "?", $part);
			$part = str_replace(" .", ".", $part);
			$part = str_replace(" !", "!", $part);
			$tips = array();
			
			if (is_array($textpart[2]))
				foreach ( $textpart[2] as $word )
					$tips[] = htmlentities($word[0]);
			
			$parts[] = array(
					"text" => cmd_translate_fix_text($part),
					"textto" => cmd_translate_fix_text($textpart[2][0][0]),
					"tips" => $tips,
					"alldata" => $textpart
			);
		}
	
	$original = '';
	foreach ( $response[0] as $k => $v ) {
		$original .= $v[1];
		$v0 = htmlentities($v[0]);
		$v1 = htmlentities($v[1]);
		$textto .= $v0;
		$textfrom .= $v1;
	}
	
	$richtextto = '';
	$richtextfrom = '';
	
	$variants = '<table width="100%"><tr>';
	$i = 0;
	foreach ( $parts as $part ) {
		
		$vv = $part['text'];
		
		$lastp = null;
		
		if (strlen($vv) > 1) {
			
			// random color
			$rgb = 'rgb(' . mt_rand(100, 250) . ',' . mt_rand(100, 250) . ',' . mt_rand(100, 250) . ');';
			
			// positions
			$p1 = $part['alldata'][3][0][0];
			$p2 = $part['alldata'][3][0][1];
			
			if (! is_null($lastp))
				if ($p1 - $lastp - 1 > 0) {
					$richtextfrom .= substr($original, $lastp, $p1 - $lastp - 1);
					$richtextto .= substr($original, $lastp, $p1 - $lastp - 1);
				}
			$richtextfrom .= '<a style="cursor: pointer; padding: 3px;background: ' . $rgb . '" title="' . implode(" / ", $part['tips']) . '" href="mailto:{$reply_to}?subject=TRADUCIR&body=' . $part['text'] . '">' . htmlentities($part['text']) . '</a>&nbsp;';
			$richtextto .= '<a style="cursor: pointer; padding: 3px;background: ' . $rgb . '" title="' . implode(" / ", $part['tips']) . '" href="mailto:{$reply_to}?subject=TRADUCIR&body=' . $part['textto'] . '">' . htmlentities($part['textto']) . '</a>&nbsp;';
			
			$lastp = $p2;
			
			$vv = trim(str_replace(array(
					"\n",
					"\r"
			), "", trim("$vv")));
			
			if (strlen($vv) > 1) {
				$i ++;
				if ($i == 1)
					$variants .= '</tr>';
				
				$variants .= "<td width=\"33%\" style=\"border-bottom: 1px solid #dddddd; border-right: 1px solid #dddddd; \" valign=\"top\">\n<a href=\"mailto:{\$reply_to}?subject=TRADUCIR&body=$vv\"><b>$vv</b></a>: <ol style=\"margin:0px;\">";
				foreach ( $part['tips'] as $tip ) {
					$tip = str_replace(array(
							"\n",
							"\r"
					), "", trim($tip));
					
					if (strlen($tip) > 1)
						$variants .= "<li><a href=\"mailto:{\$reply_yo}?subject=TRADUCIR&body=$tip\">$tip</a></li>";
				}
				$variants .= '</ol></td>';
				
				if ($i == 3) {
					$variants .= '</tr>' . "\n";
					$i = 0;
				}
			}
		} else {
			$richtextfrom .= htmlentities($vv);
			$richtextto .= htmlentities($part['textto']);
		}
	}
	
	if ($i % 3 != 0)
		$variants .= '</tr>';
	$variants .= '</table>';
	
	$richtextfrom = str_replace(" ,", ",", $richtextfrom);
	$richtextto = str_replace(" ,", ",", $richtextto);
	
	return array(
			"textfrom" => $textfrom,
			"textto" => $textto,
			"richtextto" => $richtextto,
			"richtextfrom" => $richtextfrom,
			"variants" => $variants,
			"meanings" => $meaninghtml
	);
}
function cmd_translate_fix_text($text){
	return htmlentities(ApretasteEncoding::fixUTF8($text));
}