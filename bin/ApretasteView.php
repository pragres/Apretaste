<?php
class ApretasteView extends div
{
    public function __construct($src = null, $items = null, $ignore = array())
    {
        self::setSubParser('block:full', 'ApretasteView::aBlockFullScreen');
        self::setSubParser('ico', 'ApretasteView::aIconImage');
        parent::__construct($src, $items, $ignore);
        $this->setItem("apretaste", "Apretaste!");
        $this->setItem("months", array(
            1 => "Jan",
            2 => "Feb",
            3 => "Mar",
            4 => "Apr",
            5 => "May",
            6 => "Jun",
            7 => "Jul",
            8 => "Aug",
            9 => "Sep",
            "01" => "Jan",
            "02" => "Feb",
            "03" => "Mar",
            "04" => "Apr",
            "05" => "May",
            "06" => "Jun",
            "07" => "Jul",
            "08" => "Aug",
            "09" => "Sep",
            10 => "Oct",
            11 => "Nov",
            12 => "Dec"
        ));
        $this->setItem("meses", array(
            1 => "Ene",
            2 => "Feb",
            3 => "Mar",
            4 => "Abr",
            5 => "May",
            6 => "Jun",
            7 => "Jul",
            8 => "Ago",
            9 => "Sep",
            "01" => "Ene",
            "02" => "Feb",
            "03" => "Mar",
            "04" => "Abr",
            "05" => "May",
            "06" => "Jun",
            "07" => "Jul",
            "08" => "Ago",
            "09" => "Sep",
            10 => "Oct",
            11 => "Nov",
            12 => "Dic"
        ));
    }

    static function aBlockFullScreen($src)
    {
        $src = '[[_	{= c:' . $src . ' =} {% block_fullscreen %} _]]';
        return $src;
    }

    static function aIconImage($src)
    {
        return "<img src=\"static/icons/$src.png\">";
    }
}