<?php
function cmd_raffle($robot, $from, $argument, $body = '', $images = array()){
	$r = Apretaste::query("SELECT * FROM xraffles where active = true and closed = false limit 1;");
	
	if (isset($r[0])) {
		$r = $r[0];
		return array(
				'command' => 'raffle',
				'answer_type' => 'raffle',
				'title' => "Rifa de Apretaste!",
				'description' => $r['description'],
				'date_from' => $r['date_from'],
				'date_to' => $r['date_to'],
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
}