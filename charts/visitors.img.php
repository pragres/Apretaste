<?php

include_once "../lib/pChart/class/pData.class.php";
include_once "../lib/pChart/class/pDraw.class.php";
include_once "../lib/pChart/class/pImage.class.php";

$current_year = intval(date("Y"));

$months = array(
		"Jan",
		"Feb",
		"Mar",
		"Apr",
		"May",
		"Jun",
		"Jul",
		"Aug",
		"Sep",
		"Oct",
		"Nov",
		"Dec"
);

$access_by_month = array();

for($year = $current_year - 1; $year <= $current_year; $year ++) {
	$access_by_month[$year] = array();
	for($month = 1; $month <= 12; $month ++) {
		$access_by_month[$year][$month] = 0;
	}
}

$r = ApretasteAnalitics::getAccesByMonth();

foreach ( $r as $x ) {
	$access_by_month[$x['ano']][$x['mes']] = $x['total'];
}

$current_year = intval(date('Y'));

$dcurrent = array();
$dlast = array();

for($i = 0; $i < 12; $i ++) {
	$dcurrent[] = 0;
	$dlast[] = 0;
}

foreach ( $r as $row ) {
	if ($row['ano'] * 1 == $current_year * 1)
		$dcurrent[$row['mes']-1] = $row['total'];
	else
		$dlast[$row['mes']-1] = $row['total'];
}

/* Create and populate the pData object */
$MyData = new pData();
$MyData->addPoints($dcurrent, $current_year);
$MyData->addPoints($dlast, $current_year - 1);

$MyData->setSerieTicks($current_year - 1, 3);
$MyData->setSerieWeight($current_year - 1, 1);
$MyData->setSerieWeight($current_year, 1);

//$MyData->setAxisName(0, "Unique visitors");

$MyData->addPoints($months, "Months");
$MyData->setAbscissa("Months");

/* Create the pChart object */
$myPicture = new pImage(800, 350, $MyData);

/* Turn of Antialiasing */
$myPicture->Antialias = FALSE;

/* Write the chart title */
$myPicture->setFontProperties(array(
		"FontName" => "../lib/pChart/fonts/verdana.ttf",
		"FontSize" => 10
));

/* Set the default font */
$myPicture->setFontProperties(array(
		"FontName" => "../lib/pChart/fonts/verdana.ttf",
		"FontSize" => 10
));

/* Define the chart area */
$myPicture->setGraphArea(60, 40, 750, 300);

/* Draw the scale */
$scaleSettings = array(
				"XMargin" => 10,
		"YMargin" => 0,
		"Floating" => TRUE,
		"GridR" => 200,
		"GridG" => 200,
		"GridB" => 200,
		"DrawSubTicks" => FALSE,	
		"CycleBackground" => FALSE,
		"Mode" => SCALE_MODE_START0,
		"MinDivHeight" => 30 
);

$myPicture->drawScale($scaleSettings);

/* Turn on Antialiasing */
$myPicture->Antialias = TRUE;

/* Draw the line chart */
$myPicture->drawLineChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO));

/* Write the chart legend */
$myPicture->drawLegend(540, 20, array(
		"Style" => LEGEND_NOBORDER,
		"Mode" => LEGEND_HORIZONTAL
));

/* Render the picture (choose the best way) */
$myPicture->autoOutput();
