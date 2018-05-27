<?php
namespace tequila\libreria;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Maneja la interacción con la superglobal $_SESSION
*
* @package	tequila.librería
* @author	isaac
* @version	1
*/
class Sesion{
	/**
	* Indica el "namespace" que usará la sesión en el proyecto
	*
	* Este namespace es en especial útil cuando se tienen multiples proyectos en el mismo dominio
	*
	* @static
	* @access	public
	* @var		string
	*/
	protected $proyecto = 'COLONIAS';

	/**
	* Tiempo de vida que tendrá la sesión
	*
	* @access	public
	* @var		int
	*/
	public $LIFETIME = 0;
	
	/**
	* Ruta en el dominio donde la cookie de sesión trabajará
	*
	* @access	public
	* @var		string
	*/
	public $PATH = '/';
	
	/**
	* El dominio de la cookie
	*
	* @access	public
	* @var		int
	*/
	public $DOMAIN = null;
	
	/**
	* Bandera sobre sí se trabajará en una conexión segura (HTTPS)
	*
	* @access	public
	* @var		int
	*/
	public $SECURE = false;
	
	/**
	* Bandera sobre si el id sesión es solo por cookie
	*
	* @access	public
	* @var		int
	*/
	public $HTTPONLY = true;
	
	/**
	* Constructor
	*
	* Inicia la sesión y establece parametros por default de la misma
	*
	* @access	public
	*/
	public function __construct()
	{
		if( !isset( $_SESSION ) )
		{
			session_set_cookie_params( $this->LIFETIME, $this->PATH, $this->DOMAIN, $this->SECURE, $this->HTTPONLY );
			session_start();
		}
	}
	
	/**
	* Destructor
	*
	* Ejecuta la función "session_write_close"
	*
	* @access	public
	*/
	public function __destruct()
	{
		session_write_close();
	}
	
	/**
	* Guarda una nueva llave y su valor en la sesión
	*
	* @param	string		$indice		Indice de identificación del dato
	* @param	mixed		$value		El valor a guardar
	* @access	public
	*/
	public function set( $indice, $value )
	{
		$_SESSION[$this->proyecto][$indice] = $value;
	}
	
	/**
	* Devuelve un valor de la sesión
	*
	* @param	string		$indice		El indice del valor guardado en sesión
	* @access	public
	* @return	mixed
	*/
	public function get( $indice )
	{
		return $_SESSION[$this->proyecto][$indice];
	}
	
	/**
	* Borra un dato de la sesión
	*
	* @param	string		$indice		El indice del dato a borrar
	* @access	public
	*/
	public function borrar( $indice )
	{
		unset( $_SESSION[$this->proyecto][$indice] );
	}
	
	/**
	* Indica si existe el indice buscado en la sesión
	*
	* @param	string		$indice		El indice a buscar
	* @access	public
	* @return	bool
	*/
	public function existe( $indice )
	{
		return isset( $_SESSION[$this->proyecto][$indice] );
	}
	
	/**
	* Devuelve el mensaje guardado en sesión y lo borrar
	*
	* @param	string		$indice		El indice del valor guardado en sesión
	* @access	public
	* @return	mixed
	*/
	public function getFlash( $indice )
	{
		$flash = $this->get( $indice );
		$this->borrar( $indice );
		return $flash;
	}

	/**
	* Regenera el id de la sesión
	*
	* @access	public
	*/
	public function regenerar()
	{
		session_regenerate_id( true );
	}
	
	/**
	* Cierra y destruye la sesión
	* 
	* @access	public
	*/
	public function cerrar()
	{
		session_unset();
		session_destroy();
		setcookie( session_name(), '', 1 );
		session_regenerate_id ( true );
	}
}