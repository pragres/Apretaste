<?php
require_once "../cmds/search.php";

/**
 * Apretaste!com Search Full Command
 * 
 * @param ApretasteEmailRobot $robot
 * @param string $from
 * @param string $query
 * @param string $body
 * @param array $images
 * @param number $limit
 * @param string $wimages
 * @return mixed
 */
function cmd_searchfull($robot, $from, $query, $body = '', $images = array()){
	$r = cmd_search($robot, $from, $query, '', array(), 50, false);
	$r['showminimal'] = true;
	return $r;
}