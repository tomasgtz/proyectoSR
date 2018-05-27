<?php
use tequila\libreria\respuesta\Respuesta, tequila\mvc\Vista;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Realiza una redirección de petición
*
* Está dada de alta en el autoload como clase simple
*
* @package	tequila.libreria.respuesta
* @author	isaac
* @version	1
*/
class Redirect{
	/**
	* Constructor
	*
	* Recibe la url a donde se realizará la redirección
	*
	* @param	string		$url		La url a donde se dirigirá la petición
	* @access	public
	*/
	public function __construct( $url )
	{
		header( 'Location: ' . $url, true, 302 );
		exit( 0 );
	}
}