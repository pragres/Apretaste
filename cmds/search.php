<?php

/**
 * Apretaste!com Search Command
 *
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param array $images
 * @param number $limit
 * @param string $wimages
 * @return mixed
 */
function cmd_search($robot, $from, $argument, $body = '', $images = array(), $limit = 10, $wimages = true){
	if (trim($argument) == '') {
		$argument = trim($body);
		$argument = str_replace("\n", " ", $argument);
		$argument = str_replace("\r", "", $argument);
		$argument = trim($argument);
	}
	
	$query = $argument;
	
	$filter = array();
	
	if (stripos($body, 'con foto y telefono') !== false && stripos($body, 'con telefono y foto') !== false) {
		$filter['phone'] = true;
		$filter['photo'] = true;
	}
	if (stripos($body, 'con foto') !== false)
		$filter['photo'] = true;
	if (stripos($body, 'con telefono') !== false)
		$filter['phone'] = true;
	
	$robot->log("Searching: $query ");
	
	if (strlen(trim($query)) <= 2)
		return array(
				"command" => "search",
				"answer_type" => "empty_phrase",
				"from" => $from
		);
	
	$t1 = microtime(true);
	
	$r = Apretaste::search($query, $limit, 0, true, $from, null, null, $filter);
	
	$t2 = microtime(true);
	
	$data = array(
			'command' => 'search',
			'answer_type' => 'search_results',
			'from' => $from,
			'query' => $query,
			'search_results' => $r['results'],
			'total' => $r['total'],
			'title' => "Resultado de buscar <a title=\"Haga clic en la frase para volver a buscar\" style=\"color:black;\" href=\"mailto:{\$reply_to}?subject=BUSCAR $query\"><i>{$query}</i></a>",
			'limit' => $limit,
			'dwords' => $r['dwords'],
			'time_search' => number_format($t2 - $t1, 5),
			'compactmode' => $r['total'] < 1,
			'recommended_phrases' => $r['recommended_phrases'],
			'forweb' => false,
			'alerta' => false,
			'pricing' => $r['pricing'],
			'allads' => $r['allads']
	);
	
	$data['image_src'] = 'cid:{$id}';
	$data['images'] = array();
	
	if (! $r['ads_of_author']) {
		$q = Apretaste::didYouMean($query);
		$data['related_phrases'] = Apretaste::getRelatedPhrases($query, $q);
		if (Apretaste::reparaTildes($q) != Apretaste::reparaTildes($query))
			$data['didyoumean'] = $q;
	} else {
		$data['showminimal'] = true;
		$wimages = false;
	}
	
	$r = $r['results'];
	
	if ($limit <= 10 && $wimages) {
		
		if (is_array($r))
			foreach ( $r as $k => $item ) {
				if (isset($item['image'])) {
					if ("{$item['image']}" != '') {
						
						if (isset($item['image_type']))
							$item['image_type'] = str_replace("image/", "", $item['image_type']);
						if (! isset($data['images']))
							$data['images'] = array();
						$data['images'][] = array(
								"type" => "image/{$item['image_type']}",
								"content" => base64_decode($item['image']),
								"name" => $item['image_name'],
								"id" => $item['id']
						);
						$data['search_results'][$k]['image'] = true;
					} else {
						$data['search_results'][$k]['image'] = false;
					}
				} else {
					$data['search_results'][$k]['image'] = false;
				}
			}
	}
	
	echo "[INFO] " . count($data['images']) . " images\n";
	
	$tip = Apretaste::randomTip();
	if ($tip)
		$data["sections"] = array(
				array(
						"title" => "Consejos &uacute;tiles",
						"content" => htmlentities(Apretaste::utf8Decode($tip['tip']))
				)
		);
	
	$data['sharethis'] = 'BUSCAR ' . $argument;
	
	return $data;
}