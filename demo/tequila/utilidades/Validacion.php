<?php
namespace tequila\utilidades;
use tequila\sistema\ColeccionErrores, \Leng, \DateTime;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Esta clase realiza una validación de datos
*
* Puede recibir un arreglo o un modelo para validar,
* se debe pasar un arreglo con reglas predefinidas,
* ejemplo de un arreglo de reglas:
* <code>
* array(
*	'titulo' => array(
*		'CLASE'			=>	'ALFANUMERICO',
*		'MAX_LONGITUD'	=>	15,
*		'ALIAS'			=>	'Título de publicación'
*	)
* );
* </code>
* Esta clase se puede extendr y añadir más funciones de validación
*
* @package	tequila.utilidades
* @author	isaac
* @version	1
*/
class Validacion extends ColeccionErrores{
	/**
	* Ruta del archivo de configuraciones de la clase
	*
	* @access	protected
	* @var		array
	*/
	protected $_ruta = array( 'tequila', 'utilidades', 'configuraciones', 'validacion' );
	
	/**
	* Los datos a ser validados
	*
	* Puede ser un modelo o un arreglo
	*
	* @access	protected
	* @var		array
	*/
	protected $datos;
	
	/**
	* Reglas de validación
	*
	* Arreglo con el nombre del dato a validar que tiene una rreglo con las distintas
	* validaciones a aplicar
	*
	* @access	protected
	* @var		array
	*/
	protected $reglas = array();

	/**
	* Reglas de comparación
	*
	* Arreglo con los métodos que tienen comparación entre dos propiedades
	*
	* @access	protected
	* @var		array
	*/
	protected $comparaciones = array( 'MAYOR_A' );

	/**
	* Bandera que tiene la regla sobre si las omisiones se consideran un error
	*
	* @access	public
	* @var		bool
	*/
	public $completo = true;
	
	/**
	* Constructor
	*
	* Establece los datos, las reglas y los mensajes alternos de las validaciones
	*
	* @param	mixed	$datos		Los datos a validar
	* @param	array	$reglas		Las reglas de validación
	* @param	array	$mensajes	Mensajes alternativos de error
	* @access	public
	*/
	public function __construct( $datos, array $reglas, array $mensajes = array() )
	{
		parent::__construct();
		$this->datos = is_object( $datos ) ? get_object_vars( $datos ) : $datos;
		$this->reglas = $reglas;
		if ( !empty( $mensajes ) )
		{
			$this->_config = array_merge( $this->_config, $mensajes );
		}
	}
	
	
	/**
	* Realiza la validación de los datos
	*
	* @access	public
	* @return	bool
	*/
	public function validar()
	{
		foreach ( $this->reglas as $propiedad => $opciones )
		{
			if ( is_array( $opciones ) && !isset( $opciones[ 'OMITIR' ] ) )
			{
				$dato = isset( $this->datos[$propiedad] ) ? $this->datos[$propiedad] : '';
				if ( !isset( $opciones[ 'ALIAS' ] ) )
				{
					$alias = ucfirst( $propiedad );
				}
				else
				{
					$alias = is_array( $opciones[ 'ALIAS' ] )
						? $opciones[ 'ALIAS' ][ Leng::instanciaDefault()->actual ] : $opciones[ 'ALIAS' ];
				}
				if ( trim( $dato ) === '' )
				{
					if ( $this->completo )
					{
						$this->addError( $alias, 'REQUERIDO' );
					}
				}
				else
				{
					if ( array_key_exists( 'CLASE', $opciones ) )
					{
						$opciones[ $opciones[ 'CLASE' ] ] = null;
						unset( $opciones[ 'CLASE' ] );
					}
					foreach ( $opciones as $regla => $opcional )
					{
						if ( method_exists( $this, $regla ) )
						{
							if ( !$this->{$regla}( $dato, $opcional ) )
							{
								if ( in_array( $regla, $this->comparaciones ) )
								{
									$opcional = isset( $this->reglas[ $opcional ][ 'ALIAS' ] )
										? $this->reglas[ $opcional ][ 'ALIAS' ] : ucfirst( $opcional );
								}
								$this->addError( $alias, $regla, $opcional );
							}
						}
					}
				}
			}
		}
		return empty( $this->errores );
	}

	/**
	* Valida que el dato sean solo letras sin acentos o números
	*
	* @param	mixed	$valor		El dato a validar
	* @access	public
	* @return	bool
	*/
	public function PLANO( $valor )
	{
		return preg_match( '#^[a-zA-Z0-9]+$#', $valor );
	}
	
	/**
	* Valida que el dato sea alfanumérico
	*
	* @param	mixed	$valor		El dato a validar
	* @access	public
	* @return	bool
	*/
	public function ALFANUMERICO( $valor )
	{
		return preg_match( '#^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑäëïöüÄËÏÖÜ’ ]+$#', $valor );
	}
	
	/**
	* Valida un dato alfanumérico con ciertos caracterés extras
	*
	* @param	mixed	$valor		El dato a validar
	* @access	public
	* @return	bool
	*/
	public function ESCRITO( $valor )
	{
		return preg_match( '#^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑäëïöüÄËÏÖÜ’\s\[\]?!%\+\-,\.;\$¿¡=\:´_\/\\\@\(\)\#]+$#', $valor );
	}
	
	/**
	* Valida que el dato sea un entero
	*
	* @param	mixed	$valor		El dato a validar
	* @access	public
	* @return	bool
	*/
	public function ENTERO( $valor )
	{
		return ctype_digit( $valor ) || is_int( $valor );
	}
	
	/**
	* Valida que el dato sea numérico
	*
	* @param	mixed	$valor		El dato a validar
	* @access	public
	* @return	bool
	*/
	public function NUMERICO( $valor )
	{
		return is_numeric( $valor );
	}
	
	/**
	* Valida que un dato sea de tipo booleano
	*
	* En realidad no tiene que ser booleano nativo,
	* solo ser interpretado como verdadero o falso
	*
	* @param	mixed		$valor		El dato a validar
	* @access	public
	* @return	bool
	*/
	public function BANDERA( $valor )
	{
		return in_array( $valor, array( true, false, 1, 0, 'yes', 'no', '1', '0' ), true );
	}
	
	/**
	* Valida que un dato sea un timestamp
	*
	* @param	mixed		$valor		El dato a validar
	* @access	public
	* @return	bool
	*/
	public function TIMESTAMP( $valor )
	{
		return $this->entero( $valor ) && (int) $valor >= 0;
	}
	
	/**
	* Valida que un dato sea un decimal
	*
	* Se utiliza la misma función que numérico,
	* hay que tener cuidado porque numerico acepta datos extraños
	*
	* @param	mixed		$valor		El dato a validar
	* @access	public
	* @return	bool
	*/
	public function DECIMAL( $valor )
	{
		return $this->numerico( $valor );
	}
	
	/**
	* Valida que una cadena sea de tipo fecha
	*
	* La cadena debe tener formato para guardarse en base de datos
	*
	* @param	string		$valor		El dato a validar
	* @access	public
	* @return	bool
	*/
	public function FECHA( $valor )
	{
		$formato = 'Y-m-d H:i:s';
		$fecha = DateTime::createFromFormat( $formato, $valor );
		return $fecha && $fecha->format( $formato ) == $valor;
	}

	/**
	* Valida que una fecha sea mayor a cierta fecha definida con strtotime (como today)
	*
	* @param	mixed		$valor		El dato a validar
	* @param	mixed		$fecha		La fecha con la que se comparará (Realizada con strtotime)
	* @access	protected
	* @return	bool
	*/
	public function DESPUES( $valor, $fecha )
	{
		return $valor > strtotime( $fecha );
	}
	
	/**
	* Valida que los caracteres del dato sean mayores o iguales al mínimo
	*
	* @param	mixed		$valor		El dato a validar
	* @param	int			$minimo		Valor mínimo de caracteres
	* @access	protected
	* @return	bool
	*/
	public function MIN_LONGITUD( $valor, $minimo )
	{
		return strlen( $valor ) >= $minimo;
	}
	
	/**
	* Valida que los caracteres del dato sean menores o iguales al máximo
	*
	* @param	mixed		$valor		El dato a validar
	* @param	int			$maximo		Valor máximo de caracteres
	* @access	protected
	* @return	bool
	*/
	public function MAX_LONGITUD( $valor, $maximo )
	{
		return strlen( $valor ) <= $maximo;
	}
	
	/**
	* Valida que el dato numérico sea mayor al mínimo
	*
	* @param	mixed		$valor		El dato a validar
	* @param	int			$minimo		Valor mínimo
	* @access	protected
	* @return	bool
	*/
	public function MINIMO( $valor, $minimo )
	{
		return $valor >= $minimo;
	}
	
	/**
	* Valida que el dato numérico sea menor al máximo
	*
	* @param	mixed		$valor		El dato a validar
	* @param	int			$maximo		Valor máximo
	* @access	protected
	* @return	bool
	*/
	public function MAXIMO( $valor, $maximo )
	{
		return $valor <= $maximo;
	}

	/**
	* Compara que un número sea mayor que otro de este mismo objeto, esta función funciona también con fechas
	*
	* @param	mixed		$valor		El dato a validar
	* @param	string		$propiedad	La propiedad con la que se comparará
	* @access	protected
	* @return	bool
	*/
	public function MAYOR_A( $valor, $propiedad )
	{
		return (int) $valor >  (int) $this->datos[ $propiedad ];
	}

	/**
	* Valida que el dato tenga formato de correo electrónico
	*
	* @param	mixed		$valor		El dato a validar
	* @access	public
	* @return	bool
	*/
	public function EMAIL( $valor )
	{
		$correos = explode( ';', $valor );
		foreach ( $correos as $correo )
		{
			if ( filter_var( $valor, FILTER_VALIDATE_EMAIL ) === false )
			{
				return false;
			}
		}
		return true;
	}
}