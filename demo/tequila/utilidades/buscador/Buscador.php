<?php
namespace tequila\utilidades\buscador;
use \Html, \Url;
/**
* Extensión del buscador, personaliza la impresión del paginador
*
* @author	isaac
* @package	tequila.utilidades
* @version	2
*/
class Buscador extends BaseBuscador{
	/**
	* Total de paginas a mostrar antes y después de la actual
	*
	* @access	private
	* @var		int
	*/
	private $cuantas = 5;

	/**
	* Dibuja la paginación
	*
	* @access	public
	* @return	string
	*/
	public function dibujarPaginacion()
	{
		$primero = max( 1, $this->pagina - $this->cuantas );
		$ultimo = min( $this->paginas, $this->pagina + $this->cuantas );
		$html = Html::abrir( 'ul', array( 'class' => 'pagination right' ) );
		if ( $this->pagina > 1 )
		{
			$html .= Html::abrir( 'li' ) . Html::link( '&laquo;', Url::hacer( $this->url, 1, $this->query ) ) . Html::cerrar( 'li' );
		}
		else
		{
			$html .= Html::abrir( 'li', array( 'class' => 'dis' ) ) . Html::elemento( 'span', '&laquo' ) . Html::cerrar( 'li' );
		}
		for ( $i = $primero; $i <= $ultimo; $i++ )
		{
			if ( $this->pagina == $i )
			{
				$html .= Html::abrir( 'li', array( 'class' => 'act' ) ) . Html::elemento( 'span', $i ) . Html::cerrar( 'li' ) . Html::cerrar( 'li' );
			}
			else
			{
				$html .= Html::abrir( 'li' ) . Html::link( $i, Url::hacer( $this->url, $i, $this->query ) ) . Html::cerrar( 'li' );
			}
		}
		if ( $this->pagina < $this->paginas )
		{
			$html .= Html::abrir( 'li' ) . Html::link( '&raquo;', Url::hacer( $this->url, $this->paginas, $this->query ) ) . Html::cerrar( 'li' );
		}
		else
		{
			$html .= Html::abrir( 'li', array( 'class' => 'dis' ) ) . Html::elemento( 'span', '&raquo' ) . Html::cerrar( 'li' );
		}
		return $html;			
	}
}