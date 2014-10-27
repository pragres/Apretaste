<?php

/**
 * Apretaste Store
 *
 * Generic stores
 *
 * @author rafa <rafa@pragres.com>
 *        
 */
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
}