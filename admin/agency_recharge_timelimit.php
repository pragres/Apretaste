<?php

$u = q("SELECT agency FROM users WHERE user_login = '{$data['user']['user_login']}';");

$agency = $u[0]['agency'];

