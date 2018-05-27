<?php
namespace tequila\sistema;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Excepción general del sistema,
*
* Las demás excepciones se extienden de esta
*
* @package	tequila.sistema
* @author	isaac
* @version	1
*/
class Exception extends \Exception{
	/**
	* Constructor
	*
	* Añade el mensaje de error a un log antes de ser lanzada la excepción
	*
	* @param	string		$mensaje		El mensaje de error
	* @access	public
	*/
	public function __construct( $mensaje )
	{
		Log::add( 'excepciones', $mensaje );
		parent::__construct( $mensaje );
	}
}