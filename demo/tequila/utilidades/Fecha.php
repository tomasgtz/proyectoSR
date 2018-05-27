<?php
use \DateTime;
/**
* Representa una fecha
*
* @author	isaac
* @package	clases
* @version	1
*/
class Fecha{
	/**
	* El objeto de la fecha
	*
	* @access	public
	* @var		DateTime
	*/
	public $date;

	/**
	* El formato default de esta fecha
	*
	* @access	public
	* @var		string
	*/
	public $format;

	/**
	* Constructor
	*
	* Recibe la fecha, ya sea en un objeto DateTime o un string con formato de fecha
	*
	* @param	mixed		$date		La fecha a manejar, puede ser un string o un objeto de fecha
	* @param	string		$formato	El formato default que utilizará esta fecha
	* @access	public
	*/
	public function __construct( $date, $format = 'Y-m-d H:i:s' )
	{
		$this->format = $format;
		$this->date = ( $date instanceof DateTime ) ? $this->date = $date :
			$this->date = DateTime::createFromFormat( $this->format, $date );
	}

	/**
	* Función estática para instanciar Fechas
	*
	* @static
	* @param	mixed		$date		La fecha a manejar, puede ser un string o un objeto de fecha
	* @param	string		$formato	El formato default que utilizará esta fecha
	* @access	public
	*/
	public static function hacer( $date, $format = 'Y-m-d H:i:s' )
	{
		return new self( $date, $format );
	}

	/**
	* Establece el tiempo del día al inicio (00:00:00)
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @access	public
	* @return	Fecha
	*/
	public function inicioDelDia()
	{
		$this->date->setTime( 0, 0 );
		return $this;
	}

	/**
	* Establece el tiempo del día al final (23:59:59)
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @access	public
	* @return	Fecha
	*/
	public function finalDelDia()
	{
		$this->date->setTime( 23, 59, 59 );
		return $this;
	}

	/**
	* Extrae el valor de la fecha para que sea compatible con base de datos
	*
	* @access	public
	* @return	string
	*/
	public function paraBaseDeDatos()
	{
		return $this->date->format( 'Y-m-d H:i:s' );
	}

	/**
	* Imprime una fecha de manera un poco más chida
	*
	* @access	public
	* @return	string
	*/
	public function formatear( $format )
	{
		return str_replace( array( 'Jan', 'Apr', 'Aug', 'Dec' ), array( 'Ene', 'Abr', 'Ago', 'Dic' ),
			$this->date->format( $format ) );
	}

	/**
	* Añade meses sin pasarse de días a una fecha
	*
	* @param	int		$meses		La cantidad de meses a sumar
	* @access	public
	*/
	public function addMeses( $meses )
	{
		$newDate = new DateTime( $this->date->format( 'Y-m-d H:i:s' ) );
		$newDate->modify( "+{$meses} month" );
		$month = (int)$this->date->format( 'm' );
		$newMonth = $month + $meses;
		if ( $newMonth > 12 )
		{
			$newMonth = $newMonth - 12;
		}
		if ( (int)$newDate->format( 'm' ) > $newMonth )
		{
			$newDate->modify( '-1 month' );
			return new self( "{$newDate->format( 'Y' )}-{$newMonth}-{$newDate->format( 't H:i:s' )}" );
		}
		return new self( $newDate->format( 'Y-m-d H:i:s' ) );
	}
}