<?php
namespace tequila\database;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Interfaz que deben tener las clases de bases de datos que se conecten a los Contextos
*
* @package	tequila.database
* @author	isaac
* @version	1
*/
interface InterfazDatabase{
	/**
	* Ejecuta una sentencia sql sin preparar
	*
	* Cuando no se requiren parametros preparardos utilizar esta función
	*
	* @param	string	$sql	La sentencia sql a ejecutar
	* @access	public
	* @throws	DatabaseException
	*/
	public function simple( $sql );
	
	/**
	* Ejecuta una sentencia sql con parametros
	*
	* Se deben pasar los parametros preparados en unobjeto Parametrizador
	*
	* @param	string			$sql		La sentencia sql a ejecutar
	* @param	Parametrizador	$params		Los parametros de la sentencia
	* @access	public
	* @throws	DatabaseException
	*/
	public function conParametros( $sql, Parametrizador $params );
	
	/**
	* Ejecuta una sentencia sql
	*
	* Esta función puede eje cutar una sentencia preparada o una simple,
	* dependiendo del parametro $params (null = simple, not null = preparada)
	*
	* @param	string			$sql		Sentencia sql a ejecutar
	* @param	Parametrizador	$params		Conjunto de parametros de una sentencia preparada
	* @access	public
	* @throws	DatabaseException
	*/
	public function ejecutar( $sql, Parametrizador $params = null );
	
	/**
	* Devuelve los resultados de una busqueda
	*
	* Esta función se debe llamar despues de haber realizado la ejecución de una sentencia
	*
	* @access	public
	* @return	array
	*/
	public function resultados();
	
	/**
	* Inicia una transacción
	*
	* @access	public
	*/
	public function iniciarTransaccion();
	
	/**
	* Realiza la confirmación de una transacción
	*
	* @access	public
	*/
	public function commit();
	
	/**
	* Realiza la cancelación de una transacción
	*
	* @access	public
	*/
	public function rollback();
	
	/**
	* Escapa el valor dado
	*
	* Esto sirve para evitar la inyección de sql,
	* siempre se debe escapar un dato ingresado por los usuarios,
	* como alternativa se pueden utilizar consultas preparadas
	*
	* @param	mixed		el valor a escapar
	* @access	public
	* @return	mixed
	*/
	public function escapar( $value );
	
	/**
	* Devuelve el ultimo id insertado
	*
	* @access	public
	* @return	int
	*/
	public function ultimoId();
}