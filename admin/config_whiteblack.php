<?php
$data['msg-type'] = "msg-ok";

// Proccess options
if (isset($_GET['o'])) {
	switch ($_GET['o']) {
		
		case "del_whitelist" :
			Apretaste::delWhiteList($_GET['data']);
			break;
		case "del_blacklist" :
			Apretaste::delBlackList($_GET['data']);
			break;
	}
}

if (isset($_POST['btnAddWhiteList'])) {
	Apretaste::addWhiteList($_POST['edtNewWhiteList']);
	$data['msg'] = "Email address has been saved to whitelist";
}

if (isset($_POST['btnAddBlackList'])) {
	Apretaste::addBlackList($_POST['edtNewBlackList']);
	$data['msg'] = "Email address has been saved to blacklist";
}

// Load data
$data['whitelist'] = Apretaste::getEmailWhiteList();
$data['blacklist'] = Apretaste::getEmailBlackList();
