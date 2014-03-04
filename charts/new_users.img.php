<?php
include_once "../lib/pChart/class/pData.class.php";
include_once "../lib/pChart/class/pDraw.class.php";
include_once "../lib/pChart/class/pImage.class.php";

$current_year = intval(date('Y'));
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

$newusers = array();

for($year = $current_year - 1; $year <= $current_year; $year ++) {
	$newusers[$year] = array();
	for($month = 1; $month <= 12; $month ++) {
		$newusers[$year][$month] = ApretasteAnalitics::getCountOfNewUsers($year, $month);
	}
}

$dcurrent = $newusers[$current_year];
$dlast = $newusers[$current_year - 1];

$myData = new pData();
$myData->addPoints($dlast, $current_year - 1);
$myData->setSerieDescription($current_year - 1, $current_year - 1);
$myData->setSerieOnAxis($current_year - 1, 0);

$myData->addPoints($dcurrent, $current_year);
$myData->setSerieDescription($current_year, $current_year);
$myData->setSerieOnAxis($current_year, 0);

$myData->addPoints($months, "Months");
$myData->setAbscissa("Months");

$myData->setAxisPosition(0, AXIS_POSITION_LEFT);

$myData->setAxisUnit(0, "");

$myPicture = new pImage(800, 350, $myData);

$myPicture->setFontProperties(array(
		"FontName" => "../lib/pChart/fonts/verdana.ttf",
		"FontSize" => 14
));
$TextSettings = array(
		"Align" => TEXT_ALIGN_MIDDLEMIDDLE,
		"R" => 255,
		"G" => 255,
		"B" => 255
);

$myPicture->setShadow(FALSE);
$myPicture->setGraphArea(60, 40, 750, 300);
$myPicture->setFontProperties(array(
		"R" => 0,
		"G" => 0,
		"B" => 0,
		"FontName" => "../lib/pChart/fonts/verdana.ttf",
		"FontSize" => 10
));

$Settings = array(
		"Pos" => SCALE_POS_LEFTRIGHT,
		"Mode" => SCALE_MODE_FLOATING,
		"LabelingMethod" => LABELING_ALL,
		"GridR" => 255,
		"GridG" => 255,
		"GridB" => 255,
		"GridAlpha" => 50,
		"TickR" => 0,
		"TickG" => 0,
		"TickB" => 0,
		"TickAlpha" => 50,
		"LabelRotation" => 0,
		"CycleBackground" => 1,
		"DrawXLines" => 1,
		"DrawSubTicks" => 1,
		"SubTickR" => 255,
		"SubTickG" => 0,
		"SubTickB" => 0,
		"SubTickAlpha" => 50,
		"DrawYLines" => ALL
);
$myPicture->drawScale($Settings);

$Config = array(
		"DisplayValues" => 1,
		"AroundZero" => 1
);
$myPicture->drawBarChart($Config);

$Config = array(
		"FontR" => 0,
		"FontG" => 0,
		"FontB" => 0,
		"FontName" => "../lib/pChart/fonts/verdana.ttf",
		"FontSize" => 10,
		"Margin" => 6,
		"Alpha" => 30,
		"BoxSize" => 5,
		"Style" => LEGEND_NOBORDER,
		"Mode" => LEGEND_HORIZONTAL
);
$myPicture->drawLegend(605, 16, $Config);

$myPicture->stroke();
