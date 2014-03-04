<?php

/**
 * Process SPAM email
 *
 * @param string $from
 * @param string $announcement
 * @return array
 */
function cmd_spam($robot, $from, $argument, $body = '', $images = array()){
	
	$announcement = $argument;
	
	$r = Apretaste::accusation($from, "spam", $announcement);
	
	switch ($r) {
		case APRETASTE_ACCUSATION_DUPLICATED :
			$a = Apretaste::getAnnouncement($announcement);
			return array(
					"command" => "spam",
					"answer_type" => "accusation_duplicated",
					"reason" => "SPAM",
					"compactmode" => true,
					"title" => "El anuncio '{$a['title']}' ya fue acusado con anterioridad por usted",
					"announce" => $a
			);
			break;
		case APRETASTE_ANNOUNCEMENT_NOTFOUND :
			return array(
					"command" => "spam",
					"answer_type" => "announcement_not_found",
					"reason" => "SPAM",
					"compactmode" => true,
					"id" => $announcement,
					"title" => "No se encuentra el anuncio $announcement."
			);
			break;
	}
	$a = Apretaste::getAnnouncement($announcement);
	return array(
			"command" => "spam",
			"answer_type" => "accusation_successfull",
			"reason" => "SPAM",
			"compactmode" => true,
			"title" => "Anuncio '{$a['title']}' acusado satisfactoriamente como SPAM",
			"announce" => $a
	);
}