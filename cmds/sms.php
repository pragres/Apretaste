<?php

/**
 * Apretaste SMS Service
 *
 * @param unknown $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param array $images
 * @return array
 */
function cmd_sms($robot, $from, $argument, $body = '', $images = array()){
	$propaganda = array(
			"-SMS Enviado x Apretaste!",
			"-SMS Envia2 x Apretaste!",
			"-Enviado x Apretaste!",
			"-Envia2 x Apretaste!",
			"-SMS x Apretaste",
			"-Apretaste SMS!"
	);
	
	$body = str_replace("\n", " ", $body);
	$body = str_replace("\r", " ", $body);
	$body = str_replace("  ", " ", $body);
	
	$codes = ApretasteSMS::getCountryCodes();
	
	asort($codes);
	
	$as_plain_text = false;
	
	if (strpos($from, '@nauta.cu') !== false)
		$as_plain_text = true;
	
	$argument = trim($argument);
	
	if (strtolower($argument) == 'codigos') {
		return array(
				"answer_type" => "sms_codes",
				"codes" => $codes,
				"as_plain_text" => $as_plain_text
		);
	}
	
	if (! Apretaste::isUTF8($body))
		$body = utf8_encode($body);
	
	$body = quoted_printable_decode($body);
	$body = trim(Apretaste::strip_html_tags($body));
	$body = Apretaste::removeTildes($body);
	$body = Apretaste::replaceRecursive("  ", " ", $body);
	$body = Apretaste::replaceRecursive("--", "-", $body);
	
	$body = trim($body);
	
	if (trim($body) == '')
		return array(
				"answer_type" => "sms_empty_text",
				"number" => $argument,
				"as_plain_text" => $as_plain_text
		);
		
		// Remove ugly chars
	
	$n = '';
	$l = strlen($argument);
	for($i = 0; $i < $l; $i ++)
		if (strpos('1234567890', $argument[$i]) !== false)
			$n .= $argument[$i];
	
	$argument = $n;
	
	// Get country code
	
	$parts = ApretasteSMS::splitNumber($argument);
	
	if ($parts === false) {
		
		return array(
				"answer_type" => "sms_wrong_number",
				"number" => $argument,
				"message" => $body,
				"codes" => $codes,
				"credit" => ApretasteMoney::getCreditOf($from),
				"as_plain_text" => $as_plain_text
		);
	}
	
	$code = $parts['code'];
	$number = $parts['number'];
	
	// Split message
	$msg = trim($body);
	
	// $parts = ApretasteSMS::chopText($msg);
	// $tparts = count($parts);
	$parts = array(
			substr($body, 0, 160)
	);
	
	$tparts = 1;
	
	// Get rate
	$discount = ApretasteSMS::getRate($code);
	
	// Verify credit
	$credit = ApretasteMoney::getCreditOf($from);
	
	$c = Apretaste::getConfiguration("sms_free", false);
	
	if ($c == true)
		$discount = 0;
	
	if ($credit < $discount * $tparts && $c == false) {
		// no credit
		return array(
				"answer_type" => "sms_not_enought_funds",
				"credit" => $credit,
				"discount" => $discount * $tparts,
				"smsparts" => $parts,
				"as_plain_text" => $as_plain_text
		);
	}
	
	// Send message
	
	foreach ( $parts as $i => $part ) {
		$robot->log("Sending sms part $i - $part to $code - $number");
		
		foreach ( $propaganda as $prop ) {
			if (strlen($part) + strlen($prop) <= 160) {
				$part .= $prop;
				break;
			}
		}
		
		if (! Apretaste::isSimulator()) {
			$r = ApretasteSMS::send($code, $number, $from, $part, $discount);
			if ($r !== 'sms enviado') {
				
				$robot->log('SMS not sent! Server return "' . $r . '"');
				
				return array(
						"answer_type" => "sms_not_sent"
				);
			}
		}
	}
	
	$bodyextra = false;
	$bodysent = $body;
	
	if (strlen($body) > 160) {
		$bodyextra = substr($body, 160);
		$bodysent = substr($body, 0, 160);
	}
	
	$newcredit = ApretasteMoney::getCreditOf($from);
	
	return array(
			"answer_type" => "sms_sent",
			"credit" => $credit,
			"newcredit" => $newcredit,
			"discount" => $discount,
			"smsparts" => $parts,
			"bodyextra" => $bodyextra,
			"bodysent" => $bodysent,
			"totaldiscount" => $discount * $tparts,
			"as_plain_text" => $as_plain_text,
			"cellnumber" => "(+$code)$number"
	);
}
	
