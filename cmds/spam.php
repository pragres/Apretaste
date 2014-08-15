<?php

/**
 * Process SPAM email
 *
 * @param string $from
 * @param string $announcement
 * @return array
 */
function cmd_spam($robot, $from, $argument, $body = '', $images = array()){
	if (trim($argument) == '') {
		$argument = trim($body);
		$argument = str_replace("\n", " ", $argument);
		$argument = str_replace("\r", "", $argument);
		$argument = trim($argument);
	}
	
	$announcement = $argument;
	
	if (! Apretaste::isSimulator())
		$r = Apretaste::accusation($from, "spam", $announcement);
	else
		$r = APRETASTE_ACCUSATION_SUCCESSFULL;
	
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