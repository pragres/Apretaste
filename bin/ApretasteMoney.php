<?php

/**
 * Apretaste Money Management
 *
 * @author rafa <rafa@pragres.com>
 * 
 */
class ApretasteMoney {
	
	/**
	 * Recharge credit
	 *
	 * @param string $email
	 * @param float $amount
	 * @param string $code_redeemed
	 * @param string $payment_method
	 * @return boolean
	 */
	static function recharge($email, $amount, $code_redeemed = '', $payment_method = 'cc'){
		$amount = $amount * 1;
		
		$email = strtolower($email);
		
		Apretaste::query("INSERT INTO recharge (email,amount,code_redeemed,payment_method) VALUES
				('$email','$amount','$code_redeemed','$payment_method');");
		
		return true;
	}
		
	/**
	 * Returns the total of credits a user has
	 * @param unknown $email
	 * @return boolean number
	 */
	static function getCreditOf($email){
		
		$email = strtolower($email);
		
		$r = Apretaste::query("SELECT email, credit FROM credit WHERE email = '$email';");
		
		if (isset($r[0]))
			if (isset($r[0]['email']))
				if ($r[0]['email'] == $email)
					return $r[0]['credit'] * 1;
		
		return 0;
	}
	
	/**
	 * Return all discounts of a user
	 *
	 * @param string $email
	 * @param number $limit
	 * @param number $offset
	 * @return array
	 */
	static function getDiscountsOf($email, $limit = 100, $offset = 0){

		$email = strtolower($email);
		
		$r = Apretaste::query("SELECT * FROM discounts WHERE email = '$email';");
		
		return $r;
	}
}