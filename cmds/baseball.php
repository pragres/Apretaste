<?php
require '../lib/simple_html_dom.php';

/**
 * Apretaste!com Baseball Command
 *
 * @author pcabreus <pcabreus@gmail.com>
 *        
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $argument
 * @param string $body
 * @param array $images
 * @return array
 */
function cmd_baseball($robot, $from, $argument, $body = '', $images = array()){
	$robot->log('Execution of baseball command');
	
	$argument = cmd_baseball_trim_text($argument, $body);
	
	$beisbolHost = 'http://www.beisbolencuba.com/noticias';
	$mlbHost = 'http://mlb.mlb.com/es/news/index.jsp?c_id=mlb';
	
	switch ($argument) {
		/**
		 * Most show a list of news today in cuba
		 */
		default :
			// @todo a system for know the requiredDate
			$requiredDate = new DateTime('yesterday');
			
			$list = array_merge(cmd_baseball_get_list_news_beisbol($beisbolHost, $requiredDate, $robot), cmd_baseball_get_list_news_mlb($mlbHost, $requiredDate, $robot));
			
			return cmd_baseball_response($list, "Noticias de la serie nacional de Beisbol de Cuba");
	}
	
	return cmd_baseball_response(array(), "Noticias de la serie nacional de Beisbol de Cuba");
}

/**
 * Get the list of news of the $host and $requiredDate
 *
 * @author charlys <pcabreus@gmail.com>
 *        
 * @param $host
 * @param $requiredDate
 * @param ApretasteEmailRobot $robot
 * @return array
 */
function cmd_baseball_get_list_news_beisbol($host, $requiredDate, $robot){
	$robot->log('Connection with ' . $host);
	// @todo charlys to log the connecting information
	$result = @file_get_html($host);
	
	if (empty($result)) {
		$robot->log('The host was not found');
		
		return array();
	} else {
		$robot->log('The host was found');
	}
	
	$list = array();
	
	$newsList = $result->find('.newsitem');
	
	foreach ( $newsList as $news ) {
		$date = cmd_baseball_get_date_from_site($news);
		if ($date >= $requiredDate) {
			$list[] = cmd_baseball_create_news($news, $date);
		}
	}
	
	return $list;
}

/**
 * Get the list of news of the $host and $requiredDate
 *
 * @author charlys <pcabreus@gmail.com>
 *        
 * @param $host
 * @param $requiredDate
 * @param ApretasteEmailRobot $robot
 * @return array
 */
function cmd_baseball_get_list_news_mlb($host, $requiredDate, $robot){
	$robot->log('Connection with ' . $host);
	$result = @file_get_html($host);
	
	if (empty($result)) {
		$robot->log('The host was not found');
		
		return array();
	} else {
		$robot->log('The host was found');
	}
	
	$list = array();
	
	$newsList = $result->find('#np_articles li');
	
	foreach ( $newsList as $news ) {
		// Search for the date of news
		$date = $news->find('.np_time');
		
		$dateString = str_replace('<div class="np_time">', '', $date[0]->__toString());
		$dateString = str_replace('</div>', '', $dateString);
		
		if (preg_match('/hace/i', $dateString)) {
			$date = new DateTime('today');
		} else {
			$dateString = mb_split(' ', $dateString, 2);
			$date = date_create_from_format('d/m/y', $dateString[0]);
		}
		
		// choice the correct news for a required date
		if ($date >= $requiredDate) {
			$title = $news->find('h2 a');
			$content = $news->find('.np_data');
			$contentClean = mb_split('<div', $content[0], 2);
			
			$list[] = array(
					'date' => $date->format('d M Y'),
					'title' => $title[0],
					'content' => $contentClean[0]
			);
		}
	}
	
	return $list;
}

/**
 * Response of command
 * @author charlys <pcabreus@gmail.com>
 *        
 *        
 * @param $news
 * @param $header
 * @return array
 */
function cmd_baseball_response($news, $header){
	$tags = "<div><h2><p><span>";
	
	$drop = array(
			'M&aacute;s&raquo;',
			'... leer m' . html_entity_decode("&aacute;") . 's...'
	);
	
	foreach ( $news as $k => $v ) {
		$news[$k]['title'] = str_replace($drop, '', Apretaste::strip_html_tags("{$v['title']}", $tags));
		$news[$k]['content'] = str_replace($drop, '', Apretaste::strip_html_tags("{$v['content']}", $tags));
	}
	
	return array(
			"answer_type" => "baseball",
			"command" => "baseball",
			"header" => $header,
			"news" => $news
	);
}

/**
 * Get the date from the string date in other language
 * This function need php_intl extension
 *
 * @author charlys <pcabreus@gmail.com>
 *        
 * @param string $date
 * @param string $language
 * @return DateTime | null
 */
function cmd_baseball_get_date_from_language($date, $language = "es-ES"){
	$formatter = new IntlDateFormatter($language, IntlDateFormatter::LONG, IntlDateFormatter::NONE, 'America/Los_Angeles', IntlDateFormatter::GREGORIAN);
	
	$date = cmd_baseball_trim_text($date, '');
	
	$time = $formatter->parse($date);
	
	$datetime = null;
	
	if (! empty($time)) {
		$datetime = new DateTime("@$time");
	}
	
	return $datetime;
}

/**
 * Parser for the node notice of the Beisbol Site
 *
 * @author charlys <pcabreus@gmail.com>
 *        
 * @param simple_html_dom_node $news
 * @return DateTime null
 */
function cmd_baseball_get_date_from_site($news){
	$dateString = $news->find('.newsdate span');
	$dateString = str_replace('<span>', '', $dateString[0]);
	$dateString = str_replace('</span>', '', $dateString);
	$date = cmd_baseball_get_date_from_language($dateString);
	
	return $date;
}

/**
 * Return the day for search information
 *
 * @author charlys <pcabreus@gmail.com>
 *        
 * @todo charlys get the image of news
 *      
 * @param simple_html_dom_node $news
 * @param DateTime $date
 * @return array
 */
function cmd_baseball_create_news($news, $date){
	$title = $news->find('.newstitle');
	$content = $news->find('.newscontent');
	
	return array(
			'date' => $date->format('d M Y'),
			'title' => $title[0],
			'content' => $content[0]
	);
}

/**
 * Trim function for clean the input command
 *
 * @author charlys <pcabreus@gmail.com>
 *        
 * @param $text
 * @param $alterText
 * @return string
 */
function cmd_baseball_trim_text($text, $alterText){
	if (trim($text) == '') {
		$text = trim($alterText);
		$text = str_replace("\n", " ", $text);
		$text = str_replace("\r", "", $text);
		$text = trim($text);
	}
	
	return trim(strtolower($text));
}