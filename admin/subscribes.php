<?php
if (get('delete', false)) {
	q("DELETE FROM subscribe WHERE id = '{$id}';");
}

Apretaste::cleanSubscribes();

$data['subscribes'] = q("SELECT id,email,phrase,fa::date as moment,last_alert::date as last_alert FROM subscribe order by email,phrase;");

