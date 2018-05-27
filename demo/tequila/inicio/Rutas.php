<?php
namespace tequila\inicio;
use tequila\sistema\Configurable;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Manejador de las rutas de la aplicación
*
* Los valores por defecto de la ruta se colocan en la llave "__defaults"
* (tiene doble guión bajo)
* de atras hacia adelante los valores son "acción", "controlador" y
* el resto de los valores son "subcarpetas" para el controlador
* '__defaults' => array(
*		'hogar',
*		'inicio',
*		'index'
* )
* los atajos a controladores solo son posibles del tipo
* :controlador/:id
* solo se ingresa el nombre que identificará el atajo
* por eso el nombre atajo es preferible que sea diferente a cualquier carpeta
* de controlador
* ej:
* 'publicaciones' => array(
*		'hogar',
*		'publicaciones',
*		'ver'
* )
*
* @package	tequila.inicio
* @author	isaac
* @version	1
*/
class Rutas extends Configurable{
	/**
	* Ruta donde se encuantra el archivo de configuración de esta clase
	*
	* @access	protected
	* @var		array
	*/
	protected $_ruta = array( 'tequila', 'RutasConfiguracion' );
	
	/**
	* Las partes que tiene la url recibida
	*
	* @access	public
	* @var		string
	*/
	public $partes;
	
	/**
	* Ruta y nombre del controlador
	*
	* El nombre y la ruta de carpetas para llegar al controlador se alemacenan en este arreglo
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
	* Parametros que se pasarán a la acción definida
	*
	* @access	public
	* @var		array
	*/
	public $parametros;
	
	/**
	* Constructor
	*
	* Realiza la separación de la url y ejecuta las funciones de parseo
	*
	* @param	string	$url		La url de la petición actual
	* @access	public
	*/
	public function __construct( $url )
	{
		parent::__construct();
		$this->partes = array_diff( explode( '/', $url ), array( '' ) );
		$this->parsear();
		$this->ajustes();
	}
	
	/**
	* Revisa las secciones de la url y establece los valores de controlador correspondientes
	*
	* @access	private
	*/
	private function parsear()
	{
		if ( empty( $this->partes ) )
		{
			$partes = $this->_config[ '__defaults' ];
			$this->parametros = array();
		}
		elseif ( array_key_exists( $this->partes[ 0 ], $this->_config ) )
		{
			$resultado = array_replace( $this->_config[ $this->partes[ 0 ] ], $this->partes );
			$partes = array_splice( $resultado, 0, count( $this->_config[ $this->partes[ 0 ] ] ) );
			$this->parametros = $resultado;
		}
		else
		{
			$resultado = array_replace( $this->_config[ '__defaults' ], $this->partes );
			$partes = array_splice( $resultado, 0, count( $this->_config[ '__defaults' ] ) );
			$this->parametros = $resultado;
		}
		$this->accion = array_pop( $partes );
		if ( ctype_digit( $this->accion ) )
		{
			array_unshift( $this->parametros, $this->accion );
			$this->accion = end( $this->_config[ '__defaults' ] );
		}
		$this->controlador = $partes;
	}

	/**
	* Realiza ajustes en el controlador para reemplazar caracteres no validos en php
	*
	* @access	private
	*/
	private function ajustes()
	{
		foreach ( $this->controlador as &$seccion )
		{
			$seccion = str_replace( array( '-', '%' ), '_', $seccion );
		}
		$this->accion = str_replace( array( '-', '%' ), '_', $this->accion );
	}
}