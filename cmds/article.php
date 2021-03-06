<?php

/**
 * Get article from wikipedia
 *
 * @param string $query
 * @param string $argument
 * @param string $keyword
 * @return mixed
 */
function wiki_get($robot, $from, $argument, $body = '', $images = array(), $query = '', $keyword = ''){
	$robot->log("Trying WikiQuery: " . $query);
	
	$completo = false;
	
	$url = "http://es.wikipedia.org/w/api.php?action=query&prop=revisions&rvprop=content&format=xml&redirects=1&titles=$keyword&rvparse";
	// $url = "http://localhost/wiki/ecuador.xml";
	
	$robot->log("File get contents: $url");
	
	$page = file_get_contents($url);
	
	if (strpos($page, 'missing=""') === false) {
		
		// ---------------------
		
		if (Apretaste::isUTF8($page))
			$page = utf8_decode($page);
			
			// $page = Apretaste::repairUTF8($page);
		
		$page = html_entity_decode($page, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
		
		// ---------------------
		$p1 = strpos($page, '<page pageid=');
		$p2 = strpos($page, '<revisions');
		
		$title = substr($page, $p1, $p2 - $p1);
		
		$robot->log("1 article found in WikiQuery: $title " . $query);
		
		$p1 = strpos($title, 'title="');
		$p2 = strpos($title, '">', $p1);
		$title = substr($title, $p1 + 7, $p2 - $p1 - 7);
		
		// remove everything before the index and external links
		$robot->log("Remove everything before the index and external links");
		$mark = '<rev xml:space="preserve">';
		$page = substr($page, strpos($page, $mark) + strlen($mark));
		$page = str_replace('</rev></revisions></page></pages></query></api>', '', $page);
		$robot->log("Strip tags...");
		$page = strip_tags($page, '<a><!--><!DOCTYPE><abbr><acronym><address><area><article><aside><b><base><basefont><bdi><bdo><big><blockquote><body><br><button><canvas><caption><center><cite><code><col><colgroup><command><datalist><dd><del><details><dfn><dialog><dir><div><dl><dt><em><embed><fieldset><figcaption><figure><font><footer><form><frame><frameset><head><header><h1> - <h6><hr><html><i><iframe><img><input><ins><kbd><keygen><label><legend><li><link><map><mark><menu><meta><meter><nav><noframes><noscript><object><ol><optgroup><option><output><p><param><pre><progress><q><rp><rt><ruby><s><samp><script><section><select><small><source><span><strike><strong><style><sub><summary><sup><table><tbody><td><textarea><tfoot><th><thead><time><title><tr><track><tt><u><ul><var><wbr><h2><h3>');
		$page = str_replace('oding="UTF-8"?>', '', $page);
		
		// removing brackets []
		$robot->log("Removing brackets..");
		$page = preg_replace('/\[([^\[\]]++|(?R))*+\]/', '', $page);
		
		// remove indice
		$robot->log("Removing index..");
		$hpage = $page; // html_entity_decode($page);
		
		$mark = '<div id="toc" class="toc">';
		
		$p1 = strpos($hpage, $mark);
		if ($p1 !== false) {
			$p2 = strpos($hpage, '</div>', $p1);
			if ($p2 !== false) {
				$p2 = strpos($hpage, '</div>', $p2 + 1);
				$hpage = substr($hpage, 0, $p1) . substr($hpage, $p2 + 6);
			}
		}
		
		// remove enlaces externos
		$robot->log("Remove external links...");
		$mark = '<span class="mw-headline" id="Enlaces_externos';
		$p = strpos($hpage, $mark);
		if ($p !== false)
			$hpage = substr($hpage, 0, $p - 4);
			
			// remove other stuff
		$robot->log("Remove other stuff...");
		$hpage = str_replace("</api>", "", $hpage);
		$hpage = str_replace("<api>", "", $hpage);
		
		// remove references links
		$robot->log("Remove references links...");
		$p = strpos($hpage, '<h2><span class="mw-headline" id="Referencias">');
		if ($p !== false) {
			$part = substr($hpage, $p);
			$part = strip_tags($part, '<li><ul><span><h2><h3>');
			$hpage = substr($hpage, 0, $p) . $part;
		}
		
		$hpage = str_replace('>?</span>', '></span>', $hpage);
		
		$page = trim($hpage);
		
		if ($page != '') {
			
			// Build our DOMDocument, and load our HTML
			$robot->log("Build our DOMDocument, and load our HTML...");
			$doc = new DOMDocument();
			
			@$doc->loadHTML($page);
			
			// New-up an instance of our DOMXPath class
			$xpath = new DOMXPath($doc);
			
			// Find all elements whose class attribute has test2
			$elements = $xpath->query("//*[contains(@class,'thumb')]");
			
			// Cycle over each, remove attribute 'class'
			foreach ( $elements as $element ) {
				// Empty out the class attribute value
				$element->parentNode->removeChild($element);
			}
			
			// Load images
			$robot->log("Loading images...");
			$imagestags = $doc->getElementsByTagName("img");
			$images = array();
			$ignored = array();
			if ($imagestags->length > 0) {
				foreach ( $imagestags as $imgtag ) {
					
					$imgsrc = $imgtag->getAttribute('src');
					
					if (substr($imgsrc, 0, 2) == '//')
						$imgsrc = 'http:' . $imgsrc;
					
					if (stripos($imgsrc, 'increase') !== false || stripos($imgsrc, 'check') !== false || stripos($imgsrc, 'mark') !== false || stripos($imgsrc, 'emblem') !== false || stripos($imgsrc, 'symbol_comment') !== false || substr($imgsrc, - 4) == ".svg") {
						$ignored[] = $imgsrc;
						// $robot->log("Ignoring image $imgsrc");
						continue;
					}
					
					$srcparts = explode("/", $imgsrc);
					$name = array_pop($srcparts);
					
					$robot->log("Retrieving image $imgsrc");
					
					$img = @file_get_contents($imgsrc);
					if ($img === false) {
						// $robot->log("Image not found! Continue...");
						continue;
					}
					
					$robot->log("Compressing image $imgsrc");
					
					$img = base64_decode(Apretaste::resizeImage(base64_encode($img), 100));
					
					if ("$img" != "") {
						$ext = substr($imgsrc, - 3);
						$id = uniqid();
						
						$images[] = array(
								"type" => "image/$ext",
								"content" => $img,
								"name" => $name,
								"id" => $id,
								"src" => str_replace("http:", "", $imgsrc)
						);
					}
				}
			}
			
			// Output the HTML of our container
			$robot->log("Output HTML...");
			$page = $doc->saveHTML();
			
			// Cleanning
			$robot->log("Cleanning...");
			$page = str_replace("<br>", "<br>\n", $page);
			$page = str_replace("<br/>", "<br/>\n", $page);
			$page = str_replace("</p>", "</p>\n", $page);
			$page = str_replace("</h2>", "</h2>\n", $page);
			$page = str_replace("</span>", "</span>\n", $page);
			$page = str_replace("/>", "/>\n", $page);
			$page = str_replace("<p", "<p style=\"text-align:justify;\" align=\"justify\"", $page);
			$page = wordwrap($page, 200, "\n");
			$page = str_replace("href=\"/wiki/", 'href="mailto:{$reply_to}?subject=ARTICULO  ', $page);
			// $page = str_replace("href=\"http", 'href="mailto:{$reply_to}?subject=NAVIGATOR http', $page);
			
			foreach ( $images as $image ) {
				$page = str_replace($image['src'], "cid:" . $image['id'], $page);
			}
			foreach ( $ignored as $ign ) {
				$page = str_replace($ign, '', $page);
			}
			
			$showimages = true;
			
			if (! $completo) {
				$size = strlen($page);
				foreach ( $images as $image )
					$size += sizeof($image['content']);
				
				if ($size > 1024 * 450) {
					$images = array();
					$showimages = false;
					$page = strip_tags($page, '<a><abbr><acronym><address><applet><area><article><aside><audio><b><base><basefont><bdi><bdo><big><blockquote><br><button><canvas><caption><center><cite><code><col><colgroup><command><datalist><dd><del><details><dfn><dialog><dir><div><dl><dt><em><embed><fieldset><figcaption><figure><font><footer><form><frame><frameset><head><header><h1> - <h6><hr><i><iframe><input><ins><kbd><keygen><label><legend><li><link><map><mark><menu><meta><meter><nav><noframes><noscript><object><ol><optgroup><option><output><p><param><pre><progress><q><rp><rt><ruby><s><samp><script><section><select><small><source><span><strike><strong><style><sub><summary><sup><table><tbody><td><textarea><tfoot><th><thead><time><title><tr><track><tt><u><ul><var><video><wbr><h2><h3>');
				}
			}
			
			// save content into pages that will go to the view
			return array(
					"answer_type" => "article",
					"command" => "article",
					"title" => "$title",
					"query" => $query,
					"article_body" => $page,
					"showimages" => $showimages,
					"compactmode" => true,
					"images" => $images,
					"size" => intval($size / 1024)
			);
		}
	}
	
	$robot->log("Article '$keyword' not found in WikiQuery");
	
	return false;
}

/**
 * Search articles in wikipedia with OpenSearch
 *
 * @return mixed
 */
function wiki_search($robot, $from, $argument, $body = '', $images = array(), $query = '', $keyword = ''){
	$robot->log("Triying OpenSearch: " . $query);
	
	// $page = file_get_contents("http://localhost/wiki/opensearch.json");
	$url = "http://es.wikipedia.org/w/api.php?action=opensearch&search=$keyword&limit=10&namespace=0&format=json";
	$page = file_get_contents($url);
	
	$robot->log("File get contents: $url");
	$robot->log("OpenSearch result: $page ");
	
	$data = json_decode($page);
	
	$robot->log("[INFO] OpenSearch result: $page ");
	
	$results = $data[1];
	
	if (! isset($results[0])) {
		$robot->log("No results from OpenSearch!");
		return false;
	}
	
	$robot->log(count($results) . " results from OpenSearch!");
	
	return $results;
}

/**
 * Process result
 *
 * @param ApretasteEmailRobot $robot
 * @param array $r
 * @return array
 */
function cmd_article_result($robot, $from, $r){
	$tagmarks = array(
			'<h1',
			'<h2',
			'<h3',
			'<p',
			'<ul',
			'<ol'
	);
	
	$answers = $r;
	
	$i = 0;
	
	$page = $r['article_body'];
	
	$l = strlen($page);
	
	$robot->log("Article length $l bytes");
	
	$limit = 250 * 1024;
	$limit_part = 100 * 1024;
	$title = $r['title'];
	$images = $r['images'];
	
	$imagesize = 0;
	
	foreach ( $images as $img ) {
		$sz = strlen($img['content']);
		$robot->log("Size of image {$img['name']} is $sz");
		$imagesize += $sz;
	}
	
	$robot->log("Total size of images is $imagesize");
	
	if ($l + $imagesize > $limit) {
		$answers = array(
				'_answers' => array()
		);
		
		$robot->log("Big article: $l bytes,.. sending in parts! Calculating...");
		
		$parts = array();
		
		$part = '';
		
		do {
			$p = - 1;
			$last_p = - 1;
			do {
				
				$min = - 1;
				foreach ( $tagmarks as $tm ) {
					$px = stripos($page, $tm, $p + 1);
					if ($px !== false) {
						if ($min == - 1 || $px < $min) {
							$min = $px;
						}
					}
				}
				
				if ($min < 1) {
					$last_p = strlen($page);
					break;
				}
				
				if ($min > - 1) {
					if ($last_p == - 1)
						$last_p = $min;
					else
						$last_p = $p;
					$p = $min;
				}
				
				$extra = 0;
				/*
				 * $tempart = substr($page, 0, $p); foreach ( $images as $img ) if (stripos($tempart, $img['id']) !== false) { $extra += strlen($img['content']); }
				 */
			} while ( $p + $extra <= $limit_part );
			
			$p = $last_p;
			
			if ($p > - 1) {
				$xpart = substr($page, 0, $p);
				if (trim(strlen($xpart)) > 5) {
					$parts[] = "<br/>" . $xpart;
				}
				if (isset($page[$p]))
					$page = trim(substr($page, $p));
				else
					$page = '';
			}
			
			$l = strlen($page);
		} while ( $l > $limit_part && $p > - 1 );
		
		if (trim(strlen($xpart)) > 5)
			$parts[] = "<br/>" . $page;
		
		$robot->log("Big article: " . count($parts) . " parts");
		
		foreach ( $parts as $part ) {
			$part = trim($part);
			$size = strlen($part);
			
			if ($size < 10)
				continue;
			
			$i ++;
			$r['article_body'] = $part;
			$r['title'] = $title . ' (parte ' . $i . ')';
			
			// Checking the size of images
			$ximages = array();
			
			foreach ( $images as $img ) {
				if (stripos($part, $img['id']) !== false) {
					$imgsize = strlen($img['content']);
					if ($size + $imgsize <= $limit_part) {
						$size += $imgsize;
						$ximages[] = $img;
					}
				}
			}
			
			$r['images'] = $ximages;
			
			// if exists another part then ...
			
			$robot->log("Big article: preparing part $i with " . strlen($part) . " bytes");
			$answers['_answers'][] = $r;
		}
	}
	
	// ... else return the last part
	return $answers;
}

/**
 * Apretaste!com Article Command
 *
 * @author salvi <salvi@pragres.com>
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
function cmd_article($robot, $from, $argument, $body = '', $images = array()){
	$argument = str_replace("\n", " ", $argument);
	$argument = str_replace("\r", "", $argument);
	$argument = trim($argument);
	
	// getting the query
	$query = $argument;
	$query = Apretaste::depura($query, " abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ" . html_entity_decode("&aacute;&eacute;&iacute;&oacute;&uacute;&Aacute;&Eacute;&Iacute;&Uacute;&Oacute;&ntilde;&Ntilde;", ENT_COMPAT | ENT_HTML401, 'ISO-8859-1'));
	
	// log the search for stadistics
	$robot->log("[INFO] Search for an articule in Wikipedia: $query");
	
	// get the contents from wikipedia's API and convert to HTML
	$keyword = urlencode($argument);
	
	// Step 1: Getting the article
	
	$r = wiki_get($robot, $from, $argument, $body = '', $images = array(), $query, $keyword);
	
	// By default no results
	$result = array(
			"answer_type" => "article_not_found",
			"command" => "article",
			"query" => $query,
			"title" => "No se encontr&oacute; art&iacute;culo para: $argument ",
			"compactmode" => true
	);
	
	if ($r != false)
		$result = cmd_article_result($robot, $from, $r);
	else {
		// Step 2: Search for an article
		
		$s = wiki_search($robot, $from, $argument, $body = '', $images = array(), $query, $keyword);
		
		if ($s != false) {
			
			$r = wiki_get($robot, $from, $s[0], $body = '', $images = array(), $s[0], urlencode($s[0]));
			
			if ($r != false) {
				
				// Step 3: Add links of others articles
				
				$art = array_shift($s);
				
				if (isset($s[0])) {
					$r['article_body'] .= '<br/><hr/><h2>Art&iacute;culos relacionados</h2>';
					
					foreach ( $s as $si ) {
						$si = utf8_decode($si);
						$r['article_body'] .= ' - <a href="mailto:{$reply_to}?subject=ARTICULO ' . $si . '">' . $si . '</a><br/>';
					}
				}
				
				$result = cmd_article_result($robot, $from, $r);
			}
		}
	}
	
	if (isset($result['_answers'])) {
		foreach ( $result['_answers'] as $k => $v )
			$result['_answers'][$k]['sharethis'] = 'ARTICULO ' . $argument;
	}
	
	return $result;
}
