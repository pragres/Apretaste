<?php

/**
 * Apretaste SMS Services
 *
 * @author Administrador
 *        
 */
class ApretasteSMS {
	
	/**
	 * Send a SMS
	 *
	 * @param string $prefix
	 * @param string $number
	 * @param string $sender Email of sender
	 * @param string $message
	 * @return string
	 */
	static function send($prefix, $number, $sender, $message, $discount){
		
		$login = "salvi.pascual@pragres.com";
		$password = "UncleSalvi";
		
		$URL = "http://api.smsacuba.com/api10allcountries.php?";
		$URL .= "login=" . $login . "&password=" . $password . "&prefix=" . $prefix . "&number=" . $number . "&sender=" . $sender . "&msg=" . urlencode($message);
		
		$r = @file($URL);
		
		Apretaste::query("INSERT INTO sms (email, phone, message, discount)
				VALUES ('$sender', '(+$prefix)$number', '$message', $discount);");
		
		return $r[0];
	}
	
	/**
	 * Cuts a big text in small portions of 160 characters to send it
	 *
	 * @param string $text
	 * @return array
	 */
	static function chopText($text){
		$parts = array();
		
		while ( true ) {
			if (isset($text[160])) {
				$parts[] = substr($text, 0, 160);
				$text = substr($text, 160);
			} else {
				$parts[] = $text;
				break;
			}
		}
		
		return $parts;
	}
	
	/**
	 *
	 * @param unknown $number
	 * @return multitype:string
	 */
	static function splitNumber($number){
		$number = trim($number);
		
		$code = '53';
		
		if ($number[0] == '+')
			$number = substr($number, 1);
		
		return array(
				'code' => $code,
				'number' => $number
		);
	}
	static function getRate($code){
		$code = $code * 1;
		if ($code == 53)
			return 0.05;
		return 0.1;
	}
}