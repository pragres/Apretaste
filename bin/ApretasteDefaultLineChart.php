<?php
include_once "../lib/pChart/class/pData.class.php";
include_once "../lib/pChart/class/pDraw.class.php";
include_once "../lib/pChart/class/pImage.class.php";
class ApretasteDefaultLineChart extends pImage {
	public function ApretasteDefaultLineChart($title, $points, $labels, $points_label, $label, $autoOutPut = true){
		$d = new pData();
		$d->addPoints($points, $points_label);
		$d->addPoints($labels, "Labels");
		$d->setSerieDescription("Labels", $label);
		$d->setAbscissa("Labels");
		parent::pImage(900, 230, $d);
		$this->Antialias = FALSE;
		$this->drawRectangle(0, 0, 899, 229, array(
				"R" => 0,
				"G" => 0,
				"B" => 0
		));
		$this->setFontProperties(array(
				"FontName" => "../lib/pChart/fonts/advent_light.ttf",
				"FontSize" => 14
		));
		$this->drawText(150, 35, $title, array(
				"FontSize" => 20,
				"Align" => TEXT_ALIGN_BOTTOMMIDDLE
		));
		
		$this->setFontProperties(array(
				"FontName" => "../lib/pChart/fonts/advent_light.ttf",
				"FontSize" => 6
		));
		$this->setGraphArea(60, 40, 850, 200);
		$this->drawScale(array(
				"XMargin" => 10,
				"YMargin" => 10,
				"Floating" => TRUE,
				"GridR" => 200,
				"GridG" => 200,
				"GridB" => 200,
				"DrawSubTicks" => TRUE,
				"CycleBackground" => TRUE
		));
		$this->Antialias = TRUE;
		$this->drawLineChart();
		if ($autoOutPut == true)
			$this->autoOutput();
	}
}

// End of file