<?php
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Para generar títulos dinámicos de las páginas
*
* @package	tequila.mvc
* @author	isaac
* @version	1
*/
class Title extends Paquete{
	/**
	* Título que se mostrará
	*
	* @access	protected
	* @var		string
	*/
	protected $titulo;

	/**
	* Constructor
	*
	* @param	string		$titulo		El titulo que se dibujará
	* @access	public 
	*/
	public function __construct( $titulo )
	{
		$this->titulo = $titulo;
		parent::__construct( 'title', array() );
	}

	/**
	* Imprime este paquete
	*
	* @access	public
	* @return	string
	*/
	public function dibujar()
	{
		return Html::elemento( 'title', $this->titulo );
	}
}