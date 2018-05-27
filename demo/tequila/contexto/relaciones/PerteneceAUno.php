<?php
namespace tequila\contexto\relaciones;
use tequila\contexto\Relacion, tequila\contexto\Cxmodelo, tequila\contexto\Contexto;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Obtiene Cxmodelos relacionados del tipo "pertenece a uno"
*
* @package	tequila.contexto.relaciones
* @author	isaac
* @version	1
*/
class PerteneceAUno extends Relacion{
	/**
	* Nombre de la propiedad relacionada
	*
	* La propiedad representa la llave foranea en el modelo que sería el id del contexto relacionado
	*
	* @acess	private
	* @var		string
	*/
	private $propiedad;
	
	/**
	* Constructor
	*
	* Se establecen los valores necesarios para realizar la busqueda,
	* si la propiedad que es llave foranea no se establece se establecerá una por default
	*
	* @param	Cxmodelo	$modelo		El modelo principal
	* @param	Contexto	$contexto	El contexto de la relación
	* @param	string		$propiedad	Nombre de la propiedad que es llave foranea en el modelo
	* @access	public
	*/
	public function __construct( Cxmodelo $modelo, Contexto $contexto, $propiedad = null )
	{
		parent::__construct( $modelo, $contexto );
		$this->propiedad = isset( $propiedad ) ? $propiedad : 'id_' . $contexto->table;
	}
	
	/**
	* Devuelve los modelos relacionados
	*
	* @acess	public
	* @return	Cxmodelo
	*/
	public function ejecutar()
	{
		return $this->contexto->buscarId( $this->modelo->{ $this->propiedad } );
	}
}