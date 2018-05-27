<?php
namespace tequila\libreria\membresia;
use tequila\libreria\autenticaciones\Autenticacion, tequila\mvc\Modelo, tequila\libreria\respuesta\RespuestaJson;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Esta clase maneja los permisos del usuario en sesión
*
* En caso de que un usuario sin autenticación o sin permisos llegue a un lugar inadecuado
* se pueden establecer las medidas necesarias
* El proyecto incluye clases complementarias para el funcionamiento de esta clase sin demasiado desarrollo extra
*
* @package	tequila.libreria
* @author	isaac
* @version	1
*/
abstract class BaseMembresia{
	/**
	* Objeto con las propiedades base del usuario en sesión (nombre, id)
	*
	* @access	public
	* @var		string
	*/
	public $usuario;

	/**
	* Objeto de autenticación de usuario
	*
	* @access	public
	* @var		Autenticacion
	*/
	public $autenticacion;

	/**
	* Arreglo que tiene los valores devueltos en un json de error de autenticación
	*
	* @access	protected
	* @var		array
	*/
	protected $jsonError = array( 'estatus' => 'rechazado', 'mensaje' => 'Sin licencia' );

	/**
	* Constructor
	*
	* Carga el usuario actualmente en sesión
	* Establece los valores iniciales de las propiedades
	*
	* @param	Autenticacion	$autenticacion		El tipo de autenticación que se utiliza con esta membresía
	* @access	public
	*/
	public function __construct( Autenticacion $autenticacion = null )
	{
		if ( isset( $autenticacion ) )
		{
			$this->autenticacion = $autenticacion;
		}
		else
		{
			$this->autenticacion = new Autenticacion;
		}
		if ( $this->autenticacion->loggeado )
		{
			$this->usuario = new Modelo;
			$this->usuario->id = $this->autenticacion->sesion->get( '__id' );
			$this->usuario->nombre = $this->autenticacion->sesion->get( '__nombre' );
		}
	}

	/**
	* Revisa si un usuario está autenticado
	*
	* En caso de no estar autenticado se ejecutan las medidas establecidas en la clase base
	* Si solo se necesita que el usuario tenga loggin los permisos se deben dejar vacíos
	*
	* @param	mixed	$permisos		Colección de permisos que debe tener el usuario
	* @access	public
	*/
	public function autenticado( $permisos = null )
	{
		if ( !$this->revisar( $permisos ) )
		{
			$this->sinLicencia();
		}
	}


	/**
	* Revisa si un usuario está autenticado, en caso fallido se devuelve un json de error
	*
	* En caso de no estar autenticado se ejecutan las medidas establecidas en la clase base
	* Si solo se necesita que el usuario tenga loggin los permisos se deben dejar vacíos
	*
	* @param	mixed	$permisos		Colección de permisos que debe tener el usuario
	* @access	public
	*/
	public function autenticadoJson( $permisos = null )
	{
		if ( !$this->revisar( $permisos ) )
		{
			$respuesta = new RespuestaJson( $this->jsonError );
			$respuesta->enviar();
		}
	}

	/**
	* Realiza la comparación de los permisos de un usuario
	*
	* El resultado es el booleano de su comparación
	*
	* @param	mixed	$permisos		Colección de permisos que debe tener el usuario
	* @access	public
	*/
	public  function revisar( $permisos = null )
	{
		if ( !$this->autenticacion->loggeado )
		{
			return false;
		}
		if ( !isset( $permisos ) )
		{
			return true;
		}
		if ( !is_array( $permisos ) )
		{
			$permisos = array( $permisos );
		}
		$requerimiento = $this->autenticacion->sesion->get( '__permisos' );
		foreach ( $permisos as $permiso )
		{
			if ( in_array( $permiso, $requerimiento ) )
			{
				return true;
			}
		}
		return false;
	}

	/**
	* Método abstracto
	*
	* Contiene la acción a realizar cuando se encuentra a un usuario sin licencia
	*
	* @access	protected
	*/
	abstract protected function sinLicencia();
}