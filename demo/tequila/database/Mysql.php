<?php
namespace tequila\database;
use \mysqli, \mysqli_stmt, \mysqli_result, tequila\sistema\Configurable;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Clase manejadora de base de datos
*
* Maneja las conexiones al motor de base de datos,
* en esta clase en específico se utiliza la clase mysqli
*
* @package	tequila.database
* @author	isaac
* @version	1
*/
class Mysql extends Configurable implements InterfazDatabase{
	/**
	* Dirección y nombre del archivo de configuración de esta clase
	*
	* @access	protected
	* @var		array
	*/
	protected $_ruta = array( 'tequila', 'database', 'configuraciones', 'mysql' );
	
	/**
	* Objeto de mysqli
	*
	* @access	private
	* @var		mysqli
	*/
	private $mysqli;
	
	/**
	* Objeto de sentencias preparadas
	*
	* @access	private
	* @var		mysqli_stmt
	*/
	private $sentencia;
	
	/**
	* Resultado de una sentencia sql
	*
	* Dependiendo del tipo de sentencia esta propiedadad puede ser
	* un objeto mysqli_result o un boolean
	*
	* @access	private
	* @var		mixed
	*/
	private $resultado;
	
	/**
	* Arreglo con significados de los tipos de dato del framework a parametro Mysqli
	*
	* @access	private
	* @var		array
	*/
	private $definiciones = array(
		'PLANO'			=> 's',
		'ALFANUMERICO'	=> 's',
		'ESCRITO'		=> 's',
		'TEXTO'			=> 's',
		'ENTERO'		=> 'i',
		'NUMERICO'		=> 'd',
		'DECIMAL'		=> 'd',
		'TIMESTAMP'		=> 'i',
		'FECHA'			=> 's',
		'BANDERA'		=> 'i',
		'EMAIL'			=> 's'
	);
	
	/**
	* Constructor
	*
	* Instancía el objeto mysqli lo que inicia la conexión
	*
	* @access	public
	* @throws	DatabaseException
	*/
	public function __construct()
	{
		parent::__construct();
		$this->mysqli = new mysqli( $this->_config['SERVIDOR'], $this->_config['USUARIO'],
			$this->_config['PASSWORD'], $this->_config['DATABASE'] );
		if ( !$this->mysqli )
		{
			throw new DatabaseException( $this->mysqli->error );
		}
		if ( !$this->mysqli->set_charset( $this->_config['CHARSET'] ) )
		{
			throw new DatabaseException( $this->mysqli->error );
		}
	}
	
	/**
	* Destructor
	*
	* Cierra la conexión con la base de datos
	*
	* @access	public
	*/
	public function __destruct()
	{
		if ( $this->sentencia instanceof mysqli_stmt )
		{
			$this->sentencia->close();
		}
		$this->mysqli->close();
	}
	
	/**
	* Ejecuta una sentencia sql sin preparar
	*
	* Cuando no se requiren parametros preparardos utilizar esta función
	*
	* @param	string	$sql	La sentencia sql a ejecutar
	* @access	public
	* @throws	DatabaseException
	*/
	public function simple( $sql )
	{
		$this->resultado = $this->mysqli->query( $sql );
		if ( $this->resultado === false )
		{
			throw new DatabaseException( $this->mysqli->error );
		}
	}
	
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
	public function conParametros( $sql, Parametrizador $params )
	{
		$this->preparar( $sql );
		$this->parametros( $params );
		$this->ejecutarSentencia();
	}
	
	/**
	* Efectúa la ejecución de la sentencia preparada
	*
	* @access	public
	* @throws	DatabaseException
	*/
	public function ejecutarSentencia()
	{
		$this->resultado = $this->sentencia->execute();
		if ( $this->resultado === false )
		{
			throw new DatabaseException( $this->sentencia->error );
		}
	}
	
	/**
	* Ejecuta una sentencia sql
	*
	* Esta función puede eje cutar una sentencia preparada o una simple,
	* dependiendo del parametro $params (null = simple, not null = preparada)
	*
	* @param	string			$sql		Sentencia sql a ejecutar
	* @param	Parametrizador	$params		Conjunto de parametros de una sentencia preparada
	* @access	public
	*/
	public function ejecutar( $sql, Parametrizador $params = null )
	{
		if ( !$params )
		{
			$this->simple( $sql );
		}
		else
		{
			$this->conParametros( $sql, $params );
		}
	}
	
	/**
	* Devuelve los resultados de una busqueda
	*
	* Esta función se debe llamar despues de haber realizado la ejecución de una sentencia
	*
	* @access	public
	* @return	array
	*/
	public function resultados(){
		if ( !isset( $this->resultado ) )
		{
			throw new DatabaseException( 'No hay resultados' );
		}
		if ( !$this->resultado instanceof mysqli_result )
		{
			$this->resultado = $this->sentencia->get_result();
		}		
		$resultado = array();
		while ( $registro = $this->resultado->fetch_assoc() )
		{
			$resultado[] = $registro;
		}
		$this->resultado->free();
		return $resultado;
	}
	
	/**
	* Inicia una transacción
	*
	* @access	public
	*/
	public function iniciarTransaccion()
	{
		$this->mysqli->autocommit( false );
	}
	
	/**
	* Realiza la confirmación de una transacción
	*
	* @access	public
	*/
	public function commit()
	{
		$this->mysqli->commit();
	}
	
	/**
	* Realiza la cancelación de una transacción
	*
	* @access	public
	*/
	public function rollback()
	{
		$this->mysqli->rollback();
	}
	
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
	public function escapar( $value )
	{
		return $this->mysqli->real_escape_string( $value );
	}
	
	/**
	* Devuelve el ultimo id insertado
	*
	* @access	public
	* @return	int
	*/
	public function ultimoId()
	{
		return $this->mysqli->insert_id;
	}
	
	/**
	* Prepara un sentencia sql
	*
	* Recibe una cadena con una sentencia en sql y la prepara,
	* devuelve este mismo objeto para "chaining"
	*
	* @param	string	$sql	La sentencia sql a preparar
	* @access	public
	* @return	Mysql
	* @throws	DatabaseException
	*/
	public function preparar( $sql )
	{
		if ( !$this->sentencia = $this->mysqli->prepare( $sql ) )
		{
			throw new DatabaseException( $this->mysqli->error );
		}
	}
	
	/**
	* Enlaza parametros a una sentencia preparada
	*
	* @param	Parametrizador	$params		Colección de parametros a enlazar
	* @access	public
	* @throws	DatabaseException
	*/
	public function parametros( Parametrizador $params )
	{
		$temp = array();
		$params->traducir( $this->definiciones );
		$temp[] = join( '', $params->types );
		foreach ( array_keys( $params->values ) as $key )
		{
			$temp[$key + 1] = &$params->values[$key];
		}
		if ( call_user_func_array( array( $this->sentencia, 'bind_param' ), $temp ) === false )
		{
			throw new DatabaseException( $this->sentencia->error );
		}
	}
}