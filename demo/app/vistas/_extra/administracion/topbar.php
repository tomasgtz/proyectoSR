<?php $membresia = Membresia::instanciaDefault(); ?>

<nav class="nav tools">
	<div id="navs" class="lists">
		<ul>
			<li class="dropper notifications complaints">
				<?php
					echo Form::hidden( 'notificationsURL', Url::hacer( 'administracion/inicio/quejas' ) ),
					Form::hidden( 'solutionsURL', Url::hacer( 'administracion/quejas/comentarios' ) );
				?>
				<a href="/#" title="Quejas"><i class="fa fa-bell"></i><span class="badge">0</span></a>
				<ul class="dropdown">
					<!--<li> /// Ejemplo de como se compone una notificación
						<a href="/#">
							<div>
								<i class="fa fa-weixin"></i>
								<b>Nueva Notificación</b> del usuario <b>Administrador Innsert</b>
							</div>
							<div class="date">
								<?php //echo date( 'd/m/Y h:i:s' ) ?>
							</div>
						</a>
					</li>-->
				</ul>
			</li>
			<li class="dropper notifications debts">
				<?php
					echo Form::hidden( 'debtsURL', Url::hacer( 'administracion/inicio/adeudos' ) ),
					Form::hidden( 'debtsDetailURL', Url::hacer( 'administracion/residentes/adeudo' ) );
				?>
				<a href="/#" title="Adeudos"><i class="fa fa-archive"></i><span class="badge">0</span></a>
				<ul class="dropdown">
					<!--<li> /// Ejemplo de como se compone una notificación
						<a href="/#">
							<div>
								<i class="fa fa-weixin"></i>
								<b>Nueva Notificación</b> del usuario <b>Administrador Innsert</b>
							</div>
							<div class="date">
								<?php //echo date( 'd/m/Y h:i:s' ) ?>
							</div>
						</a>
					</li>-->
				</ul>
			</li>
			<li class="dropper notifications bills">
				<?php
					echo Form::hidden( 'billsURL', Url::hacer( 'administracion/inicio/cuentas' ) ),
					Form::hidden( 'billsDetailURL', Url::hacer( 'administracion/egresos/insertar' ) );
				?>
				<a href="/#" title="Cuentas por Pagar"><i class="fa fa-envelope"></i><span class="badge">0</span></a>
				<ul class="dropdown">
					<!--<li> /// Ejemplo de como se compone una notificación
						<a href="/#">
							<div>
								<i class="fa fa-weixin"></i>
								<b>Nueva Notificación</b> del usuario <b>Administrador Innsert</b>
							</div>
							<div class="date">
								<?php //echo date( 'd/m/Y h:i:s' ) ?>
							</div>
						</a>
					</li>-->
				</ul>
			</li>
		</ul>

		<ul class="right">

			<?php if ( $membresia->revisar() ): ?>

			<li class="dropper">
				<?php
					Echo Html::link( '<i class="fa fa-smile-o pre"></i> ' . $membresia->usuario->nombre . ' <i class="fa fa-caret-down"></i>', '/#' ),
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

			<?php endif; ?>

		</ul>
	</div>
</nav>