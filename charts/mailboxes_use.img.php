<?php
Apretaste::connect();

$limit = 4;

$sql = "select addressee as servidor, count(*) as cant
		from message
		group by addressee
		order by cant";

$servers = Apretaste::query($sql);

$labels = array();
$points = array();

foreach ( $servers as $s ) {
	$labels[] = $s['servidor'] . "({$s['cant']})";
	$points[] = $s['cant'];
}

$g = new ApretasteDefaultPieChart($points, $labels, "Mailboxes use", "Mailboxes use", true, 1000,500, true);

// End of file