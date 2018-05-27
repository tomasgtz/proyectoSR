<?php
namespace tequila\scaffolding;
/**
* Clase para la generación de código por medio de un contexto
*
* @package	tequila.scaffolding
* @author	isaac
* @version	1
*/
class Scaffolding{
	/**
	* Contexto al que se le generarán las demás clases complementarias
	*
	* @access	public
	* @var		Contexto
	*/
	public $contexto;

	/**
	* Obtiene la ruta de carpetas donde se almacenarán los archivos
	*
	* @access	public
	* @var		string
	*/
	public $carpetas;

	/**
	* La ruta de las carpetas an teponiendo un "\" en caso de tener contenido
	*
	* @access	public
	* @var		string
	*/
	public $ruta = '';

	/**
	* Texto del nombre final de la clase contexto
	*
	* @access	public
	* @var		string
	*/
	public $nombre;

	/**
	* Permiso para utilizar el controlador
	*
	* @access	public
	* @var		string
	*/
	public $permiso;

	/**
	* Nombre del proyecto
	*
	* @access	public
	* @var		string
	*/
	public $proyecto;

	/**
	* Nombre de la página master
	*
	* @access	public
	* @var		string
	*/
	public $master;

	/**
	* Constructor
	*
	* Se establece el contexto en base al nombre
	*
	* @param	string		$contexto	El nombre del contexto
	* @param	string		$permiso	El permiso necesario para utilizar el controlador
	* @param	string		$master		El nombre que tendrá la página master
	* @param	string		$proyecto	El nombre del proyecto
	* @access	public
	*/
	public function __construct( $contexto, $permiso, $master, $proyecto = 'SCAFFOLDING' )
	{
		$clase = 'app\\contextos\\' . $contexto;
		if ( !class_exists( $clase ) )
		{
			die( 'La clase ' . $clase . ' no existe' );
		}
		$this->contexto = new $clase;
		$secciones = explode( '\\', $contexto );
		$this->nombre = array_pop( $secciones );
		$this->permiso = $permiso;
		$this->master = $master;
		$this->carpetas = $secciones;
		$this->proyecto = $proyecto;
		if ( !empty( $this->carpetas ) )
		{
			$this->ruta = '\\' . join( '\\', $this->carpetas );
		}
	}

	/**
	* Crea el modelo que relacionado con el contexto
	*
	* @access	public
	*/
	public function modelo()
	{
		$modelo = new Modelo( $this );
		$modelo->generar();
	}

	/**
	* Crea el controlador relacionado con el contexto
	*
	* @access	public
	*/
	public function controlador()
	{
		$controlador = new Controlador( $this );
		$controlador->generar();
	}

	/**
	* Crea las vistas del contexto
	*
	* @access	public
	*/
	public function vista()
	{
		$vista = new Vista( $this );
		$vista->generar();
	}
}