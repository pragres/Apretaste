<?php
function return_row($cell){
	return floor($cell / 9);
}
function return_col($cell){
	return $cell % 9;
}
function return_block($cell){
	return floor(return_row($cell) / 3) * 3 + floor(return_col($cell) / 3);
}
function is_possible_row($number, $row, $sudoku){
	$possible = true;
	for($x = 0; $x <= 8; $x ++) {
		if ($sudoku[$row * 9 + $x] == $number) {
			$possible = false;
		}
	}
	return $possible;
}
function is_possible_col($number, $col, $sudoku){
	$possible = true;
	for($x = 0; $x <= 8; $x ++) {
		if ($sudoku[$col + 9 * $x] == $number) {
			$possible = false;
		}
	}
	return $possible;
}
function is_possible_block($number, $block, $sudoku){
	$possible = true;
	for($x = 0; $x <= 8; $x ++) {
		if ($sudoku[floor($block / 3) * 27 + $x % 3 + 9 * floor($x / 3) + 3 * ($block % 3)] == $number) {
			$possible = false;
		}
	}
	return $possible;
}
function is_possible_number($cell, $number, $sudoku){
	$row = return_row($cell);
	$col = return_col($cell);
	$block = return_block($cell);
	return is_possible_row($number, $row, $sudoku) and is_possible_col($number, $col, $sudoku) and is_possible_block($number, $block, $sudoku);
}
function print_sudoku($sudoku){
	$html = "<table align = \"center\" cellspacing = \"1\" cellpadding = \"2\">\n";
	for($x = 0; $x <= 8; $x ++) {
		$html .= "<tr align = \"center\">\n";
		for($y = 0; $y <= 8; $y ++) {
			
			$style = 'border-right: 1px solid gray;';
			
			if (($x + 1) % 3 == 0)
				$style .= 'border-bottom: 2px solid black;';
			else
				$style .= 'border-bottom: 1px solid gray;';
			if (($y + 1) % 3 == 0)
				$style .= 'border-right: 2px solid black;';
			if ($x == 0)
				$style .= 'border-top: 2px solid black;';
			if ($y == 0)
				$style .= 'border-left: 2px solid black;';
			
			$v = $sudoku[$x * 9 + $y];
			
			if ($v < 0)
				$v = 0 - $v;
			elseif ($v == 0)
				$v = '&nbsp;';
			
			if ($v <= 0) {
				$style .= "background: white;";
			} else
				$style .= "background: #dddddd;";
			
			$html .= "<td width = \"40\" height = \"40\" style=\"$style;font-size:25px;font-family:verdana;\">";
			
			/*if ($v == '&nbsp;')
				$html .= '<input type="text" size = "1" maxlength="1" style="text-align:center;border:0px;font-size:25px;color:red;font-weight:bold;">';
			else */$html .= $v;
			
			$html .= "</td>\n";
		}
		$html .= "</tr>\n";
	}
	$html .= "</table>\n";
	return $html;
}
function is_correct_row($row, $sudoku){
	for($x = 0; $x <= 8; $x ++) {
		$row_temp[$x] = $sudoku[$row * 9 + $x];
	}
	return count(array_diff(array(
			1,
			2,
			3,
			4,
			5,
			6,
			7,
			8,
			9
	), $row_temp)) == 0;
}
function is_correct_col($col, $sudoku){
	for($x = 0; $x <= 8; $x ++) {
		$col_temp[$x] = $sudoku[$col + $x * 9];
	}
	return count(array_diff(array(
			1,
			2,
			3,
			4,
			5,
			6,
			7,
			8,
			9
	), $col_temp)) == 0;
}
function is_correct_block($block, $sudoku){
	for($x = 0; $x <= 8; $x ++) {
		$block_temp[$x] = $sudoku[floor($block / 3) * 27 + $x % 3 + 9 * floor($x / 3) + 3 * ($block % 3)];
	}
	return count(array_diff(array(
			1,
			2,
			3,
			4,
			5,
			6,
			7,
			8,
			9
	), $block_temp)) == 0;
}
function is_solved_sudoku($sudoku){
	for($x = 0; $x <= 8; $x ++) {
		if (! is_correct_block($x, $sudoku) or ! is_correct_row($x, $sudoku) or ! is_correct_col($x, $sudoku)) {
			return false;
			break;
		}
	}
	return true;
}
function determine_possible_values($cell, $sudoku){
	$possible = array();
	for($x = 1; $x <= 9; $x ++) {
		if (is_possible_number($cell, $x, $sudoku)) {
			array_unshift($possible, $x);
		}
	}
	return $possible;
}
function determine_random_possible_value($possible, $cell){
	return $possible[$cell][rand(0, count($possible[$cell]) - 1)];
}
function scan_sudoku_for_unique($sudoku){
	for($x = 0; $x <= 80; $x ++) {
		if ($sudoku[$x] == 0) {
			$possible[$x] = determine_possible_values($x, $sudoku);
			if (count($possible[$x]) == 0) {
				return (false);
				break;
			}
		}
	}
	return ($possible);
}
function remove_attempt($attempt_array, $number){
	$new_array = array();
	for($x = 0; $x < count($attempt_array); $x ++) {
		if ($attempt_array[$x] != $number) {
			array_unshift($new_array, $attempt_array[$x]);
		}
	}
	return $new_array;
}
function print_possible($possible){
	$html = "<table bgcolor = \"#ff0000\" cellspacing = \"1\" cellpadding = \"2\">";
	for($x = 0; $x <= 8; $x ++) {
		$html .= "<tr bgcolor = \"yellow\" align = \"center\">";
		for($y = 0; $y <= 8; $y ++) {
			$values = "";
			for($z = 0; $z <= count($possible[$x * 9 + $y]); $z ++) {
				$values .= $possible[$x * 9 + $y][$z];
			}
			$html .= "<td width = \"20\" height = \"20\">$values</td>";
		}
		$html .= "</tr>";
	}
	$html .= "</table>";
	return $html;
}
function next_random($possible){
	$max = 9;
	for($x = 0; $x <= 80; $x ++) {
		if ((count($possible[$x]) <= $max) and (count($possible[$x]) > 0)) {
			$max = count($possible[$x]);
			$min_choices = $x;
		}
	}
	return $min_choices;
}
function solve(&$sudoku){
	$start = microtime();
	$saved = array();
	$saved_sud = array();
	while ( ! is_solved_sudoku($sudoku) ) {
		$x += 1;
		$next_move = scan_sudoku_for_unique($sudoku);
		if ($next_move == false) {
			$next_move = array_pop($saved);
			$sudoku = array_pop($saved_sud);
		}
		$what_to_try = next_random($next_move);
		$attempt = determine_random_possible_value($next_move, $what_to_try);
		if (count($next_move[$what_to_try]) > 1) {
			$next_move[$what_to_try] = remove_attempt($next_move[$what_to_try], $attempt);
			array_push($saved, $next_move);
			array_push($saved_sud, $sudoku);
		}
		$sudoku[$what_to_try] = $attempt;
	}
	$end = microtime();
	$ms_start = explode(" ", $start);
	$ms_end = explode(" ", $end);
	$total_time = round(($ms_end[1] - $ms_start[1] + $ms_end[0] - $ms_start[0]), 2);
	
	// echo print_sudoku($sudoku);
}
function cmd_sudoku($robot, $from, $argument, $body = '', $images = array(), $query = '', $keyword = ''){
	$error = error_reporting();
	error_reporting(~ E_ALL);
	
	$sudoku = array();
	for($i = 0; $i < 81; $i ++)
		$sudoku[] = 0;
	
	$robot->log("Generating sudoku for $from");
	
	solve($sudoku);
	
	error_reporting($error);
	
	$solution = $sudoku;
	
	$hide = mt_rand(40, 60);
	
	for($i = 0; $i < $hide; $i ++) {
		$p = mt_rand(0, 80);
		$sudoku[$p] = 0;
		$solution[$p] = $solution[$p] * - 1;
	}
	
	$htmlproblem = print_sudoku($sudoku);
	$htmlsolution = print_sudoku($solution);
	
	/*$problemtxt = "";
	
	for($x = 0; $x <= 8; $x ++) {
		for($y = 0; $y <= 8; $y ++) {
			
			$problemtxt .= $sudoku[$x * 9 + $y];
			
	*/
	return array(
			"answer_type" => "sudoku",
			"command" => "sudoku",
			"title" => "Sudoku " . date("Y-m-d h:i:s"),
			"solution" => $htmlsolution,
			"problem" => $htmlproblem,
			"compactmode" => true,
			"images" => array()
	);
}