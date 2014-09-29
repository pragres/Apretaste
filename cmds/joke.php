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
	$id = trim($argument) * 1;
	
	if ($id > 0) {
		
		$robot->log("Getting JOKE #$id ");
		
		$jj = Apretaste::query("SELECT * FROM cache_jokes where id = $id;");
		
		if (isset($jj[0]))
			$j = $jj[0]['joke'];
		
	} else {
		
		// for($i = 0; $i < 10; $i ++) { // 10 intentos por si acaso falla
		// $page = file_get_contents("http://localhost/chiste.xml");
		
		$robot->log("Trying a JOKE ");
		
		$page = @file_get_contents("http://feeds.feedburner.com/ChistesD4w?format=xml");
		
		if ($page == false) {
			echo "[ERROR] Jokes source not work!\n";
		}
		
		$mark = '<description>';
		$jokes = array();
		$last_pos = 0;
		
		do {
			$p1 = strpos($page, $mark, $last_pos);
			if ($p1 !== false) {
				$p2 = strpos($page, '</description>', $p1);
				$joke = substr($page, $p1 + strlen($mark), $p2 - $p1 - strlen($mark));
				$j = $joke;
				
				// $j = Apretaste::repairUTF8($j);
				
				$j = html_entity_decode($j, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
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
		
		$j = 'El rey hace un pase de visita a los soldados de guardia y al primero le pregunta: <br/>
			- A ver ¿por que un soldado de la guardia real tiene que cumplir su tarea ante cualquier 
			circunstancia?! <br/>Y el soldado le responde: <br/> - Si chico, a ver porque eh?! porque eh?!';
		
		if (isset($jokes[1])) {
			
			$j = $jokes[mt_rand(1, count($jokes) - 1)];
			
			$robot->log("JOKE = " . $j);
			$jj = str_replace("'", "''", $j);
			
			Apretaste::query("INSERT INTO cache_jokes (joke) 
			SELECT '$jj' AS joke 
			WHERE NOT EXISTS(SELECT * FROM cache_jokes WHERE joke = '$jj');");
		} else {
			
			// read from cache
			
			$jj = Apretaste::query("SELECT * FROM cache_jokes ORDER BY random() LIMIT 1;");
			
			if (isset($jj[0]))
				$j = $jj[0]['joke'];
		}
		
		// Get id of joke
		$jj = Apretaste::query("SELECT id FROM cache_jokes where joke = '" . str_replace("''", "'", $j) . "';");
		$id = $jj[0]['id'];
	}
	
	return array(
			"answer_type" => "joke",
			"command" => "joke",
			"title" => "Un chiste, un chiste!",
			"joke" => $j,
			"sharethis" => 'CHISTE ' . $id,
			"compactmode" => true
	);
	// }
}
