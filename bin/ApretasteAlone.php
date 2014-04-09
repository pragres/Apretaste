<?php

/**
 * Apretaste!com Stand Alone
 *
 * @author rafa <rafa@pragres.com>
 *        
 */
class ApretasteAlone {
	
	/**
	 * Run
	 *
	 * @param array $params
	 */
	static function Run($params){
		if (! isset($params[0]))
			$params[0] = "robot";
		if (isset($_SERVER['argv'][2]))
			$_SERVER['argv'][1] = $_SERVER['argv'][2];
		eval("self::" . $params[0] . "();");
	}
	
	/**
	 * Processor of email
	 */
	static function robot(){
		echo "[INFO] Connecting to database...\n";
		Apretaste::connect();
		
		echo "[INFO] Cleanning the ads and search history...\n";
		Apretaste::query("delete from search_history where host='127.0.0.1' and email='';");
		Apretaste::query("delete from announcement where author = '' or author is null;");
		
		echo "[INFO] Running the robot...\n";
		$robot = new ApretasteEmailRobot($autostart = false, $verbose = true);
		Apretaste::$robot = &$robot;
		$robot->start();
		
		// self::shipment($robot);
	}
	static function shipment($robot = null){
		if (is_null($robot)) {
			$robot = new ApretasteEmailRobot($autostart = false, $verbose = true);
			Apretaste::$robot = &$robot;
		}
		
		echo "[INFO] Alert's shipment ...\n";
		Apretaste::shipment($robot);
	}
	
	/**
	 * Clean old words
	 */
	static function cleanWords(){
		Apretaste::connect();
		
		if (isset($_SERVER['argv'][1]))
			$max = $_SERVER['argv'][1];
		else
			$max = 100;
		
		Apretaste::query("delete from word where popularity <= 0 ;");
		
		$r = Apretaste::query("select count(*) as cant from word where updated_date <> CURRENT_DATE");
		
		$cant = $r[0]['cant'];
		if ($cant > 500)
			$cant = 500;
		echo "[INFO] $cant words! \n";
		
		$j = 0;
		
		for($i = 0; $i < $cant; $i ++) {
			
			$r = Apretaste::query("select word from word where updated_date <> CURRENT_DATE limit 1;");
			
			$word = $r[0]['word'];
			
			$w = trim($word);
			$w = str_replace(array(
					"0",
					"1",
					"2",
					"3",
					"4",
					"5",
					"6",
					"7",
					"8",
					"9"
			), "", $w);
			
			if ($w == "") {
				Apretaste::query("update word set popularity = 0, updated_date = CURRENT_DATE where word = '$word';");
				$j ++;
			} else {
				$r = Apretaste::query("select count(*) as cant from announcement where title || ' ' || body ~* '$word';");
				$appears = intval("{$r[0]['cant']}");
				if ($appears == 0)
					
					$j ++;
				Apretaste::query("update word set popularity = $appears, updated_date = CURRENT_DATE where word = '$word';");
				echo "[INFO] $j of $max will be deleted, $i word processed ($word -- $appears) \n";
			}
			
			if ($j >= $max)
				break;
		}
		
		Apretaste::query("delete from word where popularity <= 0 ;");
		
		echo "[INFO] $j words was deleted \n";
	}
	
	/**
	 * Calculate distinctive words
	 */
	static function distinctive(){
		echo "[INFO] Connecting... \n";
		
		Apretaste::connect();
		
		if (isset($_SERVER['argv'][1]))
			$max = $_SERVER['argv'][1];
		else
			$max = 100;
		
		$r = Apretaste::query("select id from announcement where distinctive_word_date <> current_date or distinctive_word is null order by distinctive_word_date limit $max;");
		
		if (is_array($r))
			foreach ( $r as $ad ) {
				echo "[INFO] Distinctive word for {$ad['id']} \n";
				Apretaste::query("update announcement set distinctive_word = get_best_representation(split_keywords(title || ' ' || body)), distinctive_word_date = current_date where id = '{$ad['id']}';");
			}
		
		echo "[INFO] Finished " . count($r) . " ad upadted with their distinctive word \n";
	}
	
	/**
	 * Fix phone numbers
	 */
	static function fixphones(){
		echo "[INFO] Connecting... \n";
		
		Apretaste::connect();
		
		if (isset($_SERVER['argv'][1]))
			$max = $_SERVER['argv'][1];
		else
			$max = 100;
		
		$r = Apretaste::query("SELECT * from announcement
			where (phones is null or phones = '') and random()<random()
					order by post_date desc
					limit $max;");
		
		$cant = count($r);
		$fixed = 0;
		echo "[INFO] $cant ads will be proccessed | max = $max \n";
		
		foreach ( $r as $i => $a ) {
			$a['phones'] = trim("{$a['phones']}");
			if ($a['phones'] == "") {
				$phones = Apretaste::getPhonesFrom($a['title'] . ' ' . $a['body'] . ' ');
				if (trim($phones) != "") {
					$sql = "update announcement set phones = '$phones' where id = '{$a['id']}';";
					
					Apretaste::query($sql);
					if (isset($a['extrenal_id']))
						if (trim("{$a['extrenal_id']}") == '') {
							Apretaste::saveAuthor($a['author'], array(
									'phones' => $phones
							));
						}
						// echo "[SQL] $sql \n";
					$fixed ++;
					echo "[INFO] $fixed fixed of $cant / Fix {$a['id']} / $i of $cant / $phones\n";
				}
			}
		}
		
		echo "[INFO] Finished, $fixed ads fixed!";
	}
	
	/**
	 * Fix the prices
	 */
	static function fixprices(){
		echo "[INFO] Connecting... \n";
		
		Apretaste::connect();
		
		if (isset($_SERVER['argv'][1]))
			$max = $_SERVER['argv'][1];
		else
			$max = 100;
		
		$r = Apretaste::query("SELECT * from announcement
			where (price is null or price = 0) and random() < random()
					order by post_date desc
					limit $max;");
		
		$cant = count($r);
		$fixed = 0;
		echo "[INFO] $cant ads will be proccessed | max = $max \n";
		
		foreach ( $r as $i => $a ) {
			$prices = Apretaste::getPricesFrom($a['title'] . ' ' . $a['body'] . ' ');
			if (isset($prices[0])) {
				$sql = "update announcement set price = '{$prices[0]['value']}', currency = '{$prices[0]['currency']}' where id = '{$a['id']}';";
				Apretaste::query($sql);
				// echo "[SQL] $sql \n";
				$fixed ++;
				echo "[INFO] $fixed fixed of $cant / Fix {$a['id']} / $i of $cant / {$prices[0]['value']} {$prices[0]['currency']}\n";
			}
		}
		
		echo "[INFO] Finished, $fixed ads fixed!";
	}
	
	/**
	 * Delete duplicated ads
	 */
	static function killduplicated($depth = false){
		echo "[INFO] Connecting... \n";
		Apretaste::connect();
		$cant = 0;
		$goods = array();
		$bads = array();
		
		if (isset($_SERVER['argv'][1]))
			$max = $_SERVER['argv'][1];
		else
			$max = 100;
		
		echo "[INFO] Disable historial if is it enabled... \n";
		$enable_history = false;
		$v = Apretaste::getConfiguration('enable_history');
		if ($v === true) {
			Apretaste::setConfiguration('enable_history', false);
			$enable_history = true;
		}
		
		// Clear database
		echo "[INFO] Prepare to kill all duplicated ads MAX = $max... \n";
		
		// $table = "t" . uniqid();
		// $tablegood = "tgood" . uniqid();
		// echo "[INFO] Creating temporary table $table... \n";
		// Apretaste::query("CREATE TABLE $table (id varchar primary key);");
		// echo "[INFO] Creatgin temporary table good $tablegood... \n";
		// Apretaste::query("CREATE TABLE $tablegood (id varchar primary key);");
		
		$tokill = 0;
		
		// $r = Apretaste::query("SELECT count(*) as cant FROM announcement");
		
		$rr = Apretaste::query("select count(id), title, CASE WHEN author ~ 'in.revolico.net' THEN 'revolico' ELSE author END as xauthor  from announcement group by title, xauthor having count(id)>1 limit $max;");
		if ($rr)
			foreach ( $rr as $item ) {
				$title = str_replace("'", "''", $item['title']);
				echo "[INFO] Buscando duplicados de {$title}\n";
				$item['xauthor'] = str_replace("'", "''", $item['xauthor']);
				// $item['title'] = str_replace("'","''",$item['title']);
				
				$sql = "select CASE WHEN author ~ 'in.revolico.net' THEN 'revolico' ELSE author END as xauthor,* from announcement where title = '{$title}' and CASE WHEN author ~ 'in.revolico.net' THEN 'revolico' ELSE author END = '{$item['xauthor']}' order by external_id is not null, post_date desc;";
				
				$r = Apretaste::query($sql);
				
				$goods[$r[0]['id']] = true; // Apretaste::query("INSERT INTO $tablegood VALUES ('{$r[0]['id']}');");
				echo "[INFO] " . (count($r) - 1) . " duplicados, dejamos {$r[0]['id']} \n";
				$first = true;
				foreach ( $r as $ann ) {
					if ($first === false) {
						// $e = Apretaste::query("SELECT * FROM $table WHERE id = '{$ann['id']}';");
						// if (!$e) {
						if (! isset($bads[$ann['id']])) {
							echo "[INFO] Preparing to kill the ad {$ann['id']} ... \n";
							// Apretaste::query("INSERT INTO $table VALUES ('{$ann['id']}');");
							$tokill ++;
							Apretaste::query_queue("DELETE FROM announcement WHERE id = '{$ann['id']}';");
							$bads[$ann['id']] = true;
						} else
							echo "[INFO] Ad {$ann['id']} was marked to kill previously... \n";
					}
					$first = false;
				}
			}
			
			// Detection by equal image
		
		echo "[INFO] Detection by equal image\n";
		
		$r = Apretaste::query("select author, md5(image) as mimage, count(*) as total from (
			SELECT CASE WHEN author ~ 'in.revolico.net' THEN 'revolico' ELSE author END as author, image
		FROM announcement ) as q1
		where image is not null and image <> '' group by author, md5(image) having count(*) >1;");
		
		if (is_array($r)) {
			foreach ( $r as $row ) {
				
				echo "[INFO] $tokill/$max will be killed \n";
				if ($tokill >= $max)
					break;
				
				$ads = Apretaste::query("select id from announcement where md5(image) = '{$row['mimage']}' and (author = '{$row['author']}' OR 'revolico' =  '{$row['author']}') and image is not null and image <> '' order by post_date desc;");
				if (is_array($ads)) {
					
					$first = true;
					foreach ( $ads as $ann ) {
						// if (! isset($goods[$ann['id']])) {
						if ($first === false) {
							if (! isset($bads[$ann['id']])) {
								echo "[INFO] Preparing to kill the ad {$ann['id']} with image {$row['mimage']} duplicated ... \n";
								Apretaste::query_queue("DELETE FROM announcement WHERE id = '{$ann['id']}';");
								$bads[$ann['id']] = true;
								$tokill ++;
							} else
								echo "[INFO] Ad {$ann['id']} was marked to kill previously... \n";
						} else
							echo "[INFO] Saving the last {$ann['id']} \n";
						$first = false;
						// }
					}
				}
			}
		}
		
		if ($tokill < $max && $depth) {
			echo "[INFO] $tokill < $max, Now making depth search...\n";
			
			$rr = Apretaste::query("select count(id) as cant from announcement where check_duplicated_date <> CURRENT_DATE or check_duplicated_date is null;");
			$cant = $rr[0]['cant'];
			
			if ($cant > 20)
				$cant = 20;
			
			for($i = 0; $i < $cant; $i ++) {
				
				$offset = mt_rand(0, $cant);
				
				echo "[INFO] Verifying ad $offset($i) of $cant, $tokill will be killed.. \n";
				if ($tokill >= $max && $max > 0)
					break;
				
				$a = Apretaste::query("SELECT id, author, title FROM announcement WHERE check_duplicated_date <> CURRENT_DATE  or check_duplicated_date is null LIMIT 1 OFFSET $offset;");
				$a = $a[0];
				if (! isset($bads[$a['id']])) {
					$title = $a['title'];
					$author = $a['author'];
					if (strpos($author, 'in.revolico.net'))
						$author = 'in.revolico.net';
					$title = str_replace("'", "''", $title);
					
					$r = Apretaste::query("SELECT id, post_date FROM announcement WHERE
						similar_text_percent(title, '$title') >= 0.9
						AND (author ~ '$author') order by post_date DESC;");
					
					if (count($r) > 1) {
						echo "[INFO] The ad $i ({$a['id']}) is duplicated " . count($r) . " times...\n";
						echo "[INFO]     Getting the last ad and prepare to kill the rest... \n";
						
						// $e = Apretaste::query("SELECT * FROM $tablegood WHERE id = '{$r[0]['id']}';");
						
						// if (!$e) {
						if (! isset($goods[$r[0]['id']])) {
							// Apretaste::query("INSERT INTO $tablegood VALUES ('{$r[0]['id']}');");
							$goods[$r[0]['id']] = true;
							$first = true;
							foreach ( $r as $ann ) {
								if ($first === false) {
									// $e = Apretaste::query("SELECT * FROM $table WHERE id = '{$ann['id']}';");
									
									// if (!$e) {
									if (! isset($bads[$ann['id']])) {
										echo "[INFO] Prepare to kill the ad {$ann['id']} ... \n";
										// Apretaste::query("INSERT INTO $table VALUES ('{$ann['id']}');");
										$bads[$ann['id']] = true;
										Apretaste::query_queue("DELETE FROM announcement WHERE id = '{$ann['id']}';");
										$tokill ++;
									} else
										echo "[INFO] Ad {$ann['id']} was marked to kill previously... \n";
								}
								$first = false;
							}
						}
					} else {
						Apretaste::query("update announcement set check_duplicated_date = CURRENT_DATE where id = '{$a['id']}';");
					}
				} else
					echo "[INFO] Ad {$a['id']} was marked to kill previously... \n";
			}
		}
		/*
		 * $r = Apretaste::query("SELECT count(*) as cant FROM $table;"); $cant = $r[0]['cant']; echo "[INFO] Killing $cant duplicated ads... \n"; for ($i = 0; $i < $cant; $i++) { $a = Apretaste::query("SELECT * FROM $table LIMIT 1 OFFSET $i;"); $a = $a[0]; echo "[INFO] Killing ad {$a['id']} ...\n"; Apretaste::query("DELETE FROM announcement WHERE id = '{$a['id']}'"); } Apretaste::query("DROP TABLE $table CASCADE;"); Apretaste::query("DROP TABLE $tablegood CASCADE;");
		 */
		echo "[INFO] Restoring configuration... \n";
		if ($enable_history === true) {
			Apretaste::setConfiguration('enable_history', true);
		}
		
		echo "[INFO] Finished, $cant ads was killed \n";
	}
	static function duplicateddepth(){
		self::killduplicated(true);
	}
	
	/**
	 * Delete old ads
	 */
	static function killold(){
		echo "[INFO] Connecting... \n";
		
		Apretaste::connect();
		
		if (isset($_SERVER['argv'][1]))
			$max = $_SERVER['argv'][1];
		else
			$max = 100;
		
		echo "[INFO] Getting timelife ";
		
		$d = Apretaste::getConfiguration("announce_timelife");
		
		if (is_null($d)) {
			$d = 30;
			Apretaste::setConfiguration("announce_timelife", $d);
		}
		
		echo $d . "\n";
		
		echo "[INFO] Deleting old ads ...\n";
		
		$r = Apretaste::query("select count(*) as cant from announcement where current_date - post_date > interval '$d days' and (sponsored is null or sponsored = false);");
		
		$cant = $r[0]['cant'];
		
		echo "[INFO] $cant old ads \n";
		
		$j = 0;
		for($i = 1; $i <= $cant; $i ++) {
			$r = Apretaste::query("select * from announcement where current_date - post_date > interval '$d days' and (sponsored is null or sponsored = false) limit 1");
			if (! $r)
				break;
			$j ++;
			$r = $r[0];
			echo "[INFO] $j of $max, deleting old ad " . $r['id'] . ", " . $r['post_date'] . "\n";
			Apretaste::query("delete from announcement where id = '{$r['id']}';");
			if ($j >= $max)
				break;
		}
		
		echo "[INFO] Finished!. $j ads was deleted.\n";
	}
	
	/**
	 * Vacuum tables
	 */
	static function vacuum(){
		$tables = explode(",", "accusation,announcement,historial,invitation,message,outbox,phrases,search_history,subscribe,synonym,visit,word");
		
		foreach ( $tables as $table ) {
			echo "vacuum $table... \n";
			Apretaste::query("vacuum full $table;");
		}
	}
	static function sitemap(){
		Apretaste::connect();
		$host = "apretaste.com";
		
		// $f = fopen(PACKAGES."../www/sitemap.xml","w");
		
		echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
		/* fputs($f, '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'); */
		
		$urls = array();
		
		$urls[] = "insert";
		$urls[] = "help";
		$urls[] = "download";
		
		$r = Apretaste::query("SELECT count(*) as cant FROM announcement;");
		$cant = $r[0]['cant'];
		
		for($i = 0; $i < $cant; $i ++) {
			$r = Apretaste::query("SELECT id,title  FROM announcement limit 1 offset $i;");
			if ($r) {
				if (is_array($r)) {
					$urls[] = "show/" . Apretaste::rawTitle($r[0]['title']) . "-" . $r[0]['id'];
				}
			}
			if (count($urls) > 100 || $i == $cant - 1 || $i > $cant) {
				foreach ( $urls as $url ) {
					fputs($f, "<url>");
					fputs($f, "<loc>http://$host/$url</loc>");
					fputs($f, "<lastmod>" . date("Y-m-d") . "</lastmod>");
					fputs($f, "<changefreq>weekly</changefreq>");
					fputs($f, "<priority>0.8</priority>");
					fputs($f, "</url>");
					/*
					 * fputs($f, "<url>"); fputs($f, "<loc>http://$host/$url</loc>"); fputs($f, "<lastmod>".date("Y-m-d")."</lastmod>"); fputs($f, "<changefreq>weekly</changefreq>"); fputs($f, "<priority>0.8</priority>"); fputs($f, "</url>");
					 */
				}
				$urls = array();
			}
		}
		
		fputs($f, "</urlset>");
		
		echo $xml;
	}
	static function nanotitles(){
		Apretaste::connect();
		$c = Apretaste::query("select count(*) as cant from announcement;");
		
		Apretaste::query("update nanotitles set popularity = 0;");
		
		$c = $c[0]['cant'];
		echo "Nanotitles! $c\n";
		$lpercent = 0;
		for($i = 0; $i < $c; $i ++) {
			$percent = intval($i / $c * 100);
			if ($lpercent != $percent) {
				echo "[INFO] Processing " . $percent . "% ... $i / $c \n";
				$lpercent = $percent;
			}
			$r = Apretaste::query("select nano_titulo(q.title) as ntitle from (select title from announcement limit 1 offset $i) as q;");
			
			if (isset($r[0])) {
				$ntitle = $r[0]['ntitle'];
				if (trim($ntitle) == "") {
					continue;
				}
				
				$words = explode(" ", $ntitle);
				$w1 = $words[0];
				$w2 = '';
				$w3 = '';
				$w4 = '';
				if (isset($words[1]))
					$w2 = $words[1];
				if (isset($words[2]))
					$w3 = $words[2];
				if (isset($words[3]))
					$w4 = $words[3];
				
				$r = Apretaste::query("select * from nanotitles where w1 = '$w1' AND w2 = '$w2' AND w3 = '$w3' AND w4 = '$w4';");
				
				if (! isset($r[0])) {
					Apretaste::query("insert into nanotitles (w1,w2,w3,w4) values('$w1','$w2','$w3','$w4');");
				} else {
					Apretaste::query("update nanotitles set popularity = popularity + 1 where w1 = '$w1' AND w2 = '$w2' AND w3 = '$w3' AND w4 = '$w4';");
				}
			} // else echo "$i [ignorando] \n";
		}
		
		Apretaste::query("delete from nanotitles where popularity = 0;");
		Apretaste::query("update nanotitles set levels = 0;
					update nanotitles set levels = 1 where w2 ='' and w3 = '' and w4 = '';
					update nanotitles set levels = 2 where levels = 0 and w3 = '' and w4 = '';
					update nanotitles set levels = 3 where levels = 0 and w4 = '';
					update nanotitles set levels = 4 where levels = 0;");
		
		echo "\n";
	}
	static function linker(){
		if (isset($_SERVER['argv'][1]))
			$max = $_SERVER['argv'][1];
		else
			$max = 100;
		
		$t1 = microtime(true);
		Apretaste::connect();
		
		$r = Apretaste::query("SELECT count(*) as cant FROM announcement WHERE (linker_date <> CURRENT_DATE OR linker_date is null) AND external_id is null ;");
		$cld = $r[0]['cant'];
		
		$ids = Apretaste::query("SELECT id,title,author FROM announcement where random() > random() AND (linker_date <> CURRENT_DATE OR linker_date is null OR $cld = 0) AND external_id is null LIMIT $max;");
		foreach ( $ids as $i => $item ) {
			$author = $item['author'];
			
			echo "[LINKER] $i - {$item['id']} - $author \n";
			
			$id = $item['id'];
			$r = Apretaste::linker($id, $author);
			
			if ($r != false) {
				
				echo "[INFO] Sending results to $author..\n";
				$robot = new ApretasteEmailRobot($autostart = false, $verbose = true);
				Apretaste::$robot = &$robot;
				
				$data = array(
						'command' => 'linker',
						'answer_type' => 'linker',
						'oferta' => $r['oferta'],
						'search_results' => $r['results'],
						"compactmode" => true,
						"showminimal" => true,
						"ad_title" => $item['title'],
						"title" => "Ayudando con su {$r['oferta']}: {$item['title']}"
				);
				
				$config = array();
				
				$account = '';
				foreach ( $robot->config_answer as $acc => $configx ) {
					$config = $configx;
					$account = $acc;
					break;
				}
				
				$go = true;
				if ($account == 'anuncios@localhost')
					if ($author != 'newuser@localhost')
						$go = false;
				
				if ($go)
					$answerMail = new ApretasteAnswerEmail($config, $author, $robot->smtp_servers, $data, true, false, false);
			}
			
			Apretaste::query("UPDATE announcement SET linker_date = CURRENT_DATE WHERE id = '$id';");
		}
		
		$t2 = microtime(true);
		echo number_format($t2 - $t1, 2) . " secs\n";
	}
	static function query_queue(){
		Apretaste::connect();
		
		if (isset($_SERVER['argv'][1]))
			$max = $_SERVER['argv'][1];
		else
			$max = 100;
		
		for($i = 1; $i <= $max; $i ++) {
			$r = Apretaste::query("select id, query from query_queue where moment = (select min(moment) from query_queue);");
			if (isset($r[0])) {
				echo "[INFO] Query queue $i/$max {$r[0]['id']} - {$r[0]['query']} \n";
				Apretaste::query($r[0]['query']);
				Apretaste::query("DELETE FROM query_queue WHERE id = '{$r[0]['id']}';");
			} else
				break;
		}
	}
	static function outbox(){
		Apretaste::connect();
		
		if (isset($_SERVER['argv'][1]))
			$max = $_SERVER['argv'][1];
		else
			$max = 100;
		
		for($i = 1; $i <= $max; $i ++) {
			$r = Apretaste::query("select ad,email from pre_alert limit 1;");
			if (isset($r[0])) {
				Apretaste::query("DELETE from pre_alert WHERE ad = '{$r[0]['ad']}'");
				Apretaste::outbox($r[0]['ad'], $r[0]['email']);
			} else
				break;
		}
	}
	static function sendStatus(){
		echo "[INFO] Connecting to DB\n";
		
		Apretaste::connect();
		
		echo "[INFO] Nourish the address list\n";
		
		Apretaste::nourishAddressList();
		
		if (isset($_SERVER['argv'][1]))
			$max = $_SERVER['argv'][1];
		else
			$max = 100;
		
		echo "[INFO] Select $max email addresses\n";
		
		$r = Apretaste::query("select email 
			from address_list 
			where 
			(send_status is null or CURRENT_DATE - send_status >= 5)
			and substr(email,length(email)-2,3) = '.cu'
			and random() >= random()
			limit $max");
		
		include "../cmds/state.php";
		
		$robot = new ApretasteEmailRobot($autostart = false, $verbose = true);
		
		Apretaste::$robot = &$robot;
		
		$config = array();
		
		foreach ( Apretaste::$robot->config_answer as $configx ) {
			$config = $configx;
			break;
		}
		
		$blacklist = Apretaste::getEmailBlackList();
		$whitelist = Apretaste::getEmailWhiteList();
		
		$total = count($r);
		
		echo "[INFO] Process " . $total . " email addresses\n";
		
		$i = 0;
		foreach ( $r as $a ) {
			
			$i++;
			
			$email = strtolower($a['email']);
			
			if (!Apretaste::checkAddress($email)) continue;
			
			if ((Apretaste::matchEmailPlus($email, $blacklist) == true && Apretaste::matchEmailPlus($email, $whitelist) == false)) {
				$robot->log("Ignore email address {$email}");
				continue;
			}
			
			$r = Apretaste::query("SELECT count(*) as total 
					from message 
					where lower(extract_email(author)) = '$email' 
						and current_date - moment::date <= 90;"); // si nos escribio en los ultimos 3 meses
			
			$stats = $r[0]['total'] * 1;
			
			if ($stats > 0) {
				$robot->log("Send STATE to $email");
				$data = cmd_state($robot, $email, '');
				$ans = new ApretasteAnswerEmail($config, $email, $robot->smtp_servers, $data);
			} else {
				Apretaste::query("UPDATE address_list SET send_status = CURRENT_DATE where email = '$email';");
				$robot->log("Discard $email");
			}
		}
	}
	static function test(){
		include "../dev/test.php";
	}
}

