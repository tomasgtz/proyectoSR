<?php
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Archivo de configuración de rutas
*
* Debe tener una configuración default obligatoria,
* los atajos son opcionales
*
* @package	tequila
* @author	isaac
* @version	1
*/
return array(
	/**
	* este el arreglo de las rutas por defecto
	*
	* @var	array
	*/
	'__defaults' => array(
		'inicio',
		'index'
	),

	/**
	* ruta para la carpeta de administración
	*
	* @var	array
	*/
	'administracion' => array(
		'administracion',
		'inicio',
		'index'
	),

	/**
	* ruta para la carpeta del panel de usuario
	*
	* @var	array
	*/
	'panel' => array(
		'panel',
		'inicio',
		'index'
	)
);