<?php
namespace tequila\mvc\vistas;
use \stdClass;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Clase que administra las plantillas de impresión
*
* Cada instancia de la clase debe estar ligada an archivo php que funciona como plantilla dehtml de la presentación de una petición
* Las vistas pueden tener ligadas páginas master y otras vistas complementarias,
* en resumen una vista puede tener una sola página master pero puede llamar cualquier cantidad de vistas
*
* @package	tequila.mvc
* @author	isaac
* @version	2
*/
class Vista{
	/**
	* Nombre del archivo de la plantilla
	*
	* @access	protected
	* @var		string
	*/
	protected $plantilla;

	/**
	* Colección de variables, datos, objetos que puede llamar la plantilla
	*
	* @access	public
	* @var		stdClass
	*/
	public $coleccion;

	/**
	* Pagina vista a la que puede pertenecer la vista
	*
	* @access	public
	* @var		Master
	*/
	public $master;

	/**
	* Contenido parseado de la plantilla html
	*
	* @access	protected
	* @var		string
	*/
	protected $contenido;

	/**
	* Constructor
	*
	* Recibe el nombre de la plantilla y la colección de datos de la vista
	*
	* @param	string		$plantilla		El nombre completo del archivo de la plantilla
	* @param	stdClass	$coleccion		La colección de datos que podrá usar la vista
	* @access	public
	*/
	public function __construct( $plantilla, stdClass $coleccion = null )
	{
		$this->archivo = 'app' . DS . 'vistas' . DS . str_replace( array( '.', '/' ), DS, $plantilla ) . EXT;
		if ( !file_exists( $this->archivo ) )
		{
			throw new VistaPerdidaException( $this->archivo );
		}
		$this->coleccion = isset( $coleccion ) ? $coleccion : new stdClass;
	}

	/**
	* Genera el contenido de la vista y lo almacena
	*
	* @access	public
	*/
	public function generar()
	{
		ob_start();
		foreach ( $this->coleccion as $indice => $dato )
		{
			$$indice = $dato;
		}
		require $this->archivo;
		$this->contenido = ob_get_clean();
	}

	/**
	* Incluye una vista extra a las vista actual
	*
	* Se debe espacíficar solamente el nombre de la plantilla
	*
	* @param	string		$nombre		El nombre del archivo de la plantilla
	* @param	string		$carpeta	Carpeta donde se encuantra la vista, si no se especifica se obtendra de la carpeta _extra
	* @return	Vista
	* @access	public
	*/
	public function importar( $nombre, $carpeta = '_extra' )
	{
		$vista = new self( $carpeta . '.' . $nombre, $this->coleccion );
		$vista->generar();
		return $vista;
	}

	/**
	* Imprime los paquetes dados
	*
	* @param	array		$paquetes	Colección de paquetes a imprimir
	* @access	public
	*/
	public function dibujarPaquetes( array $paquetes = array() )
	{
		foreach ( $paquetes as $paquete )
		{
			echo $paquete->dibujar();
		}
	}

	/**
	* Devuelve el contenido generado de la vista
	*
	* @access	public
	* @return	string
	*/
	public function dibujar()
	{
		return $this->contenido;
	}

	/**
	* Devuelve el contenido generado de la vista
	*
	* @access	public
	* @return	string
	*/
	public function __toString()
	{
		return $this->contenido;
	}
}