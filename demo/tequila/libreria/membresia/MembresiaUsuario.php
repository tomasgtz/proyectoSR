<?php
namespace tequila\libreria\membresia;
use \Redirect, \Url;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Extiende la Membres�a base, cuando sucede un error en la autenticaci�n, se redirecciona a la p�gina de login
*
* Esta clase de membres�a utiliza contextos para realizar validaciones
*
* @package	tequila.libreria.membresia
* @author	isaac
* @version	1
*/
class MembresiaUsuario extends BaseMembresia{
	/**
	* Realiza alguna medida correctiva en caso de que un usuario llegue a un lugar no autorizado
	*
	* @access	public
	*/
	public function sinLicencia()
	{
		return new Redirect( Url::hacer( 'inicio/salir' ) );
	}

	/**
	* Devuelve al usuario en sesi�n como Cxmodelo
	*
	* @return	usuario
	*/
	public function usuarioLoggeado()
	{
		$usuarios = new usuarios;
		return $usuarios->buscarId( $this->usuario->id );
	}
}