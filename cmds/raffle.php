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
	$r = Apretaste::query("SELECT * FROM xraffles where active = true and closed = false limit 1;");
	
	$from = strtolower($from);
	
	if (isset($r[0])) {
		$r = $r[0];
		
		$total = Apretaste::query("SELECT count_user_raffle_tickets('{$r['id']}','$from') as total;");
		
		$r['description'] = Apretaste::repairUTF8($r['description']);
		
		return array(
				'command' => 'raffle',
				'answer_type' => 'raffle',
				'title' => "Rifa de Apretaste!",
				'description' => $r['description'],
				'date_from' => $r['date_from'],
				'date_to' => $r['date_to'],
				'total_tickets' => $total[0]['total'],
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
