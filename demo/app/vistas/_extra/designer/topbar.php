<nav class="nav">
	<div class="main">
		<div class="name image">
			<?php
				echo Html::link( Html::img( Url::hacer( 'recursos/imagenes/innsert.png' ) ), '#banner', array( 'class' => 'link' ) );
			?>
		</div>
	</div>

	<ul id="navs" class="lists right">
		<li class="dropper">
			<?php
				echo Html::link( '<i class="fa fa-smile-o pre"></i> Usuario en sesión <i class="fa fa-caret-down"></i>', '/#' ),
				Html::abrir( 'ul', array( 'class' => 'dropdown' ) ),
					Html::abrir( 'li' ),
						Html::link( '<i class="fa fa-key pre"></i> Cambiar contraseña', Url::hacer( 'inicio/password' ) ),
					Html::cerrar( 'li' ),

					Html::abrir( 'li' ),
						Html::abrir( 'hr' ),
					Html::cerrar( 'li' ),

					Html::abrir( 'li' ),
						Html::link( '<i class="fa fa-power-off pre"></i> Cerrar Sesión', Url::hacer( 'inicio/salir' ) ),
					Html::cerrar( 'li' ),
				Html::cerrar( 'ul' );
			?>
		</li>
	</ul>
</nav>