<?php
namespace tequila\libreria\membresia;
use tequila\contexto\Contexto;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Contexto para la tabla de permisos
*
* @package	libreria.membresia
* @author	isaac
* @version	1
*/
class permisos extends Contexto{
	/**
	* Arreglo de propiedades del contexto
	*
	* @access	protected
	* @var		array
	*/
	public $propiedades = array(
		'nombre'	=>	'ALFANUMERICO'
	);	
	
	/**
	* Se crea una nueva instancia del modelo relacionado
	*
	* @access	public
	* @return	permiso
	*/
	public function instancia()
	{
		return new permiso( $this );
	}
}