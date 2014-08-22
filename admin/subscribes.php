<?php
$id = get('delete', false);

if ($id !== false) {
	q("DELETE FROM subscribe WHERE id = '{$id}';");
	header("Location: index.php?path=admin&page=subscribes");
	exit();
}

Apretaste::cleanSubscribes();

$data['subscribes'] = q("SELECT id,email,phrase,fa::date as moment,last_alert::date as last_alert FROM subscribe order by email,phrase;");

