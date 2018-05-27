<?php
namespace tequila\inicio;
use tequila\libreria\Peticion, tequila\libreria\respuesta\ErrorPeticion, tequila\libreria\respuesta\Respuesta;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Clase inicial del framework.
*
* Instancía las clases necesarias para cada petición.
* Empieza por el enrrutamiento (ver clase tequila\inicio\Rutas).
* Después viene iniciador de la aplicación (ver clase tequila\inicio\Aplicación),
* esta clase inicializa funciones de la petición y puede ser modificada por el usuario
* para añadir funciones que desee.
* Se termina instanciando el controlador correcto y estableciendo las propiedades
* iniciales de la petición.
*
* @package	tequila.inicio
* @author	isaac
* @version	1
*/
class Boot{
	/**
	* Propiedad que contiene el objeto de la petición
	*
	* Ésta es una propiedad estática de la clase
	*
	* @static
	* @access	public
	* @var		Peticion
	*/
	public static $peticion;

	/**
	* Objeto de Rutas
	*
	* @access	private
	* @var		Rutas
	*/
	private $rutas;
	
	/**
	* Objeto de Aplicacion
	*
	* @access	private
	* @var		Aplicacion
	*/
	private $aplicacion;
	
	/**
	* Constructor
	*
	* Instancía el objeto de rutas, el objeto de aplicación
	* Asigna la url de la petición actual
	*
	* @access	public
	*/
	public function __construct()
	{
		$url = isset( $_GET['url'] ) ? $_GET['url'] : '';
		$this->rutas = new Rutas( $url );
		$this->aplicacion = new Aplicacion( $this->rutas );
		$this->aplicacion->antesDeControlador();
		self::$peticion = new Peticion;
		self::$peticion->url = $url;
	}
	
	/**
	* Ejecuta el controlador seleccionado
	*
	* Los datos del controlador (clase, método, etc)
	* se obtiene del obteto Rutas,
	* se establecen propiedades en la clase Petición
	*
	* @access	public
	*/
	public function ejecutar()
	{
		$clase = 'app\\controladores\\' . join( '\\', $this->rutas->controlador ) . 'Controlador';
		try
		{
			$controlador = new $clase();
		}
		catch ( ArchivoDeClaseException $ex )
		{
			$error = new ErrorPeticion( 'CLASE: ' . $ex->clase );
			$error->enviar();
		}
		$peticion = self::$peticion;
		$peticion->controlador = $this->rutas->controlador;
		$peticion->accion = $this->rutas->accion;
		$peticion->parametros = $this->rutas->parametros;
		$peticion->metodo . '_' . $peticion->accion;
		$accion = ( is_callable( array( $controlador, $peticion->metodo . '_' . $peticion->accion ) ) ) ?
			$peticion->metodo . '_' . $peticion->accion : $peticion->accion;
		if ( !is_callable( array( $controlador, $accion ) ) )
		{
			$error = new ErrorPeticion( 'ACCION:' . $peticion->accion );
			$error->enviar();
		}
		$respuesta = call_user_func_array( array( $controlador, $accion ), $this->rutas->parametros );
		if ( $respuesta instanceof Respuesta )
		{
			$respuesta->enviar();
		}
	}
}