<?php

/**
 * Get article from wikipedia
 *
 * @param string $query
 * @param string $argument
 * @param string $keyword
 * @return mixed
 */
function cmd_raffle($robot, $from, $argument, $body = '', $images = array()){
	$argument = trim($argument);
	$argument = Apretaste::replaceRecursive(" ", " ", $argument);
	$arguments = explode(" ", $argument);
	$argument = $arguments[0];
	
	
	$store = q("SELECT * FROM store_sale WHERE store = 'raffle_tickets' order by price;");
	
	// Buy a ticket
	if (strtolower($argument) == 'compra') {
		$robot->log("$from bought tickets", 'RAFFLE');
		if (isset($arguments[1])) {
			$code = $arguments[1];
			$robot->log("Checking confirmation code $code...", 'RAFFLE');
			if (ApretasteStore::checkConfirmationCode($code)) {
				
				$sale = ApretasteStore::getStoreSaleByConfirmationCode($code);
				if ($sale !== false) {
					
					$count = intval(trim(substr($sale['title'], 0, strpos($sale['title'], ' '))));
					
					$rf = q("SELECT * FROM xraffles where active = true and closed = false limit 1;");
					if (isset($rf[0])) {
						
						$rf = $rf[0];
						
						$robot->log("Generating $count tickets for $from in raffle = {$rf['id']}...", 'RAFFLE');
						
						for($i = 0; $i < $count; $i ++) {
							$ticket = uniqid() . "@generated.ticket.apretaste.com";
							$robot->log("- new ticket = $ticket", 'RAFFLE');
							q("INSERT INTO raffle_tickets (raffle,author,guest) VALUES ('{$rf['id']}','$from','$ticket');");
						}
						
						$total = q("SELECT count_user_raffle_tickets('{$rf['id']}','$from') as total;");
						$total = $total[0]['total'];
						
						return array(
							'answer_type' => 'raffle_tickets_bought',
							'tickets' => $total,
							'count' => $count,
							'store' => $store								
						);
						
					}
				}
			} else
				$robot->log("Ignoring confirmation code...", 'RAFFLE');
		}
	}
	
	$r = Apretaste::query("SELECT * FROM xraffles where active = true and closed = false limit 1;");
	
	$from = strtolower($from);
	
	if (isset($r[0])) {
		$r = $r[0];
		
		$total = q("SELECT count_user_raffle_tickets('{$r['id']}','$from') as total;");
		
		$r['description'] = htmlentities(ApretasteEncoding::fixUTF8($r['description']));
			
		
		return array(
				'command' => 'raffle',
				'answer_type' => 'raffle',
				'title' => "Rifa de Apretaste!",
				'description' => $r['description'],
				'date_from' => $r['date_from'],
				'date_to' => $r['date_to'],
				'total_tickets' => $total[0]['total'],
				'sharethis' => 'RIFA',
				'store' => $store,
				"images" => array(
						array(
								"type" => "image/jpeg",
								"content" => base64_decode($r['image']),
								"name" => "Rifa_de_Apretaste.jpg",
								"id" => "raffle_image",
								"src" => "cid:raffle_image"
						)
				)
		);
	}
	
	return array(
			'command' => 'raffle',
			'answer_type' => 'raffle_not',
			'title' => "No hay rifa en estos momentos"
	);
}
