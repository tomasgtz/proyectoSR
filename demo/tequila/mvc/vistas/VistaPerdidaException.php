<?php
namespace tequila\mvc\vistas;
use tequila\sistema\Exception;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Excepción que es lanzada cuando no se encuentra la plantilla de vista
*
* @package	tequila.mvc
* @author	isaac
* @version	1
*/
class VistaPerdidaException extends Exception{
	/**
	* Constructor
	*
	* Establece el mensaje de error de la excepción
	*
	* @param	string		$archivo		El archivo de plantilla no encontrado
	* @access	public
	*/
	public function __construct( $archivo )
	{
		parent::__construct( 'Plantilla de vista no encontrada (' . $archivo . ')' );
	}
}