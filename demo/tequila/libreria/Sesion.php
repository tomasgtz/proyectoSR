<?php
namespace tequila\libreria;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Maneja la interacci�n con la superglobal $_SESSION
*
* @package	tequila.librer�a
* @author	isaac
* @version	1
*/
class Sesion{
	/**
	* Indica el "namespace" que usar� la sesi�n en el proyecto
	*
	* Este namespace es en especial �til cuando se tienen multiples proyectos en el mismo dominio
	*
	* @static
	* @access	public
	* @var		string
	*/
	protected $proyecto = 'COLONIAS';

	/**
	* Tiempo de vida que tendr� la sesi�n
	*
	* @access	public
	* @var		int
	*/
	public $LIFETIME = 0;
	
	/**
	* Ruta en el dominio donde la cookie de sesi�n trabajar�
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
	* Bandera sobre s� se trabajar� en una conexi�n segura (HTTPS)
	*
	* @access	public
	* @var		int
	*/
	public $SECURE = false;
	
	/**
	* Bandera sobre si el id sesi�n es solo por cookie
	*
	* @access	public
	* @var		int
	*/
	public $HTTPONLY = true;
	
	/**
	* Constructor
	*
	* Inicia la sesi�n y establece parametros por default de la misma
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
	* Ejecuta la funci�n "session_write_close"
	*
	* @access	public
	*/
	public function __destruct()
	{
		session_write_close();
	}
	
	/**
	* Guarda una nueva llave y su valor en la sesi�n
	*
	* @param	string		$indice		Indice de identificaci�n del dato
	* @param	mixed		$value		El valor a guardar
	* @access	public
	*/
	public function set( $indice, $value )
	{
		$_SESSION[$this->proyecto][$indice] = $value;
	}
	
	/**
	* Devuelve un valor de la sesi�n
	*
	* @param	string		$indice		El indice del valor guardado en sesi�n
	* @access	public
	* @return	mixed
	*/
	public function get( $indice )
	{
		return $_SESSION[$this->proyecto][$indice];
	}
	
	/**
	* Borra un dato de la sesi�n
	*
	* @param	string		$indice		El indice del dato a borrar
	* @access	public
	*/
	public function borrar( $indice )
	{
		unset( $_SESSION[$this->proyecto][$indice] );
	}
	
	/**
	* Indica si existe el indice buscado en la sesi�n
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
	* Devuelve el mensaje guardado en sesi�n y lo borrar
	*
	* @param	string		$indice		El indice del valor guardado en sesi�n
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
	* Regenera el id de la sesi�n
	*
	* @access	public
	*/
	public function regenerar()
	{
		session_regenerate_id( true );
	}
	
	/**
	* Cierra y destruye la sesi�n
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