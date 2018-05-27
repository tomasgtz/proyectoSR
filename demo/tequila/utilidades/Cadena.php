<?php
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Esta clase contiene funciones de encriptaci�n y escapado de cadenas
*
* Est� dada de alta en Autload como clase simple
*
* @package	tequila.utilidades
* @author	isaac
* @version	1
*/
class Cadena{
	/**
	* Valor a�adido para aumentar un poco la seguridad de cadenas encriptadas
	*
	* @constant
	* @var		string
	*/
	const SALT = 'qh83m9j8rpevzny68cmhvo3c04wvfc55w7a1el2v';
	
	/**
	* Valor llave para generar la encriptaci�n con mycrypt
	*
	* @constant
	* @var		string
	*/
	const KEY = 'zDAyTrLwiK';
	
	/**
	* Realiza una encriptaci�n sin retorno
	*
	* Se a�ade la salt interna de la clase, m�s una dada por el usuario
	*
	* @static
	* @param	string		$salt		Salt alterna para encriptaci�n
	* @param	string		$value		El valor a encriptar
	* @access	public
	* @return	string
	*/
	public static function encriptacionAbsoluta( $salt, $value )
	{
		return sha1( self::SALT . $value . $salt );
	}
	
	/**
	* Devuelve un valor �nico y aleatorio
	*
	* @static
	* @access	public
	* @return	string
	*/
	public static function unico()
	{
		return uniqId( rand(), true );
	}
	
	/**
	* Se realiza una encriptaci�n reversible de un valor
	*
	* @static
	* @param	string		$value		El valor a encriptar
	* @access	public
	* @return	string
	*/
	public static function encriptar( $value )
	{
		$ivSize = mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB ); 
		$iv = mcrypt_create_iv( $ivSize, MCRYPT_RAND ); 
		return mcrypt_encrypt( MCRYPT_RIJNDAEL_256, self::KEY, $value, MCRYPT_MODE_ECB, $iv );
	}
	
	/**
	* Desencripta un valor obtenido con la funci�n anterior
	*
	* @static
	* @param	string		$value		El dato encriptado
	* @access	public
	* @return	string
	*/
	public static function desencriptar( $value )
	{
		$ivSize = mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB ); 
		$iv = mcrypt_create_iv( $ivSize, MCRYPT_RAND ); 
		return mcrypt_decrypt( MCRYPT_RIJNDAEL_256, self::KEY, $value, MCRYPT_MODE_ECB, $iv ); 
	}

	/**
	* Limpia un string de valores no validos en url
	*
	* Los valores no v�lidos los reemplaza con caracteres aceptados en SEO
	*
	* @static
	* @param	string		$value		El valor a limpiar de caracteres no v�lidos
	* @access	public
	* @return	string
	*/
	public static function aUrl( $value )
	{
		$cambios = array(
			'�' => 'a',
			'�' => 'e',
			'�' => 'i',
			'�' => 'o',
			'�' => 'u',
			'�' => 'u',
			' ' => '-',
			'�' => 'A',
			'�' => '�',
			'�' => 'I',
			'�' => 'O',
			'�' => 'U'
		);
		$eliminaciones = array(	'!', '(', ')', '?', ',', '.', ';', '/', ':', '�', '�', '=', '�', "'", '"' );
		$eliminado = str_replace( $eliminaciones, '', utf8_decode( trim( $value ) ) );
		return strtolower( str_replace( array_keys( $cambios ), $cambios, $eliminado ) );
	}
}