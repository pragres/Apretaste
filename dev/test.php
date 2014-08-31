<?php

// put here test code
Apretaste::connect();

$emails = q("SELECT lower(extract_email(author)) as author from message group by author;");

foreach ( $emails as $email ) {
	echo "Adding $email\n";
	$r = ApretasteMarketing::addSubscriber($email['author']);
}