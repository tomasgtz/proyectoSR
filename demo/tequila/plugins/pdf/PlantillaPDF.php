<?php
namespace tequila\plugins\pdf;
use \FPDI;
/**
* Clase para generar documentos pdf en base a una plantilla
*
* @package	tequila.plugins
* @author	isaac
* @version	1
*/
require 'tequila' . DS . 'plugins' . DS . 'pdf' . DS . 'fpdf' . DS . 'tfpdf' . EXT;
require 'tequila' . DS . 'plugins' . DS . 'pdf' . DS . 'fpdi' . DS . 'fpdi' . EXT;
class PlantillaPDF extends FPDI{
	/**
	* Añade la plantilla del pdf a utilizar
	*
	* @access	public
	* @param	string		$plantilla	El archvivo a utilizar como plantilla
	* @param	int			$pagina		La pagina del pdf a utilizar
	* @param	int			$ancho		El ancho de la plantilla (en mm)
	*/
	public function addPlantilla( $plantilla, $pagina = 1, $ancho = 210 )
	{
		$this->AddPage();
		$this->setSourceFile( $plantilla );
		$tplIdx = $this->importPage( $pagina );
		$this->useTemplate( $tplIdx, 0, 0, $ancho );
	}

	/**
	* Override para Cell
	*
	* Decodifica en utf-8
	*
	* @access	public
	* @param	float	$w			Ancho de la celda
	* @param	float	$h			Altura de la celda
	* @param	string	$txt		Texto que contiene la celda
	* @param	mixed	$border		El tipo de borde
	* @param	int		$ln			El salto de línea para la próxima celda
	* @param	string	$align		Alineación del texto en la celda
	* @param	bool	$fill		Bandera que indica si se rellenará de color la celda
	* @param	mixed	$link		URL o identificador de AddLink
	*/
	public function Cell( $w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '' )
	{
		parent::Cell( $w, $h, utf8_decode( $txt ), $border, $ln, $align, $fill, $link );
	}

	/**
	* Override para MultiCell
	*
	* Decodifica en utf-8
	*
	* @access	public
	* @param	float	$w			Ancho de la celda
	* @param	float	$h			Altura de la celda
	* @param	string	$txt		Texto que contiene la celda
	* @param	mixed	$border		El tipo de borde
	* @param	int		$ln			El salto de línea para la próxima celda
	* @param	string	$align		Alineación del texto en la celda
	* @param	bool	$fill		Bandera que indica si se rellenará de color la celda
	*/
	public function MultiCell( $w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false )
	{
		parent::MultiCell( $w, $h, utf8_decode( $txt ), $border, $ln, $align, $fill );
	}

	/**
	* Escribe un texto en las coordenadas y con el tamaño dado
	*
	* @access	public
	* @param	float	$x			Posición en x
	* @param	float	$y			Posición en y
	* @param	float	$w			Ancho de la celda
	* @param	float	$h			Altura de la celda
	* @param	string	$txt		Texto que contiene la celda
	*/
	public function celda( $x, $y, $w, $h, $txt, $align = 'L' )
	{
		$this->SetXY( $x, $y );
		$this->Cell( $w, $h, $txt, 0, 0, $align );
	}

	/**
	* Escribe un texto en las coordenadas y con el tamaño dado en una multicelda
	*
	* @access	public
	* @param	float	$x			Posición en x
	* @param	float	$y			Posición en y
	* @param	float	$w			Ancho de la celda
	* @param	float	$h			Altura de la celda
	* @param	string	$txt		Texto que contiene la celda
	* @param	string	$align		Alineación del texto en la celda
	*/
	public function multiCelda( $x, $y, $w, $h, $txt, $align = 'L' )
	{
		$this->SetXY( $x, $y );
		$this->MultiCell( $w, $h, $txt, 0, $align );
	}
}