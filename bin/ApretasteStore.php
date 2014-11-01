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
	static function addStore($owner, $name, $classification = 'Misc', $id = null){
		
		// Checking owner
		if (! Apretaste::checkAddress($owner))
			return false;
		
		if (is_null($id))
			$sql = "INSERT INTO store (owner, name, classification) VALUES ('$owner','$name', '$classification') RETURNING id;";
		else
			$sql = "INSERT INTO store (id, owner, name, classification) VALUES ('$id', '$owner','$name', '$classification') RETURNING id;";
		
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
	static function addSale($author, $deposit, $title, $desc, $price, $classif = 'Misc', $pic = null, $pic_type = 'jpeg', $callback = null, $store = null){
		// Checking author
		if (! Apretaste::checkAddress($author))
			return false;
			
			// Checking deposit
		if (! Apretaste::checkAddress($deposit))
			return false;
		
		$title = trim(str_replace("'", "''", $title));
		$desc = trim(str_replace("'", "''", $desc));
		$classif = trim(str_replace("'", "''", $classif));
		$callback = trim(str_replace("'", "''", $callback));
		
		$price *= 1;
		
		$sql = "INSERT INTO store_sale (author, deposit, title, description, price, classification, picture, picture_type, store, callback)
				VALUES ('$author','$deposit','$title','$desc',$price,'$classif','$pic','$pic_type','$store','$callback')
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
	static function purchase($sale, $buyer, $message = ''){
		self::clearPurchases();
		
		$sale = str_replace("''", "'", $sale);
		$message = str_replace("''", "'", $message);
		
		$rows = 0;
		
		if (Apretaste::checkAddress($buyer) || Apretaste::isDevelopmentMode()) {
			
			$error = null;
			
			$r = @q("INSERT INTO store_purchase (sale, buyer, message) VALUES ('$sale', '$buyer','$message') RETURNING confirmation_code;", $error, $rows, true);
			
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
		self::clearPurchases();
		
		$confirmation_code = str_replace("''", "'", $confirmation_code);
		$rows = 0;
		if (Apretaste::checkAddress($buyer) || Apretaste::isDevelopmentMode()) {
			
			$error = false;
			
			$r = @q("UPDATE store_purchase SET bought = true WHERE buyer = '$buyer' AND confirmation_code = '$confirmation_code';", $error, $rows, true);
			
			if ($error !== false) {
				if (! is_null($error)) {
					switch ($error->err_code) {
						case 3 :
							return APRETASTE_STORE_PURCHASE_ALREADY_CONFIRMED;
						case 4 :
							return APRETASTE_STORE_INVALID_USER_OR_CODE;
						default :
							return APRETASTE_STORE_UNKNOWN_ERROR;
					}
				} else
					return APRETASTE_STORE_UNKNOWN_ERROR;
			}
			
			var_dump($rows);
			
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
		q("DELETE FROM store_purchase WHERE moment + '30 minutes'::interval < now() and bought = false;");
	}
	static function getStoreSale($id){
		$r = q("SELECT * FROM store_sale WHERE id='$id';");
		if (! isset($r[0]))
			return false;
		return $r[0];
	}
	static function getStore($id){
		$r = q("SELECT * FROM store WHERE id='$id';");
		if (! isset($r[0]))
			return false;
		return $r[0];
	}
}