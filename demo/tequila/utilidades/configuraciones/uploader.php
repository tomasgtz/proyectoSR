<?php
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Archivo de configuración del uploader
*
* Este archivo contiene mensajes de error para determinadas fallas que se puedan encontrar
*
* @package	tequila.utilidades
* @author	isaac
* @version	1
*/
return array(
	/**
	* Error de tamaño de archivo en php.ini
	*
	* @var		string
	*/
	UPLOAD_ERR_INI_SIZE		=>	'%s: El archivo excedió el tamaño máximo permitido en el servidor',
	
	/**
	* Error de tamaño de archivo en el formulario
	*
	* @var		string
	*/
	UPLOAD_ERR_FORM_SIZE	=>	'%s: El archivo excedió el tamaño máximo permitido',
	
	/**
	* Error de archivo solo parcialmente subido
	*
	* @var
	*/
	UPLOAD_ERR_PARTIAL		=>	'%s: El archivo no se subió correctamente',
	
	/**
	* Ningún archivo para subir
	*
	* @var		string
	*/
	UPLOAD_ERR_NO_FILE		=>	'No se seleccionó un archivo para subir',
	
	/**
	* Directorio temporal no encontrado
	*
	* @var		string
	*/
	UPLOAD_ERR_NO_TMP_DIR	=>	'%s: Error en el servidor, intente subir el archivo de nuevo',
	
	/**
	* no fue posible escribir en disco
	*
	* @var		string
	*/
	UPLOAD_ERR_CANT_WRITE	=>	'%s: Error interno, intente subir el archivo de nuevo',
	
	/**
	* Error de extensiones
	*
	* @var		string
	*/
	UPLOAD_ERR_EXTENSION	=>	'%s: Error interno, intente subir el archivo de nuevo',
	
	/**
	* Error en los mime types permitidos
	*
	* @var		string
	*/
	'mimes'					=>	'%s: No es un tipo de archivo permitido',
	
	/**
	* Error de guardado
	*
	* @var		string
	*/
	'guardado'				=>	'%s: Error interno, intente subir el archivo de nuevo',

	/**
	* Error de archivo nulo o demasiado grande
	*
	*  @var		string
	*/
	'vacio'					=>	'Un archivo es demasiado grande o no ha sido seleccionado ninguno',

	/**
	* Error de archivo existente, cuando aplica
	*
	* @var		string
	*/
	'existente'				=>	'Uno o más archivos ya existen'
);