<?php

/**
 * Apretaste!com EcuRed Command
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 *         
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param array $images
 * @return array
 */
function cmd_ecured($robot, $from, $argument, $body = '', $images = array()){
	$query = $argument;
	
	$query = Apretaste::depura($query);
	
	// log the search for stadistics
	$robot->log($query);
	
	// get the contents from wikipedia's API and convert to HTML
	$keyword = urlencode($argument);
	
	//$page = file_get_contents("http://localhost/wiki/josemarti.xml");
	$page = file_get_contents("http://www.ecured.cu/api.php?action=query&prop=revisions&rvprop=content&format=xml&redirects=1&titles=$keyword&rvparse");
	
	if (strpos($page, 'missing=""')!==false) return array(
			"answer_type" => "article_not_found",
			"command" => "ecured",
			"query" => $query,
			"title" => "Art&iacute;culo -$argument- no encontrado",
			"compactmode" => true
	);
	
	$page = str_replace("</api>", "", $page);
	$page = str_replace("<api>", "", $page);
	$page = Apretaste::repairUTF8($page);
	$p1 = strpos($page, '<page pageid=');
	$p2 = strpos($page, '<revisions');
	
	$title = substr($page, $p1, $p2 - $p1);
	
	$p1 = strpos($title, 'title="');
	$p2 = strpos($title, '">', $p1);
	$title = substr($title, $p1 + 7, $p2 - $p1 - 7);
	
	// remove everything before the index and external links
	$mark = '<rev xml:space="preserve">';
	$page = substr($page, strpos($page, $mark) + strlen($mark));
	
	$mark = '</rev></revisions></page></pages></query></api>';
	$page = substr($page, 0, strlen($page) - strpos($page, $mark));
	
	$page = strip_tags($page, '<a><!--><!DOCTYPE><abbr><acronym><address><applet><area><article><aside><audio><b><base><basefont><bdi><bdo><big><blockquote><body><br><button><canvas><caption><center><cite><code><col><colgroup><command><datalist><dd><del><details><dfn><dialog><dir><div><dl><dt><em><embed><fieldset><figcaption><figure><font><footer><form><frame><frameset><head><header><h1> - <h6><hr><html><i><iframe><img><input><ins><kbd><keygen><label><legend><li><link><map><mark><menu><meta><meter><nav><noframes><noscript><object><ol><optgroup><option><output><p><param><pre><progress><q><rp><rt><ruby><s><samp><script><section><select><small><source><span><strike><strong><style><sub><summary><sup><table><tbody><td><textarea><tfoot><th><thead><time><title><tr><track><tt><u><ul><var><video><wbr><h2><h3>');
	$page = str_replace('oding="UTF-8"?>', '', $page);
	
	// removeing brackets []
	$page = preg_replace('/\[([^\[\]]++|(?R))*+\]/', '', $page);
	$page = trim($page);
	
	if ($page != '') {
		// Build our DOMDocument, and load our HTML
		$doc = new DOMDocument();
		
		$doc->loadHTML($page);
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
		$imagestags = $doc->getElementsByTagName("img");
		$images = array();
		if ($imagestags->length > 0) {
			foreach ( $imagestags as $imgtag ) {
				
				$imgsrc = $imgtag->getAttribute('src');
				
				if (substr($imgsrc, 0, 2) == '//')
					$imgsrc = 'http:' . $imgsrc;
				
				$srcparts = explode("/", $imgsrc);
				$name = array_pop($srcparts);
				echo "[INFO] Retrieve image $imgsrc \n";
				$img = @file_get_contents($imgsrc);
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
		$page = $doc->saveHTML();
		
		// Cleanning
		$wiky = new wiky();

		// Call for the function parse() on the variable You created and pass some unparsed text to it, it will return parsed HTML or false if the content was empty. In this example we are loading the file input.wiki, escaping all html characters with htmlspecialchars, running parse and echoing the output
		$page = htmlspecialchars($page);
		$page = $wiky->parse($page);
		
		$page = str_replace("<br>", "<br>\n", $page);
		$page = str_replace("<br/>", "<br/>\n", $page);
		$page = str_replace("</p>", "</p>\n", $page);
		$page = str_replace("</h2>", "</h2>\n", $page);
		$page = str_replace("</span>", "</span>\n", $page);
		$page = str_replace("/>", "/>\n", $page);
		$page = str_replace("<p", "<p style=\"text-align:justify;\" align=\"justify\"", $page);
		$page = wordwrap($page, 200, "\n");
		$page = str_replace("href=\"/wiki/", 'href="mailto:{$reply_to}?subject=ECURED  ', $page);
		//$page = str_replace("href=\"http", 'href="mailto:{$reply_to}?subject=NAVIGATOR http', $page);
		
		foreach ( $images as $image ) {
			$page = str_replace($image['src'], "cid:" . $image['id'], $page);
		}
				
		// save content into pages that will go to the view
		return array(
				"answer_type" => "article",
				"command" => "ecured",
				"title" => "$title",
				"query" => $query,
				"body" => $page,
				"compactmode" => false,
				"images" => $images
		);
	}
	
	return array(
			"answer_type" => "article_not_found",
			"command" => "ecured",
			"query" => $query,
			"title" => "Art&iacute;culo -$argument- no encontrado",
			"compactmode" => true
	);
}
