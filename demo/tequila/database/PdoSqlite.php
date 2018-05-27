<?php
namespace tequila\database;
use \PDO, \PDOStatement, \PDOException, tequila\sistema\Configurable;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Clase manejadora de base de datos
*
* Maneja las conexiones al motor de base de datos,
* en esta clase se usa en específico pdo para mysql
*
* @package	tequila.database
* @author	isaac
* @version	1
*/
class PdoSqlite extends Configurable implements InterfazDatabase{
	/**
	* Dirección y nombre del archivo de configuración de esta clase
	*
	* @access	protected
	* @var		array
	*/
	protected $_ruta = array( 'tequila', 'database', 'configuraciones', 'sqlite' );
	
	/**
	* Objeto de pdo
	*
	* @access	private
	* @var		PDO
	*/
	private $pdo;
	
	/**
	* Objeto de sentencias preparadas
	*
	* @access	private
	* @var		PDOStatement
	*/
	private $sentencia;
	
	/**
	* Resultado de una sentencia de sql
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
		'PLANO'			=> SQLITE3_TEXT,
		'ALFANUMERICO'	=> SQLITE3_TEXT,
		'ESCRITO'		=> SQLITE3_TEXT,
		'TEXTO'			=> SQLITE3_TEXT,
		'ENTERO'		=> SQLITE3_INTEGER,
		'NUMERICO'		=> SQLITE3_FLOAT,
		'DECIMAL'		=> SQLITE3_FLOAT,
		'TIMESTAMP'		=> SQLITE3_INTEGER,
		'FECHA'			=> SQLITE3_TEXT,
		'BANDERA'		=> SQLITE3_INTEGER,
		'EMAIL'			=> SQLITE3_TEXT
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
		try{
			$this->pdo = new PDO( 'sqlite:' . $this->_config['FILE'] );
			$this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch ( PDOException $ex )
		{
			throw new DatabaseException( $ex->getMessage() );
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
		$this->pdo = null;
		$this->sentencia = null;
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
		$this->sentencia = $this->pdo->query( $sql );
		if ( $this->sentencia === false )
		{
			throw new DatabaseException( $this->pdo->errorInfo() );
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
		if ( $this->sentencia->execute() === false )
		{
			throw new DatabaseException( $this->sentencia->errorInfo() );
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
		if ( !isset( $this->sentencia ) )
		{
			throw new DatabaseException( 'No hay resultados' );
		}
		return $this->sentencia->fetchAll( PDO::FETCH_ASSOC );
	}
	
	/**
	* Inicia una transacción
	*
	* @access	public
	*/
	public function iniciarTransaccion()
	{
		$this->pdo->beginTransaction();
	}
	
	/**
	* Realiza la confirmación de una transacción
	*
	* @access	public
	*/
	public function commit()
	{
		$this->pdo->commit();
	}
	
	/**
	* Realiza la cancelación de una transacción
	*
	* @access	public
	*/
	public function rollback()
	{
		$this->pdo->rollBack();
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
		return $this->pdo->quote( $value );
	}
	
	/**
	* Devuelve el ultimo id insertado
	*
	* @access	public
	* @return	int
	*/
	public function ultimoId()
	{
		return $this->pdo->lastInsertId();
	}
	
	/**
	* Prepara un sentencia sql
	*
	* Recibe una cadena con una sentencia en sql y la prepara,
	* devuelve este mismo objeto para "chaining"
	*
	* @param	string	$sql	La sentencia sql a preparar
	* @access	public
	* @throws	DatabaseException
	*/
	public function preparar( $sql )
	{
		if ( !$this->sentencia = $this->pdo->prepare( $sql ) )
		{
			throw new DatabaseException( $this->mysqli->errorInfo() );
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
		$params->traducir( $this->definiciones );
		foreach ( $params->types as $indice => $valor )
		{
			if ( !$this->sentencia->bindValue( ( $indice + 1 ), $params->values[$indice], $valor ) )
			{
				throw new DatabaseException( $this->sentencia->errorInfo() );
			}
		}
	}
}