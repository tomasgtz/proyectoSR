<?php
namespace tequila\utilidades;
use tequila\inicio\Boot, tequila\libreria\respuesta\ErrorPeticion, \Sess;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Está clase contiene funciones sobre seguridad en php
*
* Se utiliza de manera estática
*
* @package	tequila.utilidades
* @author	isaac
* @version	1
*/
class Seguridad{
	/**
	* Validación antiForgery de formulario dentro del sitio
	*
	* @static
	* @param	Peticion	$peticion		El objeto de la petición actual
	* @access	public
	*/
	public static function antiForgery()
	{
		$sesion = Sess::instanciaDefault();
		if ( !$sesion->existe( '__token' ) || $sesion->getFlash( '__token' ) != Boot::$peticion->post( '__token' ) )
		{
			$sesion->cerrar();
			$error = new ErrorPeticion( 'Proteccción contra peticiones externas' );
			$error->enviar();
		}
	}
}