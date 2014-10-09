<?php

// put here test code

Apretaste::connect();

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