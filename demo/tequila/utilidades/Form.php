<?php
use tequila\utilidades\BaseHtml;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Ayuda para la creación de formularios
*
* Son un conjunto de métodos estáticos que generan html
* esta clase esta dada de alta en Autoload como clase simple
*
* @package	tequila.utilidades
* @author	isaac
* @version	1
*/
class Form extends BaseHtml{	
	/**
	* Genera la tag inicial del formulario
	*
	* @param	string		$accion		Acción de la petición
	* @param	array		$attrs		Los atributos de la tag
	* @param	string		$metodo		Método de la petición
	* @access	public
	* @return	string
	*/
	public static function abrir( $accion, array $attrs = array(), $metodo = 'POST' )
	{
		$attrs['action'] = $accion;
		$attrs['method'] = $metodo;
		return '<form ' . self::atributos( $attrs ) . ' >';
	}
	
	/**
	* Cierra un formulario
	*
	* @access	public
	* @return	string
	*/
	public static function cerrar()
	{
		return '</form>';
	}
	
	/**
	* Abre un formulario que acepta archivos de subida
	*
	* @param	string		$accion		Acción de la petición
	* @param	array		$attrs		Los atributos de la tag
	* @param	int			$max		Tamaño máximo permitido del archivo
	* @access	public
	* @return	string
	*/
	public static function abrir_upload( $accion, array $attrs = array(), $max = 20000000 )
	{
		$attrs['enctype'] = 'multipart/form-data';
		return self::abrir( $accion, $attrs ) . self::hidden( 'MAX_FILE_SIZE',  $max );
	}
	
	/**
	* Genera un input de formulario
	*
	* @param	string		$nombre		Nombre del input
	* @param	string		$type		El tipo del input
	* @param	mixed		$value		El valor que puede tener
	* @param	array		$attrs		Atributos que tendrá la tag
	* @access	public
	* @return	string
	*/
	public static function input( $type, $nombre, $value = null, array $attrs = array() )
	{
		$attrs['name'] = $nombre;
		$attrs['type'] = $type;
		$attrs['id'] = isset( $attrs['id'] ) ? $attrs['id'] : $nombre;
		if ( isset($value) )
		{
			$attrs['value'] = $value;
		}
		return '<input ' . self::atributos( $attrs ) . '/>';
	}
	
	/**
	* Genera un campo de tipo texto
	*
	* @param	string		$nombre		El nombre del campo
	* @param	string		$value		El valor que puede tener
	* @param	array		$attrs		Los atributos que tendrá la tag
	* @access	public
	* @return	string
	*/
	public static function text( $nombre, $value = null, array $attrs = array() )
	{
		return self::input( 'text', $nombre, $value, $attrs );
	}
	
	/**
	* Genera un campo de tipo oculto
	*
	* @param	string		$nombre		El nombre del campo
	* @param	string		$value		El valor que puede tener
	* @param	array		$attrs		Los atributos que tendrá la tag
	* @access	public
	* @return	string
	*/
	public static function hidden( $nombre, $value = null, array $attrs = array() )
	{
		return self::input( 'hidden', $nombre, $value, $attrs, false );
	}
	
	/**
	* Genera un campo de tipo password
	*
	* @param	string		$nombre		El nombre del campo
	* @param	string		$value		El valor que puede tener
	* @param	array		$attrs		Los atributos que tendrá la tag
	* @access	public
	* @return	string
	*/
	public static function password( $nombre, $value = null, array $attrs = array() )
	{
		return self::input( 'password', $nombre, $value, $attrs );
	}
	
	/**
	* Genera un botón para subir archivos
	*
	* @param	string		$nombre		El nombre del campo
	* @param	array		$attrs		Los atributos que tendrá la tag
	* @access	public
	* @return	string
	*/
	public static function file( $nombre, array $attrs = array() )
	{
		return self::input( 'file', $nombre, null, $attrs );
	}
	
	/**
	* Genera un botón para entregar formulario
	*
	* @param	string		$nombre		El nombre del campo
	* @param	string		$value		El valor que puede tener
	* @param	array		$attrs		Los atributos que tendrá la tag
	* @access	public
	* @return	string
	*/
	public static function submit( $nombre, $value = null, array $attrs = array() )
	{
		return self::input( 'submit', $nombre, $value, $attrs );
	}
	
	/**
	* Genera una textarea
	*
	* @param	string		$nombre		El nombre del campo
	* @param	string		$value		El valor que puede tener
	* @param	array		$attrs		Los atributos que tendrá la tag
	* @access	public
	* @return	string
	*/
	public static function textarea( $nombre, $value = '', array $attrs = array() )
	{
		$attrs['name'] = $nombre;
		$attrs['id'] = isset( $attrs['id'] ) ? $attrs['id'] : $nombre;
		return '<textarea ' . self::atributos( $attrs ) . '>' . $value . '</textarea>';
	}
	
	/**
	* Genera un select
	*
	* El campo a mostrarse debe llamarse "etiqueta" y el valor final debe llamarse "valor"
	*
	* @param	string		$nombre		El nombre del campo
	* @param	array		$datos		Los datos que llenarán el select
	* @param	mixed		$default	Si existe un valor por default seleccionado
	* @param	mixed		$primera	Si se debe escribir una opción por fault con valor vacío
	* @param	array		$attrs		Los atributos que tendrá la tag
	* @access	public
	* @return	string
	*/
	public static function select( $nombre, array $datos, $etiqueta, $default = null, $primera = null, array $attrs = array() )
	{
		if ( !isset( $default )  )
		{
			$default = array();
		}
		elseif ( !is_array( $default ) )
		{
			$default = array( $default );
		}
		$attrs['name'] = $nombre;
		$attrs['id'] = isset( $attrs['id'] ) ? $attrs['id'] : $nombre;
		$html = '<select ' . self::atributos( $attrs ) . '>';
		if ( isset( $primera ) )
		{			
			if ( !is_array( $primera ) )
			{
				$primera = array( $primera, true );
			}
			$disabled = ( isset( $primera[ 1 ] ) && $primera[ 1 ] ) ? ' disabled ' : '';
			$html .= "<option value='' {$disabled} selected class='select-default'>{$primera[ 0 ]}</option>";
		}
		foreach ( $datos as $dato )
		{
			$html .= '<option ';
			if ( in_array( $dato->id, $default ) )
			{
				$html .= 'selected = "selected" ';
			}		
			$html .= 'value="' . $dato->id . '">' . $dato->$etiqueta . '</option>';
		}
		return $html . '</select>';
	}

	/**
	* Genera un select con las opciones enviadas mediante un arreglo
	*
	* El arreglo debe ser asociativo, indice = value, valor = html
	*
	* @static
	* @param	string		$nombre		El nombre del campo
	* @param	array		$datos		Los datos que llenarán el select
	* @param	mixed		$default	Si existe un valor por default seleccionado
	* @param	mixed		$primera	Si se debe escribir una opción por fault con valor vacío
	* @param	array		$attrs		Los atributos que tendrá la tag
	* @access	public
	* @return	string
	*/
	public static function arraySelect( $nombre, array $datos, $default = null, $primera = null, array $attrs = array() )
	{
		$attrs['name'] = $nombre;
		$attrs['id'] = isset( $attrs['id'] ) ? $attrs['id'] : $nombre;
		$html = '<select ' . self::atributos( $attrs ) . '>';
		if ( isset( $primera ) )
		{
			if ( !is_array( $primera ) )
			{
				$primera = array( $primera, true );
			}
			$disabled = ( isset( $primera[ 1 ] ) && $primera[ 1 ] ) ? ' disabled ' : '';
			$html .= "<option value='' {$disabled} selected class='select-default'>{$primera[ 0 ]}</option>";
		}
		foreach ( $datos as $valor => $dato )
		{
			$html .= '<option ';
			if ( isset( $default ) && $default == $valor )
			{
				$html .= 'selected = "selected" ';
			}
			$html .= 'value="' . $valor . '"">' . $dato . '</option>';
		}
		return $html . '</select>';
	}
	
	/**
	* Genera un checkbox
	*
	* @static
	* @param	string		$nombre		El nombre del checkbox
	* @param	mixed		$value		El valor que tendrá el checkbox
	* @param	bool		$checado	Bandera que indica si debe estar marcado por defecto
	* @param	array		$attrs		Los atributos que tendrá la tag
	* @access	public
	* @return	string
	*/
	public static function checkbox( $nombre, $value, $checado = false, array $attrs = array() )
	{
		if ( $checado )
		{
			$attrs['checked'] = 'true';
		}
		return self::input( 'checkbox', $nombre, $value, $attrs ); 
	}

	/**
	* Genera un radio button
	*
	* @static
	* @param	string		$nombre		El nombre del grupo de radio buttons
	* @param	mixed		$value		El valor que tendrá el checkbox
	* @param	bool		$checado	Bandera que indica si debe estar marcado por defecto
	* @param	array		$attrs		Los atributos que tendrá la tag
	* @access	public
	* @return	string
	*/
	public static function radio( $nombre, $value, $checado = false, array $attrs = array() )
	{
		if ( $checado )
		{
			$attrs['checked'] = 'true';
		}
		return self::input( 'radio', $nombre, $value, $attrs ); 
	}
	
	/**
	* Genera un token para evitar peticiones fuera de dominio
	*
	* El token es guardado en sesión y en un campo oculto del formulario
	* llamado "__token"
	*
	* @access	public
	* @return	string
	*/
	public static function token()
	{
		$token = Cadena::unico();
		Sess::instanciaDefault()->set( '__token', $token );
		return self::hidden( '__token', $token );
	}
	
	/**
	* Genera una etiqueta
	*
	* @param	string		$para		El nombre del id del campo al que está ligada la etiqueta
	* @param	string		$texto		Texto de la etiqueta
	* @param	array		$attrs		Los atributos que tendrá la tag
	* @access	public
	* @return	string
	*/
	public static function label( $para, $texto = '', array $attrs = array() )
	{
		$attrs['for'] = $para;
		return '<label ' . self::atributos( $attrs ) . '>' . $texto . '</label>';
	}
}