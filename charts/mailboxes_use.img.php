<?php
Apretaste::connect();

$limit = 4;

$sql = "select mailboxes.mailbox as servidor, 
count(*) as cant
from message inner join mailboxes on
lower(extract_email(addressee)) ~* mailboxes.mailbox 
group by servidor
order by cant;";

$servers = Apretaste::query($sql);

$labels = array();
$points = array();

foreach ( $servers as $s ) {
	$labels[] = $s['servidor'] . "({$s['cant']})";
	$points[] = $s['cant'];
}

$g = new ApretasteDefaultPieChart($points, $labels, "Mailboxes use", "Mailboxes use", true, 750,500);

// End of file