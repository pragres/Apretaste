<?php

/**
 * Apretaste Sale Command
 *
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param unknown $images
 * @return array
 */
function cmd_sale($robot, $from, $argument, $body = '', $images = array()){
	$robot->log("$from need view a sale...");
	
	$from = trim(strtolower(Apretaste::extractEmailAddress($from)));
	$argument = explode(" ", trim($argument));
	$argument = $argument[0];
	$argument = trim($argument);
	
	$sale = ApretasteStore::getStoreSale($argument);
	
	if ($sale !== false) {
		
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
		
		return array(
				'answer_type' => 'sale',
				'sale' => $sale,
				'images' => $imgs
		);
	}
	
	return array(
			'answer_type' => 'sale_not_found',
			'sale_id' => $argument
	);
}