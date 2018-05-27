<?php
namespace tequila\libreria\autenticaciones;
use tequila\inicio\Boot, \Sess;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Realiza la autenticación de un usuario
*
* @package	tequila.libreria
* @author	isaac
* @version	1.1
*/
class Autenticacion{
	/**
	* Bandera que indica si un usuario esta loggeado o no
	*
	* @access	public
	* @var		bool
	*/
	public $loggeado = false;
	
	/**
	* Tiempo de inactividad para suspender una sesión
	*
	* @access	protected
	* @var		int
	*/
	protected $inactividad;

	/**
	* Sesión que se utilizará para la autenticación
	*
	* Para distintos tipos de loggeos (P.ej. administradores y clientes) se pueden sesiones con diferentes proyectos
	*
	* @access	protected
	* @var		Sesion
	*/
	public $sesion;
	
	/**
	* Constructor
	*
	* Revisa si se tiene una sesión iniciada
	*
	* @param	Sesion		$sesion			Sesión alternativa que se puede usar para la autenticación
	* @param	int			$inactividad	Tiempo de vida de la sesión sin actividad en segundos, default: 10800 (3 horas)
	* @access	public
	*/
	public function __construct( $sesion = null, $inactividad = 10800 )
	{
		if ( isset( $sesion ) )
		{
			$this->sesion = $sesion;
		}
		else
		{
			$this->sesion = Sess::instanciaDefault();
		}
		$this->inactividad = $inactividad;
		if ( $this->sesion->existe( '__loggeado' ) )
		{
			$this->loggeado = true;
			if ( !$this->revisarTimeout() || !$this->revisarAgent() )
			{
				$this->eliminar();
			}
		}
	}
	
	/**
	* Inicia una sesión de usuario
	*
	* @param	int		$id			El id del usuario iniciando sesión
	* @param	string	$nombre		El nombre del usuario iniciando sesión
	* @access	public
	*/
	public function iniciar( $id, $nombre )
	{
		$this->sesion->set( '__loggeado', true );
		$this->sesion->set( '__actual', time() );
		$this->sesion->set( '__agent', Boot::$peticion->server( 'HTTP_USER_AGENT' ) );
		$this->sesion->set( '__id', $id );
		$this->sesion->set( '__nombre', $nombre );
		$this->sesion->regenerar();
		$this->loggeado = true;
	}

	/**
	* Cierra una sesión borrando solo los datos de loggeo
	*
	* @access	public
	*/
	public function cerrar()
	{
		$this->sesion->borrar( '__loggeado' );
		$this->sesion->borrar( '__actual' );
		$this->sesion->borrar( '__agent' );
		$this->sesion->borrar( '__id' );
		$this->sesion->borrar( '__nombre' );
		$this->sesion->regenerar();
		$this->loggeado = false;
	}
	
	/**
	* Cierra la sesión de usuario actual
	*
	* @access	public
	*/
	public function eliminar()
	{
		$this->sesion->cerrar();
		$this->loggeado = false;
	}
	
	/**
	* Revisa si no se ha expirado el tiempo activo de sesión
	*
	* @access	protected
	* @return	bool
	*/
	protected function revisarTimeout()
	{
		if ( $this->sesion->get( '__actual' ) + $this->inactividad < time() )
		{
			return false;
		}
		else
		{
			$this->sesion->set( '__actual', time() );
		}
		return true;
	}

	/**
	* Revisa que el user agent sea el mismo en peticiones consecutivas de una sesión
	*
	* @access	protected
	* @return	bool
	*/
	protected function revisarAgent()
	{
		if ( $this->sesion->get( '__agent' ) != Boot::$peticion->server( 'HTTP_USER_AGENT' ) )
		{
			return false;
		}
		return true;
	}
}