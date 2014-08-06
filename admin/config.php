<?php
$data['msg-type'] = "msg-ok";

// Proccess options
if (isset($_GET['o'])) {
	switch ($_GET['o']) {
		case "del_kw_bl" :
			
			$kw = $_GET['data'];
			Apretaste::query("update word set black = false where word = '$kw';");
			$data['msg'] = "Deleted the black keyword $kw";
			break;
		case "del_whitelist" :
			Apretaste::delWhiteList($_GET['data']);
			break;
		case "del_blacklist" :
			Apretaste::delBlackList($_GET['data']);
			break;
	}
}

// Proccess posts
if (isset($_POST['btnAddBlackKeyword'])) {
	$kw = $_POST['edtNewBlackKeyword'];
	if (trim($kw) != "") {
		$data['msg'] = "Added the black keyword $kw";
		Apretaste::query("update word set black = true where word = '$kw';");
	} else {
		$data['msg'] = "Please enter a valid black keyword";
		$data['msg-type'] = "msg-error";
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

if (isset($_POST['btnUpdateConfig'])) {
	Apretaste::setConfiguration("price_regexp", $_POST['edtPriceRegExp']);
	Apretaste::setConfiguration("phones_regexp", $_POST['edtPhonesRegExp']);
	Apretaste::setConfiguration("enable_history", isset($_POST['chkEnableHistorial']));
	Apretaste::setConfiguration("outbox.max", intval($_POST['edtOutboxmax']));
	Apretaste::setConfiguration("sms_free", isset($_POST['chkSmsFree']));
	$data['msg'] = "The configuration was been saved";
}

$data['chkEnableHistorial'] = Apretaste::getConfiguration("enable_history");
$data['chkSmsFree'] = Apretaste::getConfiguration("sms_free");
$data['edtPriceRegExp'] = Apretaste::getConfiguration("price_regexp");
$data['edtPhonesRegExp'] = Apretaste::getConfiguration("phones_regexp");
$data['edtOutboxmax'] = Apretaste::getConfiguration("outbox.max");

// Load data
$data['kwblacklist'] = Apretaste::getBlackWords();
$data['whitelist'] = Apretaste::getEmailWhiteList();
$data['blacklist'] = Apretaste::getEmailBlackList();