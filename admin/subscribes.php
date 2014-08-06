<?php
Apretaste::cleanSubscribes();

$data['subscribes'] = Apretaste::query("SELECT id,email,phrase,fa::date as moment,last_alert::date as last_alert FROM subscribe order by email,phrase;");

