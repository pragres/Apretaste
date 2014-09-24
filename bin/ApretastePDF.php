<?php
include_once ("../lib/fpdf17/fpdf.php");

// function hex2dec
// returns an associative array (keys: R,G,B) from
// a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000"){
	$R = substr($couleur, 1, 2);
	$rouge = hexdec($R);
	$V = substr($couleur, 3, 2);
	$vert = hexdec($V);
	$B = substr($couleur, 5, 2);
	$bleu = hexdec($B);
	$tbl_couleur = array();
	$tbl_couleur['R'] = $rouge;
	$tbl_couleur['V'] = $vert;
	$tbl_couleur['B'] = $bleu;
	return $tbl_couleur;
}

// conversion pixel -> millimeter at 72 dpi
function px2mm($px){
	return $px * 25.4 / 72;
}
function txtentities($html){
	$trans = get_html_translation_table(HTML_ENTITIES);
	$trans = array_flip($trans);
	return strtr($html, $trans);
}
class ApretastePDF extends FPDF {
	public $angle;
	
	// variables of html parser
	var $B;
	var $I;
	var $U;
	var $HREF;
	var $fontList;
	var $issetfont;
	var $issetcolor;
	var $ProcessingTable = false;
	var $aCols = array();
	var $TableX;
	var $HeaderColor;
	var $RowColors;
	var $ColorIndex;
	function ApretastePDF($orientation = 'P', $unit = 'mm', $format = 'A4'){
		// Call parent constructor
		$this->FPDF($orientation, $unit, $format);
		// Initialization
		$this->B = 0;
		$this->I = 0;
		$this->U = 0;
		$this->HREF = '';
		$this->fontlist = array(
				'arial',
				'times',
				'courier',
				'helvetica',
				'symbol'
		);
		$this->issetfont = false;
		$this->issetcolor = false;
	}
	function WriteHTML($html){
		// HTML parser
		$html = strip_tags($html, "<b><u><i><a><img><p><br><strong><em><font><tr><blockquote>"); // supprime tous les tags sauf ceux reconnus
		$html = str_replace("\n", ' ', $html); // remplace retour à la ligne par un espace
		$a = preg_split('/<(.*)>/U', $html, - 1, PREG_SPLIT_DELIM_CAPTURE); // éclate la chaîne avec les balises
		foreach ( $a as $i => $e ) {
			if ($i % 2 == 0) {
				// Text
				if ($this->HREF)
					$this->PutLink($this->HREF, $e);
				else
					$this->Write(5, stripslashes(txtentities($e)));
			} else {
				// Tag
				if ($e[0] == '/')
					$this->CloseTag(strtoupper(substr($e, 1)));
				else {
					// Extract attributes
					$a2 = explode(' ', $e);
					$tag = strtoupper(array_shift($a2));
					$attr = array();
					foreach ( $a2 as $v ) {
						if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
							$attr[strtoupper($a3[1])] = $a3[2];
					}
					$this->OpenTag($tag, $attr);
				}
			}
		}
	}
	function OpenTag($tag, $attr){
		// Opening tag
		switch ($tag) {
			case 'STRONG' :
				$this->SetStyle('B', true);
				break;
			case 'EM' :
				$this->SetStyle('I', true);
				break;
			case 'B' :
			case 'I' :
			case 'U' :
				$this->SetStyle($tag, true);
				break;
			case 'A' :
				$this->HREF = $attr['HREF'];
				break;
			case 'IMG' :
				if (isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
					if (! isset($attr['WIDTH']))
						$attr['WIDTH'] = 0;
					if (! isset($attr['HEIGHT']))
						$attr['HEIGHT'] = 0;
					$this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
				}
				break;
			case 'TR' :
			case 'BLOCKQUOTE' :
			case 'BR' :
				$this->Ln(5);
				break;
			case 'P' :
				$this->Ln(10);
				break;
			case 'FONT' :
				if (isset($attr['COLOR']) && $attr['COLOR'] != '') {
					$coul = hex2dec($attr['COLOR']);
					$this->SetTextColor($coul['R'], $coul['V'], $coul['B']);
					$this->issetcolor = true;
				}
				if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
					$this->SetFont(strtolower($attr['FACE']));
					$this->issetfont = true;
				}
				break;
		}
	}
	function CloseTag($tag){
		// Closing tag
		if ($tag == 'STRONG')
			$tag = 'B';
		if ($tag == 'EM')
			$tag = 'I';
		if ($tag == 'B' || $tag == 'I' || $tag == 'U')
			$this->SetStyle($tag, false);
		if ($tag == 'A')
			$this->HREF = '';
		if ($tag == 'FONT') {
			if ($this->issetcolor == true) {
				$this->SetTextColor(0);
			}
			if ($this->issetfont) {
				$this->SetFont('arial');
				$this->issetfont = false;
			}
		}
	}
	function SetStyle($tag, $enable){
		// Modify style and select corresponding font
		$this->$tag += ($enable ? 1 : - 1);
		$style = '';
		foreach ( array(
				'B',
				'I',
				'U'
		) as $s ) {
			if ($this->$s > 0)
				$style .= $s;
		}
		$this->SetFont('', $style);
	}
	function PutLink($URL, $txt){
		// Put a hyperlink
		$this->SetTextColor(0, 0, 255);
		$this->SetStyle('U', true);
		$this->Write(5, $txt, $URL);
		$this->SetStyle('U', false);
		$this->SetTextColor(0);
	}
	function Rotate($angle, $x = -1, $y = -1){
		if ($x == - 1)
			$x = $this->x;
		if ($y == - 1)
			$y = $this->y;
		if ($this->angle != 0)
			$this->_out('Q');
		$this->angle = $angle;
		if ($angle != 0) {
			$angle *= M_PI / 180;
			$c = cos($angle);
			$s = sin($angle);
			$cx = $x * $this->k;
			$cy = ($this->h - $y) * $this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, - $s, $c, $cx, $cy, - $cx, - $cy));
		}
	}
	function Header(){
		// Print the table header if necessary
		if ($this->ProcessingTable)
			$this->TableHeader();
	}
	function TableHeader(){
		$this->SetFont('Arial', 'B', 12);
		$this->SetX($this->TableX);
		$fill = ! empty($this->HeaderColor);
		if ($fill)
			$this->SetFillColor($this->HeaderColor[0], $this->HeaderColor[1], $this->HeaderColor[2]);
		foreach ( $this->aCols as $col )
			$this->Cell($col['w'], 6, $col['c'], 1, 0, 'C', $fill);
		$this->Ln();
	}
	function Row($data){
		$this->SetX($this->TableX);
		$ci = $this->ColorIndex;
		$fill = ! empty($this->RowColors[$ci]);
		
		if ($fill)
			$this->SetFillColor($this->RowColors[$ci][0], $this->RowColors[$ci][1], $this->RowColors[$ci][2]);
		
		foreach ( $this->aCols as $col )
			$this->Cell($col['w'], 5, $data[$col['f']], 1, 0, $col['a'], $fill);
		
		$this->Ln();
		$this->ColorIndex = 1 - $ci;
	}
	function CalcWidths($width, $align){
		// Compute the widths of the columns
		$TableWidth = 0;
		foreach ( $this->aCols as $i => $col ) {
			$w = $col['w'];
			if ($w == - 1)
				$w = $width / count($this->aCols);
			elseif (substr($w, - 1) == '%')
				$w = $w / 100 * $width;
			$this->aCols[$i]['w'] = $w;
			$TableWidth += $w;
		}
		// Compute the abscissa of the table
		if ($align == 'C')
			$this->TableX = max(($this->w - $TableWidth) / 2, 0);
		elseif ($align == 'R')
			$this->TableX = max($this->w - $this->rMargin - $TableWidth, 0);
		else
			$this->TableX = $this->lMargin;
	}
	function AddCol($field = -1, $width = -1, $caption = '', $align = 'L'){
		// Add a column to the table
		if ($field == - 1)
			$field = count($this->aCols);
		$this->aCols[] = array(
				'f' => $field,
				'c' => $caption,
				'w' => $width,
				'a' => $align
		);
	}
	function Table($query, $prop = array()){
		// Issue query
		$res = q($query);
		if (! isset($res[0]))
			return false;
			// Add all columns if none was specified
		if (count($this->aCols) == 0) {
			$nb = count($res[0]);
			for($i = 0; $i < $nb; $i ++)
				$this->AddCol();
		}
		
		$xcols = array_keys($res[0]);
		
		// Retrieve column names when not specified
		foreach ( $this->aCols as $i => $col ) {
			if ($col['c'] == '') {
				if (is_string($col['f']))
					$this->aCols[$i]['c'] = ucfirst($col['f']);
				else
					$this->aCols[$i]['c'] = ucfirst($xcols[$i]);
			}
		}
		
		// Handle properties
		if (! isset($prop['width']))
			$prop['width'] = 0;
		if ($prop['width'] == 0)
			$prop['width'] = $this->w - $this->lMargin - $this->rMargin;
		if (! isset($prop['align']))
			$prop['align'] = 'C';
		if (! isset($prop['padding']))
			$prop['padding'] = $this->cMargin;
		$cMargin = $this->cMargin;
		$this->cMargin = $prop['padding'];
		if (! isset($prop['HeaderColor']))
			$prop['HeaderColor'] = array();
		$this->HeaderColor = $prop['HeaderColor'];
		if (! isset($prop['color1']))
			$prop['color1'] = array();
		if (! isset($prop['color2']))
			$prop['color2'] = array();
		$this->RowColors = array(
				$prop['color1'],
				$prop['color2']
		);
		// Compute column widths
		$this->CalcWidths($prop['width'], $prop['align']);
		// Print header
		$this->TableHeader();
		// Print rows
		$this->SetFont('Arial', '', 11);
		$this->ColorIndex = 0;
		$this->ProcessingTable = true;
		foreach ( $res as $row )
			$this->Row($row);
		$this->ProcessingTable = false;
		$this->cMargin = $cMargin;
		$this->aCols = array();
	}
}