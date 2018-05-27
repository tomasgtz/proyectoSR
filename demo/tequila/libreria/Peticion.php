<?php
namespace tequila\libreria;
use tequila\contexto\Contexto;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Maneja los datos iniciales de la petición
*
* Tiene funciones de acceso a las superglobales de PHP,
* guarda de manera estática los datos de entrada de la petición
* (nombre del controlador, acción a ejecutar)
*
* @package	tequila.libreria
* @author	isaac
* @version	1
*/
class Peticion{
	/**
	* Carpetas y nombre del controlador
	*
	* @access	public
	* @var		array
	*/
	public $controlador;
	
	/**
	* Nombre de la acción a ejecutar
	*
	* @access	public
	* @var		string
	*/
	public $accion;
	
	/**
	* Colección de parametros de la petición
	*
	* @access	public
	* @var		array
	*/
	public $parametros = array();
	
	/**
	* Url real de la petición
	*
	* @access	public
	* @var		string
	*/
	public $url;
	
	/**
	* Método de la petición actual
	*
	* @access	public
	* @var		string
	*/
	public $metodo;

	/**
	* Valores que se encuentran en el queryString de la url
	*
	* @access	public
	* @var		array
	*/
	public $gets = array();
	
	/**
	* Constructor
	*
	* Establece el valor de la bandera $esPost
	*
	* @access	public
	*/
	public function __construct()
	{
		$this->metodo = $this->server( 'REQUEST_METHOD' );
		$this->gets = $_GET;
		unset( $this->gets[ 'url' ] );
	}
	
	/**
	* Devuelve un dato de la superglobal $_POST
	*
	* En caso de no existir el valor buscado se devuelve "null"
	*
	* @param	string		$indice		El indice del dato a buscar
	* @param	string		$default	El valor que devolverá en caso de ser un valor vacío
	* @access	public
	* @return	mixed
	*/
	public function post( $indice, $default = null )
	{
		if ( !isset( $_POST[$indice] ) )
		{
			return $default;
		}
		if ( is_array( $_POST[$indice] ) )
		{
			return $_POST[$indice];
		}
		$resultado = trim( $_POST[$indice] );
		return ( $resultado === '' ) ? $default : $resultado;
	}

	/**
	* Devuelve un dato de la superglobal $_GET
	*
	* En caso de no existir el valor se devuelve null
	*
	* @param	string		$indice		El indice del dato a buscar
	* @param	string		$default	El valor que devolverá en caso de ser un valor vacío
	* @access	public
	* @return	mixed
	*/
	public function get( $indice, $default = null )
	{
		if ( !isset( $_GET[$indice] ) )
		{
			return $default;
		}
		if ( is_array( $_GET[$indice] ) )
		{
			return $_GET[$indice];
		}
		$resultado = trim( $_GET[$indice] );
		return ( $resultado === '' ) ? $default : $resultado;
	}

	/**
	* Crea un modelo utilizando valores recibidos en un formulario
	*
	* Se debe recibir el contexto que generé el modelo deseado
	*
	* @param	Contexto	$contexto	El contexto que generará la instancia del modelo
	* @access	public
	* @return	Modelo
	*/
	public function recibir( Contexto $contexto )
	{
		$modelo  = $contexto->instancia();
		$propiedades = array_merge( array_keys( $contexto->propiedades ), array( 'id' ) );
		foreach ( $propiedades as $propiedad )
		{
			if ( isset( $_POST[$propiedad] ) )
			{
				$modelo->$propiedad = $this->post( $propiedad );
			}
		}
		return $modelo;
	}
	
	/**
	* Devuelve un dato de la superglobal $_SERVER
	*
	* En caso de no existir el valor buscado se devuelve "null"
	*
	* @param	string	$indice		El indice del dato a buscar
	* @access	public
	* @return	string
	*/
	public function server( $indice )
	{
		return isset( $_SERVER[$indice] ) ? $_SERVER[$indice] : null;
	}

	/**
	* Devuelve el arreglo de encabezados personalizados
	*
	* @access	public
	* @return	array
	*/
	public function headers()
	{
		return apache_request_headers();
	}
	
	/**
	* Devuelve un dato de la superglobal $_SERVER
	*
	* En caso de no existir el valor buscado se devuelve "null"
	*
	* @param	string	$indice		El indice del dato a buscar
	* @access	public
	* @return	array
	*/
	public function files( $indice )
	{

		return isset( $_FILES[$indice] ) ? $_FILES[$indice] : array();
	}
	
	/**
	* Devuelve si existen archivos subidos en la petición
	*
	* @access	public
	* @return	bool
	*/
	public function hayArchivos()
	{
		return !empty( $_FILES );
	}
}