<?php $membresia = Membresia::instanciaDefault(); ?>

<h4>
	<?php echo Html::link( 'innsert', Url::hacer( 'panel' ) ) ?>
	<button class="blue show"><i class="fa fa-bars"></i></button>
</h4>

<ul id="list">
	<?php
		/**
		* Menú de selección de colonia
		*/
		if ( !empty( $colonias ) )
		{
			echo Html::abrir( 'li', array( 'class' => 'form-control' ) ),
				Form::select( 'cambiarColonia', $colonias, 'nombre', Sess::instanciaDefault()->get( 'idColonia' ), 'Colonia actual...' ),
				Form::hidden( 'urlColonia', Url::hacer( 'administracion/inicio/cambiarColonia' ) ),
			Html::cerrar( 'li' );
		}

		/**
		* Sección Principal
		*/
		if ( $membresia->revisar() )
		{
			echo 
			Html::abrir( 'li' ),
				Html::link( '<i class="fa fa-line-chart ic"></i>Dashbord', Url::hacer( 'administracion' ) ),
			Html::cerrar( 'li' );
		}

		/**
		* Sección de Administración
		*/
		if ( $membresia->revisar( array( 'Innsert', 'Perfiles de Usuario', 'Usuarios' ) ) )
		{
			echo Html::abrir( 'li', $opciones->super_admin->attrs ),
				Html::link( '<i class="fa fa-building-o ic"></i> Administración ' . $opciones->super_admin->icon, Url::hacer( 'administracion/#super_admin' ) ),
				Html::abrir( 'ul' );


				/**
				* Sección de Colonias
				*/
				if ( $membresia->revisar( array( 'Innsert' ) ) )
				{
					echo Html::abrir( 'li', $opciones->colonias->attrs ),
						Html::link( '<i class="fa ic fa-building-o"></i>Colonias', Url::hacer( 'administracion/colonias' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Administradores de Colonias
				*/
				if ( $membresia->revisar( array( 'Innsert' ) ) )
				{
					echo Html::abrir( 'li', $opciones->administradores->attrs ),
						Html::link( '<i class="fa ic fa-mortar-board"></i>Administradores de Colonias', Url::hacer( 'administracion/colonias/administradores' ) );
					Html::cerrar( 'li' );
				}


				/**
				* Sección de Datos Fiscales
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Datos Fiscales' ) ) )
				{
					echo Html::abrir( 'li', $opciones->datosFiscales->attrs ),
						Html::link( '<i class="fa ic fa-list-alt"></i>Datos Fiscales', Url::hacer( 'administracion/fiscales' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Perfiles de Usuario
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Perfiles de Usuario' ) ) )
				{
					echo Html::abrir( 'li', $opciones->perfiles->attrs ),
						Html::link( '<i class="fa ic fa-book"></i>Perfiles de Usuario', Url::hacer( 'administracion/perfiles' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Usuario
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Usuarios' ) ) )
				{
					echo Html::abrir( 'li', $opciones->usuarios->attrs ),
						Html::link( '<i class="fa ic fa-users"></i>Usuarios', Url::hacer( 'administracion/usuarios' ) );
					Html::cerrar( 'li' );
				}

				/**
				* puestos
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Puestos' ) ) )
				{
					echo Html::abrir( 'li', $opciones->puestos->attrs ),
						Html::link( '<i class="fa ic fa-wrench"></i>Puestos del Consejo', Url::hacer( 'administracion/puestos' ) );
					Html::cerrar( 'li' );
				}

				/**
				* asambleas
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Asambleas' ) ) )
				{
					echo Html::abrir( 'li', $opciones->asambleas->attrs ),
						Html::link( '<i class="fa ic  fa-balance-scale"></i>Asambleas', Url::hacer( 'administracion/asambleas' ) );
					Html::cerrar( 'li' );
				}

				/**
				* miembros
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Miembros' ) ) )
				{
					echo Html::abrir( 'li', $opciones->miembros->attrs ),
						Html::link( '<i class="fa ic fa-star"></i>Miembros del Consejo', Url::hacer( 'administracion/miembros' ) );
					Html::cerrar( 'li' );
				}

				/**
				* minutas
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Minutas' ) ) )
				{
					echo Html::abrir( 'li', $opciones->minutas->attrs ),
						Html::link( '<i class="fa ic fa-file-archive-o"></i>Minutas', Url::hacer( 'administracion/minutas' ) );
					Html::cerrar( 'li' );
				}

				/**
				* unidades
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Unidades' ) ) )
				{
					echo Html::abrir( 'li', $opciones->unidades->attrs ),
						Html::link( '<i class="fa ic fa-bolt"></i>Unidades de Medida', Url::hacer( 'administracion/unidades' ) );
					Html::cerrar( 'li' );
				}

				echo Html::cerrar( 'ul' ),
			Html::cerrar( 'li' );
		}

		/**
		* Sección de Residentes
		*/
		if ( $membresia->revisar( array( 'Innsert', 'Residentes', 'Casas' ) ) )
		{
			echo Html::abrir( 'li', $opciones->super_residentes->attrs ),
				Html::link( '<i class="fa fa-home ic"></i> Residentes ' . $opciones->super_residentes->icon, Url::hacer( 'administracion/#super_residentes' ) ),
				Html::abrir( 'ul' );

				/**
				* Sección de Residentes
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Residentes' ) ) )
				{
					echo Html::abrir( 'li', $opciones->residentes->attrs ),
						Html::link( '<i class="fa ic fa-child"></i>Residentes', Url::hacer( 'administracion/residentes' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Lotes
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Casas' ) ) )
				{
					echo Html::abrir( 'li', $opciones->lotes->attrs ),
						Html::link( '<i class="fa ic fa-home"></i>Lotes', Url::hacer( 'administracion/casas' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Estacionamientos
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Estacionamientos' ) ) )
				{
					echo Html::abrir( 'li', $opciones->estacionamientos->attrs ),
						Html::link( '<i class="fa ic fa-car"></i>Estacionamientos', Url::hacer( 'administracion/estacionamientos' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Almacenes
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Almacenes' ) ) )
				{
					echo Html::abrir( 'li', $opciones->almacenes->attrs ),
						Html::link( '<i class="fa ic fa-dropbox"></i>Almacenes', Url::hacer( 'administracion/almacenes' ) );
					Html::cerrar( 'li' );
				}
				
				echo Html::cerrar( 'ul' ),
			Html::cerrar( 'li' );
		}

		/**
		* Sección de Proyectos y servicios
		*/
		if ( $membresia->revisar( array( 'Innsert', 'Iniciativas', 'Proyectos', 'Proveedores' ) ) )
		{
			echo Html::abrir( 'li', $opciones->super_proyectos->attrs ),
				Html::link( '<i class="fa fa-briefcase ic"></i> Proyectos y Servicios ' . $opciones->super_proyectos->icon, Url::hacer( 'administracion/#super_proyectos' ) ),
				Html::abrir( 'ul' );

				/**
				* Sección deProveedores
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Proveedores' ) ) )
				{
					echo Html::abrir( 'li', $opciones->proveedores->attrs ),
						Html::link( '<i class="fa ic fa-truck"></i>Proveedores', Url::hacer( 'administracion/proveedores' ) );
					Html::cerrar( 'li' );
				}
		

				/**
				* Sección de Iniciativas
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Iniciativas' ) ) )
				{
					echo Html::abrir( 'li', $opciones->iniciativas->attrs ),
						Html::link( '<i class="fa ic fa-cloud"></i>Iniciativas', Url::hacer( 'administracion/iniciativas' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Cotizaciones
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Cotizaciones' ) ) )
				{
					echo Html::abrir( 'li', $opciones->cotizaciones->attrs ),
						Html::link( '<i class="fa ic fa-file-excel-o"></i>Cotizaciones', Url::hacer( 'administracion/cotizaciones' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Proyectos
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Proyectos' ) ) )
				{
					echo Html::abrir( 'li', $opciones->proyectos->attrs ),
						Html::link( '<i class="fa ic fa-briefcase"></i>Proyectos y Servicios', Url::hacer( 'administracion/proyectos' ) );
					Html::cerrar( 'li' );
				}

				echo Html::cerrar( 'ul' ),
			Html::cerrar( 'li' );
		}

		/**
		* Sección de finanzas
		*/
		if ( $membresia->revisar( array( 'Innsert', 'Bancos', 'Cuentas de Banco', 'Aportaciones', 'Pagos', 'Egresos', 'Cuentas por Pagar' ) ) )
		{
			echo Html::abrir( 'li', $opciones->super_finanzas->attrs ),
				Html::link( '<i class="fa fa-calculator ic"></i> Finanzas ' . $opciones->super_finanzas->icon, Url::hacer( 'administracion/#super_finanzas' ) ),
				Html::abrir( 'ul' );

				/**
				* Sección de Adeudos
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Adeudos' ) ) )
				{
					echo Html::abrir( 'li', $opciones->adeudos->attrs ),
						Html::link( '<i class="fa ic fa-archive"></i>Adeudos', Url::hacer( 'administracion/adeudos' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Bancos
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Bancos' ) ) )
				{
					echo Html::abrir( 'li', $opciones->bancos->attrs ),
						Html::link( '<i class="fa ic fa-university"></i>Bancos', Url::hacer( 'administracion/bancos' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Cuentas de Banco
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Cuentas de Banco' ) ) )
				{
					echo Html::abrir( 'li', $opciones->cuentas->attrs ),
						Html::link( '<i class="fa ic fa-credit-card"></i>Cuentas de Banco', Url::hacer( 'administracion/cuentas' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Recargos
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Recargos' ) ) )
				{
					echo Html::abrir( 'li', $opciones->recargos->attrs ),
						Html::link( '<i class="fa ic fa-gavel"></i>Recargos', Url::hacer( 'administracion/recargos' ), array( 'class' => 'sp-config', 'data-config' => 'recargos' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Aportaciones
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Aportaciones' ) ) )
				{
					echo Html::abrir( 'li', $opciones->aportaciones->attrs ),
						Html::link( '<i class="fa ic fa-calculator"></i>Aportaciones', Url::hacer( 'administracion/aportaciones' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Tipos de Cuentas por Pagar
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Cuentas por Pagar' ) ) )
				{
					echo Html::abrir( 'li', $opciones->pagar->attrs ),
						Html::link( '<i class="fa ic fa-envelope"></i>Cuentas por Pagar', Url::hacer( 'administracion/cuentas-por-pagar' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Ingresos
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Ingresos' ) ) )
				{
					echo Html::abrir( 'li', $opciones->ingresos->attrs ),
						Html::link( '<i class="fa ic fa-money"></i>Ingresos', Url::hacer( 'administracion/ingresos' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Egresos
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Egresos' ) ) )
				{
					echo Html::abrir( 'li', $opciones->egresos->attrs ),
						Html::link( '<i class="fa ic fa-dollar"></i>Egresos', Url::hacer( 'administracion/egresos' ) );
					Html::cerrar( 'li' );
				}

				
				/**
				* Sección de Facturas
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Facturas' ) ) )
				{
					echo Html::abrir( 'li', $opciones->facturas->attrs ),
						Html::link( '<i class="fa ic fa-qrcode"></i>Facturas', Url::hacer( 'administracion/facturas' ), array( 'class' => 'sp-config', 'data-config' => 'facturaElectronica' ) );
					Html::cerrar( 'li' );
				}

				echo Html::cerrar( 'ul' ),
			Html::cerrar( 'li' );
		}

		/**
		* Sección de zonas publicas
		*/
		if ( $membresia->revisar( array( 'Innsert', 'Horarios', 'Zonas' ) ) )
		{
			echo Html::abrir( 'li', $opciones->super_zonas->attrs ),
				Html::link( '<i class="fa fa-tree ic"></i> Zonas Públicas y Reservaciones ' . $opciones->super_zonas->icon, Url::hacer( 'administracion/#super_zonas' ) ),
				Html::abrir( 'ul' );

				/**
				* Sección de Horarios
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Horarios' ) ) )
				{
					echo Html::abrir( 'li', $opciones->horarios->attrs ),
						Html::link( '<i class="fa ic fa-clock-o"></i>Horarios', Url::hacer( 'administracion/horarios' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Zonas
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Zonas' ) ) )
				{
					echo Html::abrir( 'li', $opciones->zonas->attrs ),
						Html::link( '<i class="fa ic fa-tree"></i>Zonas Públicas', Url::hacer( 'administracion/zonas' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Reservaciones
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Reservaciones' ) ) )
				{
					echo Html::abrir( 'li', $opciones->reservaciones->attrs ),
						Html::link( '<i class="fa ic  fa-calendar"></i>Reservaciones', Url::hacer( 'administracion/reservaciones' ) );
					Html::cerrar( 'li' );
				}

				/**
				* Sección de Reglamentos
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Reglamentos' ) ) )
				{
					echo Html::abrir( 'li', $opciones->reglamentos->attrs ),
						Html::link( '<i class="fa ic fa-list-ol"></i>Reglamentos', Url::hacer( 'administracion/reglamentos' ) );
					Html::cerrar( 'li' );
				}

				echo Html::cerrar( 'ul' ),
			Html::cerrar( 'li' );
		}

		
		/**
		* Sección de Tipos de Anuncios
		*/
		if ( $membresia->revisar( array( 'Innsert', 'Tipos de Anuncio' ) ) )
		{
			echo Html::abrir( 'li', $opciones->tipos->attrs ),
				Html::link( '<i class="fa ic fa-folder"></i>Tipos de Anuncio', Url::hacer( 'administracion/tipos' ) );
			Html::cerrar( 'li' );
		}

		/**
		* Sección de Quejas
		*/
		if ( $membresia->revisar( array( 'Innsert', 'Quejas' ) ) )
		{
			echo Html::abrir( 'li', $opciones->quejas->attrs ),
				Html::link( '<i class="fa ic fa-weixin"></i>Quejas', Url::hacer( 'administracion/quejas' ) );
			Html::cerrar( 'li' );
		}

		/**
		* Sección de Correos
		*/
		if ( $membresia->revisar( array( 'Innsert', 'Correos' ) ) )
		{
			echo Html::abrir( 'li', $opciones->correos->attrs ),
				Html::link( '<i class="fa ic fa-at"></i>Notificaciones Por Correo', Url::hacer( 'administracion/correos' ) );
			Html::cerrar( 'li' );
		}

		/**
		* Sección de Reportes
		*/
		if ( $membresia->revisar( array( 'Innsert', 'Reportes' ) ) )
		{
			echo Html::abrir( 'li', $opciones->super_reportes->attrs ),
				Html::link( '<i class="fa fa-bar-chart ic"></i> Reportes ' . $opciones->super_reportes->icon, Url::hacer( 'administracion/#super_reportes' ) ),
				Html::abrir( 'ul' );

				/**
				* Reportes de Finanzas
				*/
				if ( $membresia->revisar( array( 'Innsert', 'Reportes' ) ) )
				{
					echo Html::abrir( 'li', $opciones->finanzas->attrs ),
						Html::link( '<i class="fa ic fa-money"></i>Finanzas', Url::hacer( 'administracion/reportes/finanzas' ) );
					Html::cerrar( 'li' );
				}

				echo Html::cerrar( 'ul' ),
			Html::cerrar( 'li' );
		}
		
		/**
		* Sección Estados
		*/
		if ( $membresia->revisar( array( 'Innsert' ) ) )
		{
			echo Html::abrir( 'li', $opciones->estados->attrs ),
				Html::link( '<i class="fa ic fa-globe ic"></i>Estados', Url::hacer( 'administracion/estados' ) );
			Html::cerrar( 'li' );
		}
	?>
</ul>