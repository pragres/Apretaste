<?php

/**
 * Apretaste!com Joke Command
 *
 * @author rafa <rafa@pragres.com>
 * @version 2.0
 *         
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param array $images
 * @return array
 */
function cmd_joke($robot, $from, $argument, $body = '', $images = array()){
	for($i = 0; $i < 10; $i ++) { // 10 intentos por si acaso falla
	                              // $page = file_get_contents("http://localhost/chiste.xml");
		$page = file_get_contents("http://feeds.feedburner.com/ChistesD4w?format=xml");
				
		$mark = '<description>';
		$jokes = array();
		$last_pos = 0;
		
		do {
			$p1 = strpos($page, $mark, $last_pos);
			if ($p1 !== false) {
				$p2 = strpos($page, '</description>', $p1);
				$joke = substr($page, $p1 + strlen($mark), $p2 - $p1 - strlen($mark));
				$j = $joke;
				
				$j = Apretaste::repairUTF8($j);
				$j = html_entity_decode($j);
				$p = strpos($j, '<br xml:base="');
				
				if ($p !== false)
					$j = substr($j, 0, $p);
				
				$p = strpos($j, '<a href="http://chistes.developers4web.com/');
				
				if ($p !== false)
					$j = substr($j, 0, $p);
				
				$j = str_replace("/ ", " ", $j);
				$j = nl2br($j);
				
				$joke = trim($j);
				
				$joke = wordwrap($joke, 200, "\n");
				
				if (strlen($joke) > 30)
					if (stripos($joke, ' the') == false)
						if (stripos($joke, 'the ') == false)
							$jokes[] = $joke;
				
				$last_pos = $p2;
			}
		} while ( $p1 !== false );
				
		if (isset($jokes[1])) {
			
			$j = $jokes[mt_rand(1, count($jokes) - 1)];
			
			echo $robot->log("JOKE = ".$j);
			
			return array(
					"answer_type" => "joke",
					"command" => "joke",
					"title" => "Un chiste, un chiste!",
					"joke" => $j,
					"compactmode" => true
			);
		}
	}
}
