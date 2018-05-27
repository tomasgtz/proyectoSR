<?php
namespace tequila\libreria\respuesta;
use tequila\libreria\respuesta\Respuesta, tequila\mvc\Vista;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Manda de respuesta a una petición texto plano.
*
* @package	tequila.libreria.respuesta
* @author	isaac
* @version	1
*/
class RespuestaTexto extends Respuesta{
	/**
	* Constructor
	*
	* Recibe el texto y lo convierte en contenido
	*
	* @param	string	$texto			El texto a desplegar
	* @param	array	$encabezados	Arreglo de encabezados opcionales
	* @access	public
	*/
	public function __construct( $texto, array $encabezados = array() )
	{
		parent::__construct( $encabezados );
		$this->contenido = $texto;
		$this->type = 'text/plain';
	}
}