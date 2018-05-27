<?php
	if ( isset( $mensaje ) )
	{
		$clase = isset( $error ) ? 'red' : 'green';
		echo Html::elemento( 'div', $mensaje, array( 'class' => 'alert ' . $clase ) );
	}
?>