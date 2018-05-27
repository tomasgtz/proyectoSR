<?php
namespace tequila\mvc\vistas;
use \stdClass;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Clase que administra las plantillas de impresión de páginas maste3r
*
* Debe estar ligada a una vista, la vista puede manupular datos opcfionales de la página master
*
* @package	tequila.mvc.vistas
* @author	isaac
* @version	1
*/
class Master extends Vista{
	/**
	* Colección de paquetes que tiene cargados la pagina master
	*
	* @access	protected
	* @var		array
	*/
	protected $paquetes = array();

	/**
	* Constructor
	*
	* Inicializa colecciones que utiliza la pagina master
	*
	* @param	string		$plantilla		El nombre completo del archivo de la plantilla
	* @param	stdClass	$coleccion		La colección de datos que podrá usar la vista
	* @access	public
	*/
	public function __construct( $plantilla, stdClass $coleccion = null )
	{
		parent::__construct( $plantilla, $coleccion );
		$this->coleccion->vista->master = $this;
		$this->coleccion->vista->generar();
	}

	/**
	* Guarda paquetes de archivos o metatags que se incluyen en el header de una pagina html
	*
	* @param	Paquete		$paquete[]	Colección de paquetes
	* @access	public
	*/
	public function paquetes()
	{
		$this->paquetes = array_merge( func_get_args(), $this->paquetes );
	}

	/**
	* Override de la función padre, imprime los paquetes guardados
	*
	* @param	array		$paquetes	Colección de paquetes a imprimir
	* @access	public
	*/
	public function dibujarPaquetes( array $paquetes = array() )
	{
		parent::dibujarPaquetes( array_merge( $this->paquetes, $paquetes ) );
	}
}