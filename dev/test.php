<?php

// put here test code

Apretaste::connect();

$msg = strip_html_tags('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META content="text/html; charset=us-ascii" http-equiv=Content-Type>
<STYLE>BLOCKQUOTE {
MARGIN-BOTTOM: 0px; MARGIN-LEFT: 2em; MARGIN-TOP: 0px
}
OL {
MARGIN-BOTTOM: 0px; MARGIN-TOP: 0px
}
UL {
MARGIN-BOTTOM: 0px; MARGIN-TOP: 0px
}
</STYLE>
<META name=GENERATOR content="MSHTML 11.00.9600.16476"></HEAD>
<BODY style="MARGIN: 10px"><FONT size=2 face=Verdana>
<DIV>&nbsp;</DIV>
<DIV>Papi donde estas metido,estoy preocupada.aqui stan yulinaty contesta al
telf de yuli</DIV></FONT></BODY></HTML>');


echo $msg;

/*
echo ApretasteSMS::getCredit();
/*
$emails = q("SELECT lower(extract_email(author)) as author from message group by author;");

foreach ( $emails as $i=>$email ) {
	echo "Adding {$email['author']} $i/".count($emails)."...\n";
	$r = ApretasteMarketing::addSubscriber($email['author']);
	//echo $r['result_message']."\n";
}
/*
$r = ApretasteMarketing::delSubscriber('rafa@pragres.com');

var_dump($r);

$r = ApretasteMarketing::getSubscriber('rafa@pragres.com');

var_dump($r);*/