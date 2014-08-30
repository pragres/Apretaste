<?php

// put here test code
$email = $_SERVER['argv'][1];

$r = ApretasteMarketing::addSubscriber($email);

var_dump($r);
