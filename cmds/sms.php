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
	$argument = trim($argument);

	if (! Apretaste::isUTF8($body))
		$body = utf8_encode($body);
		
	$body = quoted_printable_decode($body);
	$body = trim(strip_tags($body));
	
	$body = Apretaste::reparaTildes($body);
		
	if (trim($body) == '')
		return array(
				"answer_type" => "sms_empty_text",
				"number" => $argument
		);
	
	// Get country code
	$parts = ApretasteSMS::splitNumber($argument);
	
	if ($parts === false) {
		return array(
				"answer_type" => "sms_wrong_number",
				"number" => $argument,
				"message" => $body
		);
	}
	
	$code = $parts['code'];
	$number = $parts['number'];
	
	// Split message
	$msg = trim($body);
	
	$parts = ApretasteSMS::chopText($msg);
	
	$tparts = count($parts);
	
	// Get rate
	$discount = ApretasteSMS::getRate($code);
	
	// Verify credit
	$credit = ApretasteMoney::getCreditOf($from);
	
	if ($credit < $discount * $tparts) {
		// no credit
		return array(
				"answer_type" => "sms_wrong_number",
				"credit" => $credit,
				"discount" => $discount * $tparts,
				"smsparts" => $parts
		);
	}
	
	// Send message
	
	foreach ( $parts as $i => $part ) {
		$robot->log("Sending sms part $i - $part to $code - $number");
		ApretasteSMS::send($code, $number, $from, $part, $discount);
	}
	
	$newcredit = ApretasteMoney::getCreditOf($from);
	
	return array(
			"answer_type" => "sms_sended",
			"credit" => $credit,
			"newcredit" => $newcredit,
			"discount" => $discount,
			"smsparts" => $parts,
			"totaldiscount" => $discount * $tparts
	);
}
	
