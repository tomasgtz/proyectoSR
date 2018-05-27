<?php
use tequila\inicio\Boot;
/**
* TequilaFramework
* Página inicial del framework,
* todas las peticiones llegan a este archivo que da de alta la función de auto cargado
*
* @package	tequila
* @author	isaac
* @version	1
*/

/**
* Constante
*
* Valor que se antepone a las direcciones url,
* este cambia cuando se ambientes como wamp o xampp.
* Normalmente en producción su valor será "/"
*/
define( 'URL', '/demo/' );

/**
* Constante
*
* Nivel de errores que se desplegarán en la pantalla,
* en producción, su valor debe ser "0"
*/
error_reporting( E_ALL | E_STRICT );

/**
* Constante
*
* Define el caracter de separador de directorio,
* este se usa dado a las diferencias en distintos sistemas operativos para este caracter
*/
define( 'DS', DIRECTORY_SEPARATOR );

/**
* Constante
*
* Define el caracter de separador de urls,
* este se usa para simplificar el armado de urls
*/
define( 'US', '/' );

/**
* Constante
*
* Extensión que tendrán los archivos de calses y templates,
* normalmente este dato jamás cambiará
*/
define( 'EXT', '.php' );

/**
* Constante
*
* Esta bandera cambia ciertas funcionalidades que van en un ambiente de desarrollo
*/
define( 'DEBUG', true );

require 'tequila' . DS . 'inicio' . DS . 'Autoload' . EXT;
spl_autoload_register( array( 'Autoload', 'incluir' ) );
$boot = new Boot();
$boot->ejecutar();