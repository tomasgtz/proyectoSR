<?php
namespace tequila\libreria\membresia;
use tequila\contexto\Contexto;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Contexto para la tabla de perfiles
*
* @package	libreria.membresia
* @author	isaac
* @version	1
*/
class perfiles extends Contexto{
	/**
	* Arreglo de propiedades del contexto
	*
	* @access	protected
	* @var		array
	*/
	public $propiedades = array(
		'nombre'	=>	array(
			'CLASE'			=> 'ESCRITO',
			'MAX_LONGITUD'	=> 50,
			'ALIAS'			=> 'El nombre del perfil'
		)
	);	
	
	/**
	* Se crea una nueva instancia del modelo relacionado
	*
	* @access	public
	* @return	permiso
	*/
	public function instancia()
	{
		return new perfil( $this );
	}
}