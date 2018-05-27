<?php
namespace tequila\libreria\autenticaciones;
use tequila\contexto\Contexto, tequila\database\Parametrizador, \Cadena;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Autenticación que utiliza un contexto como base para los datos
*
* @package	tequila.libreria.autenticaciones
* @author	isaac
* @version	1
*/
class ContextoAut extends Autenticacion{
	/**
	* Objeto Contexto que se utilizará en la autenticación
	*
	* @access	public
	* @var		Contexto
	*/
	public $contexto;
	
	/**
	* Constructor
	*
	* Establece el Contexto a utilizar
	*
	* @param	Contexto	$contexto		El contexto de usuario que se usará para la autenticación
	* @param	Sesion		$sesion			Sesión alternativa que se puede usar para la autenticación
	* @param	int			$inactividad	Tiempo de vida de la sesión sin actividad en segundos, default: 1500
	* @access	public
	*/
	public function __construct( Contexto $contexto, $sesion = null, $inactividad = 1500 )
	{
		$this->contexto = $contexto;
		parent::__construct( $sesion, $inactividad );
	}
	
	/**
	* Autentifica las credenciales de un usuario
	*
	* Debe establecer en la sesión actual el id del usuariuo en sesión y el nombre
	*
	* @param	string		$usuario		El nombre del usuario
	* @param	string		$password		La contraseña del usuario
	* @access	public
	* @return	usuario
	*/
	public function autenticar( $usuario, $password )
	{
		$this->contexto->obtener( '*' )->where( 'correo', '=', '?' )->where( 'idEstatus', '=', 1 )->limit( '1' );
		$params = new Parametrizador();
		$params->add( 'ALFANUMERICO', $usuario );
		$aut = $this->contexto->buscar( $params )->unico();
		if ( !$aut )
		{
			return null;
		}
		if ( $aut->intento > time() - 15 )
		{
			$aut->intento = time();
			$aut->guardar( false );
			return null;
		}
		$pass = Cadena::encriptacionAbsoluta( $aut->hash, $password  );
		if ( $aut->password != $pass )
		{
			return null;
		}
		$this->iniciar( $aut->id, $aut->nombre );
		return $aut;
	}
}