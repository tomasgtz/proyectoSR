<?php
namespace tequila\mvc;
use \Exception;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Esta excepción es lanzada cuando se detecta un problema con un modelo
*
* Los problemas que se pueden detectar es la validación y el guardado de modelos
*
* @package	tequila.mvc
* @author	isaac
* @version	1
*/
class ModeloException extends Exception{
	/**
	* Constructor
	*
	* Establece el mensaje de error de la excepción
	*
	* @param	string	$mensaje		El mensaje de error
	* @access	public
	*/
	public function __construct( $mensaje )
	{
		parent::__construct( $mensaje );
	}
}