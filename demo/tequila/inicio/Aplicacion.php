<?php
namespace tequila\inicio;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Esta clase contiene metodos que se ejecuntan en eventos globales de la petición
*
* Contiene una funciones predefinidas pero esta clase puede ser
* modificada completamente sin afectar el uso del framework,
* solo no se pueden borrar metodos
* Recibe el objeto con las rutas para realizar modificaciones
* estas modificaciones deben realizarse en el método antesDeControlador()
*
* @package	tequila.inicio
* @author	isaac
*/
class Aplicacion{
	/**
	* Objeto de rutas
	*
	* @access	private
	* @var		Rutas
	*/
	private $rutas;
	
	/**
	* Constructor
	*
	* Establece el objeto de rutas
	*
	* @param	Rutas		$rutas		La ruta de la petición actual
	* @access	public
	*/
	public function __construct( Rutas $rutas )
	{
		$this->rutas = $rutas;
	}
	
	/**
	* Esta función se ejecuta antes de instanciar el controlador
	*
	* Puede servir para establecer funciones por default de la petición
	* como por ejemplo establecer el locale o iniciar benchmarking
	*
	* @access	public
	*/
	public function antesDeControlador()
	{
		setlocale( LC_ALL, 'es-ES' );
		date_default_timezone_set( 'America/Monterrey' );
		header( "X-Powered-By: Innsert's Tequila Framework" );
	}
}