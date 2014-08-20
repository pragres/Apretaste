<?php
class ApretasteView extends div {
	public function __construct($src = null, $items = null, $ignore = array()){
		self::setSubParser('block:full', 'ApretasteView::aBlockFullScreen');
		self::setSubParser('ico', 'ApretasteView::aIconImage');
		parent::__construct($src, $items, $ignore);
		$this->setItem("apretaste", "Apretaste!");
	}
	static function aBlockFullScreen($src){
		$src = '[[_	{= c:' . $src . ' =} {% block_fullscreen %} _]]';
		return $src;
	}
	static function aIconImage($src){
		return "<img src=\"static/icons/$src.png\">";
	}
}