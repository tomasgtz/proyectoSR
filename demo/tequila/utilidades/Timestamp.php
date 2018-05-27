<?php
namespace tequila\utilidades;
/**
* Funciones para el manejo y creación de fechas con strings
*
* @package	tequila.utilidades
* @author	isaac
* @version	1
*/
class Timestamp{
	/**
	* Recibe una fecha y la convierte en un timestamp
	*
	* El formato debe ser un arreglo con el orden en el que está escrita la fecha.
	* Los indices del formato deben ser ( m => mes, d => día, a => año, h => hora, t => minuto, s => segundo )
	* La fecha debe estar separada por diagonales "/", giones "-" o espacio en blanco " "
	*
	* @static
	* @param	string		$fecha		La fecha que se convertirá a timestamp
	* @param	array		$formato	El formato del orden que tienen los valores en $fecha
	* @access	public
	* @return	int
	*/
	public static function getTime( $fecha, array $formato = array( 'd', 'm', 'y', 'h', 't', 's' ) )
	{
		$tiempo = array( 'm' => 0, 'd' => 0, 'y' => 0, 'h' => 0, 't' => 0, 's' => 0 );
		$fecha = str_replace( array( '/', '-', ' ', ':' ), '-', $fecha );
		$separada = explode( '-', $fecha );
		foreach( $separada as $indice => $elemento )
		{
			$tiempo[ $formato[ $indice ] ] = $elemento;
		}
		return mktime( $tiempo['h'], $tiempo['t'], $tiempo['s'], $tiempo['m'], $tiempo['d'], $tiempo['y'] );
	}

	/**
	* Recibe una fecha incompleta y le añade el tiempo (23, 59, 59) después la convierte con getTime
	*
	* @static
	* @param	string		$fecha		La fecha que se convertirá a timestamp
	* @param	array		$formato	El formato del orden que tienen los valores en $fecha
	* @access	public
	* @return	int
	*/
	public static function getEndTime( $fecha, array $formato = array( 'd', 'm', 'y' ) )
	{
		return self::getTime( $fecha . ' 23:59:59', array_merge( $formato, array( 'h', 't', 's' ) ) );
	}

	/**
	* Recibe dos fechas y obtiene la catidad de días de diferencia
	*
	* La primer fecha debe ser la fecha a futuro
	*
	* @static
	* @param	mixed		$futuro		Timestamp de la fecha fin
	* @param	mixed		$fecha		Timestamp de la fecha inicio de la comparación	
	* @access	public
	* @return	int
	*/
	public static function dias( $futuro, $fecha = null )
	{
		if ( !isset( $fecha ) )
		{
			$fecha = time();
		}
		return round( ( $futuro - $fecha ) / 86400 );
	}
}