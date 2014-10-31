<?php

/**
 * Apretaste Purchase Command
 *
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param unknown $images
 * @return array
 */
function cmd_purchase($robot, $from, $argument, $body = '', $images = array()){
	$robot->log("$from need buy something...");
	
	$from = trim(strtolower(Apretaste::extractEmailAddress($from)));
	$argument = explode(" ", trim($argument));
	$argument = $argument[0];
	$argument = trim($argument);
	
	$r = ApretasteStore::confirmPurchase($argument, $from);
	
	if ($r != APRETASTE_STORE_INVALID_USER_OR_CODE) {
		$sale = false;
		$purchase = q("SELECT * FROM store_purchase WHERE confirmation_code = '$r';");
		
		if (isset($purchase[0])) {
			
			$purchase = $purchase[0];
			
			$sale = ApretasteStore::getStoreSale($purchase['sale']);
			
			if (isset($sale[0]))
				$sale = $sale[0];
		}
		
		if ($sale['picture'] != '') {
			$sale['picture'] = Apretaste::resizeImage(base64_decode($sale['picture']), 100);
		}
		
		$imgs = array();
		
		if ($sale['picture'] !== '') {
			$imgs[] = array(
					"type" => "image/" . $sale['picture_type'],
					"content" => $sale['picture'],
					"name" => $sale["title"],
					"id" => "salepicture",
					"src" => "cid:salepicture"
			);
		}
	}
	
	switch ($r) {
		case APRETASTE_STORE_PURCHASE_ALREADY_CONFIRMED :
			
			return array(
					'answer_type' => 'purchase_already_confirmed',
					'purchase' => $purchase,
					'sale' => $sale,
					'images' => $imgs
			);
		
		case APRETASTE_STORE_UNKNOWN_ERROR :
			return array(
					"answer_type" => "buy_unknown_error"
			);
		case APRETASTE_INCORRECT_EMAIL_ADDRESS :
			
			$robot->log('Buy: incorrect email address');
			
			return array(
					'_answers' => array()
			);
		
		case APRETASTE_STORE_INVALID_USER_OR_CODE :
			return array(
					'answer_type' => 'purchase_invalid_code',
					'purchase' => $purchase,
					'sale' => $sale,
					'images' => $imgs
			);
	}
	
	return array(
			'answer_type' => 'purchase_successfull',
			'purchase' => $purchase,
			'sale' => $sale,
			'images' => $imgs
	);
}