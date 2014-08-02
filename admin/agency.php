<?php

if (! ApretasteAdmin::verifyLogin())
	die('Access denied');

$data = array();

$data['user'] = ApretasteAdmin::getUser();

echo new div("../tpl/admin/agency.tpl", $data);