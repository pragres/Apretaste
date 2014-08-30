<?php

// put here test code
$email = $_SERVER['argv'][1];
echo $email;
var_dump($_SERVER['argv']);

$r = ApretasteMarketing::addSubscriber($email);

var_dump($r);

$r = ApretasteMarketing::getSubscriber($email);
var_dump($r);

$r = ApretasteMarketing::delSubscriber($email);
var_dump($r);