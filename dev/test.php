<?php

// put here test code
Apretaste::connect();

$emails = q("SELECT lower(extact_email(author)) as author from message group by author;");

foreach ( $emails as $email ) {
	$r = ApretasteMarketing::addSubscriber($email['author']);
}