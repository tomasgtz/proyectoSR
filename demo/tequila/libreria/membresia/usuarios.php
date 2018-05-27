<?php
namespace tequila\libreria\membresia;
use tequila\contexto\Contexto;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Contexto para la tabla de usuarios
*
* @package	libreria.membresia
* @author	isaac
* @version	1
*/
class usuarios extends Contexto{
	/**
	* Propiedades de la tabla
	*
	* @access	public
	* @var		array
	*/
	public $propiedades = array(
		'nombre'			=>	array(
			'CLASE'				=>	'ESCRITO',
			'MAX_LONGUITUD' 	=>  150,
			'MIN_LONGUITUD'		=> 	2,
			'ALIAS'				=>	'El nombre de usuario'
		),
		'correo'			=>	array(
			'CLASE'				=>	'EMAIL',
			'MAX_LONGUITUD' 	=>  150,
			'MIN_LONGUITUD'		=> 	5,
			'ALIAS'				=>	'El correo'
		),
		'idPerfil'			=>	array(
			'CLASE'				=>	'ENTERO',
			'RELACION'			=>	array(
				'TABLA'				=>	'perfiles',
				'LLAVE'				=>	'id'
			),
			'ALIAS'				=>	'El perfil'
		),
		'idColonia'			=>	array(
			'CLASE'				=>	'ENTERO',
			'RELACION'			=>	array(
				'TABLA'				=>	'colonias',
				'LLAVE'				=>	'id'
			),
			'ALIAS'				=>	'La Colonia'
		),
		'password'			=>	array(
			'CLASE'				=>	'ESCRITO',
			'MAX_LONGUITUD' 	=>  40,
			'MIN_LONGUITUD'		=> 	2,
			'ALIAS'				=>	'El password'
		),
		'hash'				=>	array(
			'CLASE'				=>	'ESCRITO',
			'MAX_LONGUITUD' 	=>  50,
			'MIN_LONGUITUD'		=> 	2,
			'ALIAS'				=>	'El hash'
		),
		'intento' 			=>	'TIMESTAMP',
		'idEstatus' 			=>	array(
			'CLASE'				=>	'ENTERO',
			'RELACION'			=>	array(
				'TABLA'				=>	'estatus',
				'LLAVE'				=>	'id'
			),
			'ALIAS'				=>	'El estatus del usuario'
		)
	);
	
	/**
	* Función abstracta de la clase, devuelve una instancia del modelo ligado
	*
	* @access	public
	* @return	usuario
	*/
	public function instancia()
	{
		return new usuario( $this );
	}
}