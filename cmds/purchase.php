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
	
	$answer = null;
	
	$r = ApretasteStore::confirmPurchase($argument, $from, $answer);
	
	$purchase = false;
	$sale = false;
	
	if ($r !== APRETASTE_STORE_INVALID_USER_OR_CODE) {
		
		$purchase = q("SELECT * FROM store_purchase WHERE confirmation_code = '$argument';");
		
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
		
		$a = Apretaste::getAuthor($sale['author'], false, 50);
		
		if ($sale['author'] == $sale['deposit'])
			$sale['deposit'] = false;
		else {
			$sale['deposit'] = Apretaste::getAuthor($sale['deposit'], false, 50);
		}
		
		$sale['author'] = $a;
		
		$imgs[] = array(
				"type" => 'image/jpeg',
				"content" => base64_decode($sale['author']['picture']),
				"name" => $sale['author']["name"],
				"id" => "authorpicture",
				"src" => "cid:authorpicture"
		);
		
		if ($sale['deposit'] !== false) {
			$imgs[] = array(
					"type" => 'image/jpeg',
					"content" => base64_decode($sale['deposit']['picture']),
					"name" => $sale['deposit']["name"],
					"id" => "depositpicture",
					"src" => "cid:depositpicture"
			);
		}
	}
	
	if ($r !== true) {
		switch ($r) {
			case APRETASTE_STORE_PURCHASE_ALREADY_CONFIRMED :
				if ($purchase['buyer'] != $from && $purchase !== false)
					return array(
							'answer_type' => 'purchase_invalid_code',
							'purchase' => $purchase,
							'confirmation_code' => $argument,
							'sale' => $sale,
							'images' => $imgs
					);
				else
					return array(
							'answer_type' => 'purchase_already_confirmed',
							'purchase' => $purchase,
							'confirmation_code' => $argument,
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
				
				$sale = ApretasteStore::getStoreSaleByConfirmationCode($argument);
				
				return array(
						'answer_type' => 'purchase_invalid_code',
						'confirmation_code' => $argument,
						'sale' => $sale // array or false
				);
		}
	}
	
	$answer['_to'] = $from;
	$answer['command'] = 'purchase';
	$answer['from'] = $from;
	
	return array(
			'_answers' => array(
					/*array(
							'answer_type' => 'purchase_successfull',
							'purchase' => $purchase,
							'sale' => $sale,
							'images' => $imgs,
							'from' => $from,
							'credit' => ApretasteMoney::getCreditOf($from),
							'command' => 'purchase',
							'_to' => $from
					),*/
					$answer
			),
			'_to' => $from,
			'command' => 'purchase',
			'from' => $from
	);
}
