<?php

/**
 * Apretaste!com Web Page
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
class ApretasteWeb {
	static function Run(){
		include "../tpl/web/index.html";
	}
	
	/**
	 * Search
	 *
	 * @param unknown $phrase
	 * @param string $pricemin
	 * @param string $pricemax
	 * @param string $photo
	 * @param string $phone
	 * @param number $offset
	 * @return Ambigous <multitype:, multitype:multitype: number boolean , multitype:boolean integer number Ambigous <string, string, mixed> multitype:unknown Ambigous <boolean, multitype:unknown > >
	 */
	function search($phrase, $pricemin = null, $pricemax = null, $photo = null, $phone = null, $offset = 0){
		Apretaste::connect();
		$filter = array();
		if (! is_null($pricemin))
			if ("$pricemin" != "")
				$filter['price-min'] = $pricemin;
		if (! is_null($pricemax))
			if ("$pricemax" != "")
				$filter['price-max'] = $pricemax;
		if (! is_null($photo))
			if ("$photo" != "")
				if ("$photo" != "false")
					$filter['photo'] = $photo;
		if (! is_null($phone))
			if ("$phone" != "")
				if ("$phone" != "false")
					$filter['phone'] = $phone;
		
		$results = Apretaste::search($phrase, 10, $offset, true, '', null, $filter);
		
		if (is_array($results['results'])) {
			$res = array();
			foreach ( $results['results'] as $k => $result ) {
				$res[] = array(
						"id" => $result['id'],
						"title" => $result['title'],
						"body" => "{$result['body']}",
						"price" => $result['price'],
						"currency" => $result['currency'],
						"phones" => $result['phones'],
						"post_date" => $result['post_date'],
						"image" => "{$result['image']}" != ''
				);
			}
			$results['results'] = $res;
		}
		
		return $results;
	}
	
	function getAd($id){
		Apretaste::connect();
		$a = Apretaste::getAnnouncement($id);
		$a['image'] = "{$a['image']}" != '';
		return $a;
	}
	function didyoumean($query){
		Apretaste::connect();
		$r = Apretaste::didYouMean($query);
		return $r;
	}
	function help(){
		$help = new div("../tpl/alone/help.es.html.tpl", array(
				"font" => "font-family: Arial,Helvetica,sans-serif",
				"from" => "you@somemail.com",
				"reply_to" => "anuncios@apretaste.com",
				"apretaste" => "Apretaste!"
		));
		
		$help = "$help";
		
		return $help;
	}
	function terms(){
		$help = new div("../tpl/alone/terms.es.html.tpl", array(
				"font" => "font-family: Arial,Helvetica,sans-serif",
				"from" => "you@somemail.com",
				"reply_to" => "anuncios@apretaste.com",
				"apretaste" => "Apretaste!"
		));
		$help = "$help";
		return $help;
	}
}