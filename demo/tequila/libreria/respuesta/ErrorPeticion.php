<?php
namespace tequila\libreria\respuesta;
use tequila\mvc\vistas\Vista;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Esta clase manda una página de no encontrado como respuesta
*
* Si se tiene el modo debug encendido,
* dispara un error en lugar de mandar la página de "not found"
*
* @package	tequila.respuesta
* @author	isaac
*/
class ErrorPeticion extends Respuesta{
	/**
	* Constructor
	*
	* Recibe el mensaje de error
	*
	* @param	string	$error			Descripción opcional del error
	* @access	public
	*/
	public function __construct( $error = '' )
	{
		if ( DEBUG )
		{
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( 'Página no encontrada... ' . $error );
		}
		$vista = new Vista( '_extra.error' );
		$vista->generar();
		$this->contenido = $vista->dibujar();
		$this->codigo = 404;
		$this->mensaje = 'Not Found';
	}
}