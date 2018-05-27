<?php
namespace tequila\libreria\respuesta;
use tequila\libreria\respuesta\Respuesta, tequila\mvc\Vista;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Manda de respuesta a una petición un json con sus debidos encabezados.
*
* @package	tequila.libreria.respuesta
* @author	isaac
* @version	1
*/
class RespuestaJson extends Respuesta{
	/**
	* Constructor
	*
	* Recibe el json y la convierte en contenido
	*
	* @param	array	$json			El json a desplegar
	* @param	array	$encabezados	Arreglo de encabezados opcionales
	* @access	public
	*/
	public function __construct( array $json, array $encabezados = array() )
	{
		parent::__construct( $encabezados );
		$this->contenido = json_encode( $json );
		$this->type = 'application/json';
	}
}