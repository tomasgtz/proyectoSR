<?php
namespace tequila\contexto\relaciones;
use tequila\contexto\Relacion, tequila\contexto\Cxmodelo, tequila\contexto\Contexto;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Obtiene Cxmodelos relacionados del tipo "tiene muchos"
*
* @package	tequila.contexto.relaciones
* @author	isaac
* @version	1
*/
class TieneMuchos extends Relacion{
	/**
	* Nombre del campo en el contexto que es llave del modelo
	*
	* @access	private
	* @var		string
	*/
	private $foranea;
	
	/**
	* Constructor
	*
	* Se establecen los valores necesarios para realizar la busqueda,
	* se puede establecer opcionalmente el nombre de la llave foranea
	*
	* @param	Cxmodelo	$modelo		El modelo principal
	* @param	Contexto	$contexto	El contexto de la relación
	* @param	string		$foranea	Nombre del campo relacionado en el contexto
	* @access	public
	*/
	public function __construct( Cxmodelo $modelo, Contexto $contexto, $foranea = null )
	{
		parent::__construct( $modelo, $contexto );
		$this->foranea = isset( $foranea ) ? $foranea : 'id_' . $this->modelo->getContexto()->table;
	}
	
	/**
	* Devuelve los modelos relacionados
	*
	* @acess	public
	* @return	array
	*/
	public function ejecutar()
	{
		return $this->contexto->where( $this->foranea, '=', $this->modelo->id )->buscar()->lista();
	}
}