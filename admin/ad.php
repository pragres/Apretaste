<?php
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	
	$data['ad'] = Apretaste::getAnnouncement($id);
	if ($data['ad'] != APRETASTE_ANNOUNCEMENT_NOTFOUND) {
		$data['ad']['image'] = false; // '<img width="200" src="data:' . $data['ad']['image_type'] . ';base64,' . $data['ad']['image'] . '">';
		$data['ad']['author-details'] = Apretaste::getAuthor($data['ad']['author'], false, 50);
	} else {
		$data['ad'] = false;
		$data['notfound'] = true;
	}
} else
	$data['ad'] = false;
