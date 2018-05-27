<?php
namespace tequila\libreria\membresia;
use tequila\contexto\Cxmodelo;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Objeto que representa un permiso
*
* @package	libreria.membresia
* @author	isaac
* @version	1
*/
class perfil extends Cxmodelo{
	/**
	* Asigna los permisos que tendrá un perfil en la base de datos
	*
	* @param	array	$lista		La lista de permisos que serán asignados
	* @access	public
	*/
	public function asignarPermisos( array $lista )
	{
		$this->getContexto()
			->actualizarRelacion( $this, new permisos, $lista, 'perfiles_permisos', 'idPerfil', 'idPermiso' );
	}
}