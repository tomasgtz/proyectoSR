<?php
namespace tequila\libreria\membresia;
use tequila\contexto\Cxmodelo, \Sess;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Objeto que representa un usuario
*
* @package	libreria.membresia
* @author	isaac
* @version	1
*/
class usuario extends Cxmodelo{
	/**
	* Devuelve un arreglo con los permisos que tiene el usuario
	*
	* @access	public
	* @return	array
	*/
	public function establecerPermisos()
	{
		$permisos = new permisos;
		$resultado = $permisos->obtener( '*' )->join( 'perfiles_permisos', 'idPermiso', 'id' )
			->where( 'perfiles_permisos.idPerfil', '=', $this->idPerfil )->buscar()->originales();
		$lista = array();
		foreach ( $resultado as $permiso )
		{
			$lista[] = $permiso[ 'nombre' ];
		}
		Sess::instanciaDefault()->set( '__permisos', $lista );
	}
}