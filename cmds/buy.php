<?php

/**
 * Apretaste Buy Command
 *
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param unknown $images
 * @return array
 */
function cmd_buy($robot, $from, $argument, $body = '', $images = array()){
	$robot->log("$from need buy something...");
	
	$from = trim(strtolower(Apretaste::extractEmailAddress($from)));
	$argument = explode(" ", trim($argument));
	$argument = $argument[0];
	$argument = trim($argument);
	
	$body = Apretaste::strip_html_tags($body);

	$r = ApretasteStore::purchase($argument, $from, $body);
	
	$robot->log("Buy result = $r");
	
	switch ($r) {
		case APRETASTE_STORE_SALE_NOT_FOUND :
			return array(
					"answer_type" => "buy_sale_not_found",
					"sale_id" => $argument
			);
		
		case APRETASTE_STORE_NOT_ENOUGHT_FUNDS :
			
			$sale = ApretasteStore::getStoreSale($argument);
			
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
			
			return array(
					'answer_type' => "buy_not_enought_funds",
					'credit' => ApretasteMoney::getCreditOf($from),
					'sale' => $sale,
					'images' => $imgs
			);
		
		case APRETASTE_INCORRECT_EMAIL_ADDRESS :
			
			$robot->log('Buy: incorrect email address');
			
			return array(
					'_answers' => array()
			);
		
		case APRETASTE_STORE_UNKNOWN_ERROR :
			return array(
					"answer_type" => "buy_unknown_error"
			);
	}
	
	$sale = false;
	$purchase = q("SELECT *, to_char(moment + '1 hour'::interval, 'YYYY-MM-DD HH12:MI PM') as expiration FROM store_purchase WHERE confirmation_code = '$r';");
	
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
	
	return array(
			'answer_type' => 'buy_successfull',
			'credit' => ApretasteMoney::getCreditOf($from),
			'confirmation_code' => $r,
			'sale' => $sale,
			'purchase' => $purchase,
			"images" => $imgs
	);
}