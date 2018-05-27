<?php
namespace tequila\libreria\respuesta;
use tequila\libreria\respuesta\Respuesta, tequila\mvc\vistas\Vista;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Manda de respuesta a una petición una vista.
*
* @package	tequila.libreria.respuesta
* @author	isaac
* @version	1
*/
class RespuestaVista extends Respuesta{
	/**
	* Constructor
	*
	* Recibe la vista y la convierte en contenido
	*
	* @param	Vista	$vista			La vista a desplegar en el navegador
	* @param	array	$encabezados	Arreglo de encabezados opcionales
	* @access	public
	*/
	public function __construct( Vista $vista, array $encabezados = array() )
	{
		parent::__construct( $encabezados );
		$vista->generar();
		$this->contenido = $vista->dibujar();
	}
}