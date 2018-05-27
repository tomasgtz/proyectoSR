<?php
namespace tequila\plugins\excel;
use \PHPExcel, \PHPExcel_IOFactory;
/**
* Esta clase representa un correo electrónico
*
* Se debe instanciar un objeto por correo.
* No es recomendable para enviar varios correos en un ciclo
*
* @package	tequila.utilidades
* @author	isaac
* @version	2
*/
require 'tequila/plugins/excel/PHPExcel.php';
class Excel extends PHPExcel{
	/**
	* Nombre del archivo a descargar
	*
	* @access	public
	* @var		string
	*/
	public $nombre;

	/**
	* Constructor
	*
	* Establece el nombre del archivo
	*
	* @param	string		$nombre		El nombre del archivo
	* @access	public
	*/
	public function __construct( $nombre )
	{
		parent::__construct();
		$this->nombre = $nombre;
	}

	/**
	* Manda a descargar el archivo excel
	*
	* @access	public
	*/
	public function descargar()
	{
		header( 'Content-Type: application/vnd.ms-excel' );
		header( 'Content-Disposition: attachment;filename="' . $this->nombre . '.xls"' );
		header( 'Cache-Control: max-age=0' );
		$export = PHPExcel_IOFactory::createWriter( $this, 'Excel5' );
		$export->save( 'php://output' );
		exit;
	}
}