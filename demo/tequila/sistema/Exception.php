<?php
namespace tequila\sistema;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Excepci�n general del sistema,
*
* Las dem�s excepciones se extienden de esta
*
* @package	tequila.sistema
* @author	isaac
* @version	1
*/
class Exception extends \Exception{
	/**
	* Constructor
	*
	* A�ade el mensaje de error a un log antes de ser lanzada la excepci�n
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