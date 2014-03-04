<?php
include_once "../lib/pChart/class/pData.class.php";
include_once "../lib/pChart/class/pDraw.class.php";
include_once "../lib/pChart/class/pImage.class.php";
include_once "../lib/pChart/class/pPie.class.php";
class ApretasteDefaultPieChart extends pImage {
	
	/**
	 * Constructor
	 *
	 * @param array $points
	 * @param array $labels
	 * @param string $description
	 * @param boolean $autoOutput
	 * @return ApretasteDefaultLinearGraph
	 */
	public function ApretasteDefaultPieChart($points, $labels, $description, $title = "", $autoOutput = true, $w = 500, $h = 400){
		$palette = array();
		
		foreach ( $points as $k => $p ) {
			$palette[] = array(
					"R" => mt_rand(1, 255),
					"G" => mt_rand(1, 255),
					"B" => mt_rand(1, 255),
					"Alpha" => 99
			);
		}
		
		$d = new pData();
		$d->addPoints($points, "ScoreA");
		$d->setSerieDescription("ScoreA", $description);
		$d->addPoints($labels, "Labels");
		$d->setAbscissa("Labels");
		$d->Palette = $palette;
		
		parent::pImage($w, $h, $d, TRUE);
		$this->setFontProperties(array(
				"FontName" => "../lib/pChart/fonts/verdana.ttf",
				"FontSize" => 9,
				"R" => 80,
				"G" => 80,
				"B" => 80
		));
		$PieChart = new pPie($this, $d);
		
		$PieChart->draw2DPie($w / 2, $h / 2, array(
				"Radius" => $w / 5 - 20,
				"DataGapAngle" => 8,
				"DataGapRadius" => 5,
				/*"Border" => FALSE,*/
				"DrawLabels" => TRUE
		));
		
		/*
		 * $PieChart->drawPieLegend(5, 15, array( "Style" => LEGEND_NOBORDER, "Mode" => LEGEND_VERTICAL ));
		 */
		
		$this->drawText(40, 223, $title);
		if ($autoOutput === true)
			$this->autoOutput();
	}
}

// End of file