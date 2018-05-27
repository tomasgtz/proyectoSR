<?php
namespace tequila\mvc;
use tequila\inicio\Boot, tequila\mvc\vistas\Vista, tequila\mvc\vistas\Master, tequila\libreria\Respuesta, tequila\libreria\respuesta\ErrorPeticion,
tequila\libreria\respuesta\RespuestaVista, tequila\libreria\respuesta\RespuestaJson, \stdClass;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Clase base de los controladores del framework
*
* Representa la capa de comportamiento,
* aquí se realizan las llamadas a todas las demás funciones de la petición.
* Los siguientes nombres de funciones no podrán ser usados en los controladores de la app
* "procesar", "respuestaVista", "respuestaJson", "errorPeticion"
*
* @package	tequila.mvc
* @author	isaac
* @version	1
*/
class Controlador{
	/**
	* Objeto de la petición
	*
	* @access	public
	* @var		Petición
	*/
	public $peticion;
	
	/**
	* Colección de datos que se enviarán a la vista si se utiliza el método default
	*
	* @access	protected
	* @var		stdClass
	*/
	protected $coleccion;
	
	/**
	* Objeto de contexto principal del Controlador
	*
	* Debe instanciarse en un override del contructor
	*
	* @access	protected
	* @var		Contexto
	*/
	protected $contexto;

	/**
	* Atributos que puede tener la página master
	*
	* @access	protected
	* @var		array
	*/
	protected $masters;
	
	/**
	* Constructor
	*
	* Instancía los objetos de petición y de respuesta
	*
	* @access	public
	*/
	public function __construct()
	{
		$this->peticion = Boot::$peticion;
		$this->coleccion = new stdClass;
		$this->masters = new stdClass;
	}
	
	/**
	* Devuelve como una respuesta la vista default
	*
	* Se le puede asignar la página master,
	* estas deben estar guardadas en la carpeta de "_extra"
	*
	* @param	string		$master			Nombre de la página master en caso de usuarse
	* @param	string		$accion			Acción del mismo controlador que puede compartir la vista
	* @param	array		$encabezados	Si se desean enviar encabezados opcionales a la respuesta
	* @access	protected
	* @return	RespuestaVista
	*/
	public function respuestaVista( $master = null, $accion = null, array $encabezados = array() )
	{
		if ( !isset( $accion ) )
		{
			$accion = $this->peticion->accion;
		}
		$vista = new Vista( join( '.', $this->peticion->controlador ) . '.' . $accion, $this->coleccion );
		if ( isset( $master ) )
		{
			$this->masters->vista = $vista;
			return new RespuestaVista( new Master( '_extra.' . $master, $this->masters ), $encabezados );
		}
		return new RespuestaVista( $vista, $encabezados );
	}

	/**
	* Devuelve como respuesta un json
	*
	* Recibe un arreglo que se convertirá enb el json de respuesta
	*
	* @param	array		$json			El json de respuesta
	* @param	array		$encabezados	Si se desean enviar encabezados opcionales a la respuesta
	* @access	protected
	* @return	RespuestaJson
	*/
	public function respuestaJson( array $json, array $encabezados = array() )
	{
		return new RespuestaJson( $json, $encabezados );
	}
	
	/**
	* Manda un error de petición
	*
	* @access	public
	*/
	public function errorPeticion()
	{
		return new ErrorPeticion();
	}
}
