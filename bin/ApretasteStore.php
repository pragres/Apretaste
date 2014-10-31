<?php

/**
 * Apretaste Store
 *
 * Generic stores
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
define('APRETASTE_STORE_NOT_ENOUGHT_FUNDS', 'APRETASTE_STORE_NOT_ENOUGHT_FUNDS');
define('APRETASTE_STORE_SALE_NOT_FOUND', 'APRETASTE_STORE_SALE_NOT_FOUND');
define('APRETASTE_STORE_UNKNOWN_ERROR', 'APRETASTE_STORE_UNKNOWN_ERROR');
define('APRETASTE_STORE_PURCHASE_ALREADY_CONFIRMED', 'APRETASTE_STORE_PURCHASE_ALREADY_CONFIRMED');
define('APRETASTE_STORE_INVALID_USER_OR_CODE', 'APRETASTE_STORE_INVALID_USER_OR_CODE');
class ApretasteStore {
	
	/**
	 * Add new store
	 *
	 * @param string $owner
	 * @param string $name
	 * @param string $classification
	 *
	 * @return mixed
	 */
	static function addStore($owner, $name, $classification = 'Misc'){
		
		// Checking owner
		if (! Apretaste::checkAddress($email))
			return false;
		
		$sql = "INSERT INTO store (owner, name, classification) VALUES ('$owner','$name', '$classification') RETURNING id;";
		
		$r = @q($sql);
		
		if (! isset($r[0]['id']))
			return false;
		
		return $r[0]['id'];
	}
	
	/**
	 * Add sale
	 *
	 * @param string $author Who
	 * @param string $deposit
	 * @param string $title
	 * @param string $desc
	 * @param float $price
	 * @param string $from_date
	 * @param string $to_date
	 * @param number $quantity
	 * @param string $classif
	 * @param string $pic
	 * @param string $pic_type
	 * @param string $store
	 */
	static function addSale($author, $deposit, $title, $desc, $price, $from_date = null, $to_date = null, $quantity = 1, $classif = 'Misc', $pic = null, $pic_type = 'jpeg', $store = null){
		// Checking author
		if (! Apretaste::checkAddress($author))
			return false;
			
			// Checking deposit
		if (! Apretaste::checkAddress($deposit))
			return false;
		
		$title = trim(str_replace("'", "'", $title));
		$desc = trim(str_replace("'", "'", $desc));
		$classif = trim(str_replace("'", "'", $classif));
		
		$price *= 1;
		
		if (is_null($from_date))
			$from_date = date('Y-m-d h:i:s');
		
		if (is_null($to_date))
			$to_date = 'null';
		else
			$to_date = "'$to_date'::TIMESTAMP WITHOUT TIME ZONE";
		
		$from_date = "'$from_date'::TIMESTAMP WITHOUT TIME ZONE";
		
		$quantity *= 1;
		
		$sql = "INSERT INTO store_sale (author, deposit, title, description, price, from_date, to_date, quantity, classification, picture, picture_type)
				VALUES ('$author','$deposit','$title','$desc',$price,$from_date,$to_date,$quantity,'$classif','$pic','$pic_type')
				RETURNING id;";
		
		$r = @q($sql);
		
		return $r[0]['id'];
	}
	
	/**
	 * Purchase
	 *
	 * @param string $sale
	 * @param string $buyer
	 * @return boolean
	 */
	static function purchase($sale, $buyer){
		self::clearPurchases();
		
		$sale = str_replace("''", "'", $sale);
		$rows = 0;
		
		if (Apretaste::checkAddress($buyer) || Apretaste::isDevelopmentMode()) {
			
			$error = null;
			
			$r = @q("INSERT INTO store_purchase (sale, buyer) VALUES ('$sale', '$buyer') RETURNING confirmation_code;", $error, $rows, true);
			
			if ($error !== false) {
				if (! is_null($error)) {
					switch ($error->err_code) {
						case 1 :
							return APRETASTE_STORE_SALE_NOT_FOUND;
						
						case 2 :
							return APRETASTE_STORE_NOT_ENOUGHT_FUNDS;
							break;
						
						default :
							return APRETASTE_STORE_UNKNOWN_ERROR;
					}
				} else
					return APRETASTE_STORE_UNKNOWN_ERROR;
			}
			
			return $r['0']['confirmation_code'];
		}
		
		return APRETASTE_INCORRECT_EMAIL_ADDRESS;
	}
	
	/**
	 * Confirm purchase
	 *
	 * @param string $confirmation_code
	 * @param string $buyer
	 * @return mixed
	 */
	static function confirmPurchase($confirmation_code, $buyer){
		$sale = str_replace("''", "'", $sale);
		$rows = 0;
		if (Apretaste::checkAddress($buyer) || Apretaste::isDevelopmentMode()) {
			
			$error = null;
			
			$r = @q("UPDATE store_purchase SET bought = true WHERE buyer = '$buyer' AND confirmation_code = '$confirmation_code';", $error, $rows, true);
			
			if ($error !== false) {
				
				if (! is_null($error)) {
					switch ($error->err_code) {
						case 4 :
							return APRETASTE_STORE_PURCHASE_ALREADY_CONFIRMED;
							break;
						default :
							return APRETASTE_STORE_UNKNOWN_ERROR;
					}
				} else
					return APRETASTE_STORE_UNKNOWN_ERROR;
			} else
				return APRETASTE_STORE_UNKNOWN_ERROR;
			
			$rows = pg_affected_rows($r);
			
			if ($rows < 1)
				return APRETASTE_STORE_INVALID_USER_OR_CODE;
			
			return true;
		} else
			return APRETASTE_INCORRECT_EMAIL_ADDRESS;
	}
	
	/**
	 * Clear purchases
	 */
	static function clearPurchases(){
		q("DELETE FROM store_purchase WHERE moment + '30 minutes'::interval < now();");
	}
	static function getStoreSale($id){
		$r = q("SELECT * FROM store_sale WHERE id='$id';");
		if (! isset($r[0]))
			return false;
		return $r[0];
	}
}