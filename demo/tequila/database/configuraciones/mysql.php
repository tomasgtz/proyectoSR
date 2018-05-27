<?php
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Archivo de la configuración de la clase Mysql
*
* en esta configuración se encuentran las opciones de conexión
* y configuraciones extras de una base de datos
*
* @package	tequila.bd
* @author	isaac
* @version	1
*/
return array(
	/**
	* El nombre o dirección del servidor de base de datos
	*
	* @var	string
	*/
	'SERVIDOR' => 'localhost',
	
	/**
	* El nombre de usuario con acceso a la base de datos
	*
	* @var	string
	*/
	'USUARIO' => 'innsert',


	/**
	* La contraseña del usuario
	*
	* @var	string
	*/
	'PASSWORD' => 'tr3snnI!!',

	/**
	* El nombre de la base de datos en la que se trabajará (encuestas : KindorseDB)
	*
	* @var	string
	*/
	'DATABASE' => 'DBcolonias',
	
	/**
	* El charset por defecto con el que se trabajá
	*
	* @var	string
	*/
	'CHARSET' => 'utf8'
);