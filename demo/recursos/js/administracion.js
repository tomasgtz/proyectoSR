$( function(){
	/**
	* Objeto que contiene las configuraciones especiales
	*
	* @var	jQueryObject
	*/
	var configurations = $( '#configuracionesEspeciales' );

	/**
	* Evento Click
	*
	* Funcionalidad del menú lateal
	*/
	$( '.sub-menu > a' ).click( function( ev ){
		ev.preventDefault();
		var link = $( this ), item = link.parent(), list = item.find( '> ul' );
		if ( list.is( ':visible' ) )
		{
			list.slideUp( 'fast', function(){
				item.removeClass( 'act' );
			});
			link.find( '.ct' ).removeClass( 'fa-caret-down' ).addClass( 'fa-caret-right' );
		}
		else
		{
			list.slideDown( 'fast' );
			link.find( '.ct' ).removeClass( 'fa-caret-right' ).addClass( 'fa-caret-down' );
			item.addClass( 'act' );
		}
	});

	/**
	* Evento Click
	*
	* Funcionalidad para desplegar el menu responsivo
	*/
	$( '.show' ).click( function(){
		$( '#list' ).slideToggle();
	});

	/**
	* Evento submit
	*
	* Ejecuta el plugin submitter
	*/
	$( '#content form[ method=post ]' ).not( '.not-ajax' ).submitter({
		beforeSubmit:	function( form ){
			var errors = $.validate( form );
			if ( errors.length > 0 ){
				messageDisplay( errors.join( '<br/>' ), 'red' );
				return false;
			}
			return true;
		},
		response	:	function( data, form ){
			if ( !data.omitir ){
				var status = ( data.estatus == 'ERROR' ) ? 'red' : 'green';
				var redirect = ( data.estatus != 'ERROR' && data.redireccion ) ? data.redireccion : undefined;
				messageDisplay( data.mensaje, status, redirect );
			}
		}
	});
	
	/**
	* Evento submit
	*
	* Estila la url de un formulario de busqueda
	*/
	$( '#content form[ method=get ]' ).submit( function( ev ){
		ev.preventDefault();
		var form = $( this );
		var query = form.find( ':input[ value!="" ]' ).serialize();
		var resultado = query == '' ? '' : '?' + query;
		window.location = form.attr( 'action' ) + resultado;
	});

	/**
	* Evento keyPress
	*
	* Evita que al presionar "Enter" se envíe el formulario
	*/
	$( '.input input:not( :submit ), .input select' ).keypress( function( ev ){
		if ( ev.keyCode == 13 ){
			ev.preventDefault();
			var input = $( this );
			input.closest( '.input' ).next( '.input' ).find( 'input, select' ).focus();
		}
	});

	/**
	* Evento click
	*
	* Botón para borrar registros
	*/
	$( '.delete' ).click( function( ev ){
		ev.preventDefault();
		var button = $( this );
		var msgDelete = $( '#deletes' );
		var btnDelete = msgDelete.find( '.confirm' );
		btnDelete.click( function( ev ){
			ev.preventDefault();
			$.ajax({
				url		: button.attr( 'href' ),
				data	: { id : button.attr( 'data-id' ) },
				type	: 'POST',
				success	: function( data ){
					if ( data.estatus == 'EXITO' ){
						if ( button.hasClass( 'parent-delete' ) ){
							button.closest( '.delete-parent' ).remove();
						}
						else{
							button.closest( 'tr' ).remove();
						}
					}
					btnDelete.unbind( 'click' );
				},
				error	: function(){
					btnDelete.unbind( 'click' );
				}
			});
		});
		msgDelete.deploy();
	});

	/**
	* Cambia de colonia principal
	*
	* Evento change
	*/
	$( '#cambiarColonia' ).change( function(){
		var colonia = $( this );
		$.ajax({
			url		: $( '#urlColonia' ).val(),
			data	: { id : colonia.val() },
			type	: 'POST',
			success	: function( data ){
				if ( data.estatus == 'EXITO' ){
					messageDisplay( 'Se cambió la colonia correctamente', 'green' );
					$( '#submits' ).find( 'button' ).click( function(){
						window.location.reload();
					});
				}
			}
		});
	});

	/**
	* Carga las notificaciones de quejas (cada 90 segundos)
	*
	* Interval
	*/
	setInterval( function(){
		loadComplaints();
	}, 90000 );
	var complaints = $( '.notifications.complaints' ),
		complaintsList = complaints.find( '.dropdown' ),
		complaintsBadge = complaints.find( '.badge' ),
		notificationsURL = $( '#notificationsURL' ).val(),
		solutionsURL = $( '#solutionsURL' ).val();
	function loadComplaints(){
		$.ajax({
			url		: notificationsURL,
			type	: 'POST',
			success	: function( data ){
				if ( data.estatus && data.estatus == 'EXITO' ){
					var counted = data.quejas.length;
					complaintsBadge.html( counted );
					if ( counted > 0 ){
						complaintsBadge.addClass( 'red' );
					}
					else{
						complaintsBadge.removeClass( 'red' );
					}
					complaintsList.html( '' );
					for ( var i in data.quejas ){
						var queja = data.quejas[ i ];
						var item = $( document.createElement( 'li' ) );
						var link = $( document.createElement( 'a' ) )
							.attr( 'href', solutionsURL + '/' + queja.id );
						link.append( $( document.createElement( 'div' ) )
							.append( $( document.createElement( 'i' ) ).addClass( 'fa fa-weixin ic' ) )
							.append( $( document.createElement( 'b' ) ).html( queja.titulo ) )
							.append( ' del usuario ' )
							.append( $( document.createElement( 'b' ) ).html( queja.idUsuarioRegistro_nombre ) ) );
						link.append( $( document.createElement( 'div' ) ).addClass( 'date' )
							.append( queja.fechaRegistro ) );
						complaintsList.append( item.append( link ) );
					}
				}
			}
		});
	}
	loadComplaints();

	/**
	* Carga las notificaciones de adeudos (cada 90 segundos)
	*
	* Interval
	*/
	setInterval( function(){
		loadDebts();
	}, 90000 );
	var debts = $( '.notifications.debts' ),
		debtsList = debts.find( '.dropdown' ),
		debtsBadge = debts.find( '.badge' ),
		debtsURL = $( '#debtsURL' ).val(),
		debtsDetailURL = $( '#debtsDetailURL' ).val();
	function loadDebts(){
		$.ajax({
			url		: debtsURL,
			type	: 'POST',
			success	: function( data ){
				if ( data.estatus && data.estatus == 'EXITO' ){
					var counted = data.adeudos.length;
					debtsBadge.html( counted );
					if ( counted > 0 ){
						debtsBadge.addClass( 'red' );
					}
					else{
						debtsBadge.removeClass( 'red' );
					}
					debtsList.html( '' );
					for ( var i in data.adeudos ){
						var adeudo = data.adeudos[ i ];
						var flag = $( document.createElement( 'i' ) ).addClass( 'fa fa-flag ic' );
						if ( adeudo.vencido == 1 ){
							flag.addClass( 'text-red' );
						}
						else{
							flag.addClass( 'text-yellow' );
						}
						var item = $( document.createElement( 'li' ) );
						var link = $( document.createElement( 'a' ) )
							.attr( 'href', debtsDetailURL + '/' + adeudo.idResidente );
						link.append( $( document.createElement( 'div' ) )
							.append( flag )
							.append( $( document.createElement( 'b' ) ).html( adeudo.idResidente_nombre ) )
							.append( ' tiene un adeudo de $' )
							.append( $( document.createElement( 'b' ) )
								.html( ( parseFloat( adeudo.cantidad ) - parseFloat( adeudo.pagado ) ).toFixed( 2 ) ) ) );
						link.append( $( document.createElement( 'div' ) ).addClass( 'date' )
							.append( adeudo.fechaVence ) );
						debtsList.append( item.append( link ) );
					}
				}
			}
		});
	}
	loadDebts();

	/**
	* Carga las notificaciones de cuentas por pagar (cada 90 segundos)
	*
	* Interval
	*/
	setInterval( function(){
		loadBills();
	}, 90000 );
	var bills = $( '.notifications.bills' ),
		billsList = bills.find( '.dropdown' ),
		billsBadge = bills.find( '.badge' ),
		billsURL = $( '#billsURL' ).val(),
		billsDetailURL = $( '#billsDetailURL' ).val();
	function loadBills(){
		$.ajax({
			url		: billsURL,
			type	: 'POST',
			success	: function( data ){
				if ( data.estatus && data.estatus == 'EXITO' ){
					var counted = data.gastos.length;
					billsBadge.html( counted );
					if ( counted > 0 ){
						billsBadge.addClass( 'red' );
					}
					else{
						billsBadge.removeClass( 'red' );
					}
					billsList.html( '' );
					for ( var i in data.gastos ){
						var cuenta = data.gastos[ i ];
						var flag = $( document.createElement( 'i' ) ).addClass( 'fa fa-flag ic' );
						if ( cuenta.vencido == 1 ){
							flag.addClass( 'text-red' );
						}
						else{
							flag.addClass( 'text-yellow' );
						}
						var item = $( document.createElement( 'li' ) );
						var link = $( document.createElement( 'a' ) )
							.attr( 'href', billsDetailURL + '/' + cuenta.id );
						link.append( $( document.createElement( 'div' ) )
							.append( flag )
							.append( 'Se debe ' )
							.append( $( document.createElement( 'b' ) ).html( cuenta.concepto ) )
							.append( ' la cantidad $' )
							.append( $( document.createElement( 'b' ) )
								.html( ( parseFloat( cuenta.cantidad ) - parseFloat( cuenta.pagado ) ).toFixed( 2 ) ) )
							.append( ' al proveedor ' )
							.append( $( document.createElement( 'b' ) ).html( cuenta.nombreProveedor ) ) );
						link.append( $( document.createElement( 'div' ) ).addClass( 'date' )
							.append( cuenta.fechaVence ) );
						billsList.append( item.append( link ) );
					}
				}
			}
		});
	}
	loadBills();

	/**
	* Asigna el bloqueo a los botones que requieren configuraciones especiales
	*
	* Evento Click (.sp-config)
	*/
	$( 'a.sp-config' ).click( function( ev ){
		var button		= $( this ),
			config		= button.attr( 'data-config' ),
			currents	= $.parseJSON( configurations.val() );
		if ( $.inArray( config, currents ) < 0 ){
			ev.preventDefault();
			messageDisplay( 'No tiene acceso a éste módulo, contacte al proveedor para habilitarlo', 'red' );
		}
	});

	/**
	* Plugin
	*
	* Ejecuta el plugin de scroll en la barra lateral
	*/
	var menu = $( '#menu' );
	if ( menu.length > 0 ){
		menu.mCustomScrollbar();
	}
});

/**
* Envía un mensaje con una ventana modal
*
* Puede ser de error o de exito
*
* @param	string	message		El mensaje a escribir en la ventana modal
* @param	string	status		La clase que tendrá el botón
* @param	string	redirect	Dirección opcional al que puede redirigirse al presionar el botón
*/
function messageDisplay( message, status, redirect ){
	var submits = $( '#submits' );
	submits.find( '.body' ).html( message );
	var button = submits.find( 'button' ).removeClass().addClass( 'close ' + status );
	if ( redirect ){
		button.click( function( ev ){
			ev.preventDefault();
			window.location = redirect;
		});
	}
	submits.deploy();
}