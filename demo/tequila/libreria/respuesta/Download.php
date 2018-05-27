<?php
namespace tequila\libreria\respuesta;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Esta clase manda la descarga del archivo mandado
*
* Debe de ser un archivo vaido para descargarse correctamente
*
* @package	tequila.libreria.respuesta
* @author	isaac
*/
class Download{
	/**
	* Constructor
	*
	* Recibe el mensaje de error
	*
	* @param	string		$fichero			Ruta del archivo a descargar
	* @access	public
	*/
	public function __construct( $fichero )
	{
		header( 'Content-Description: File Transfer' );
	    header( 'Content-Type: application/octet-stream' );
	    header( 'Content-Disposition: attachment; filename=' . basename( $fichero ) );
	    header( 'Content-Transfer-Encoding: binary' );
	    header( 'Expires: 0' );
	    header( 'Cache-Control: must-revalidate' );
	    header( 'Pragma: public' );
	   // header( 'Content-Length: ' . filesize( $fichero ) );
	    readfile( $fichero );
	    exit;
	}
}