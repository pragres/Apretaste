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

// Load data
$data['kwblacklist'] = Apretaste::getBlackWords();
