/**
* Plugin de datepicker
*
* @author	isaac
* @version	1
*/
;( function( $, document ){
	/**
	* Clase para generar el datepicker
	*/
	function inndate( obj, options ){
		/**
		* Opciones de la instancia del plugin
		*
		* @var	object
		*/
		var options = $.extend( {}, {
			useDate		:	true,
			useTime		:	false,
			months		:	[ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
			week		:	[ [ 'Dom', 'Domingo' ], [ 'Lun', 'Lunes' ], [ 'Mar', 'Martes' ], [ 'Mie', 'Miércoles' ], [ 'Jue', 'Jueves' ], [ 'Vie', 'Viernes' ], [ 'Sab', 'Sábado' ] ],
			yearStart	:	2000,
			yearEnd		:	2030,
			times		:	[ 'Hora', 'Min', 'Seg' ],
			dateOrder	:	[ 'day', 'month', 'year' ],
			timeOrder	:	[ 'hour', 'minutes', 'seconds' ]
		}, options );

		/**
		* Contenedor del plugin
		*
		* @var	jQueryObject
		*/
		var picker;

		/**
		* Select que contiene el mes seleccionado
		*
		* @var	jQueryObject
		*/
		var monthPicker;

		/**
		* Select que contiene el año seleccionado
		*
		* @var	jQueryObject
		*/
		var yearPicker;

		/**
		* Input que contiene la hora seleccionada
		*
		* @var	jQueryObject
		*/
		var hourInput;

		/**
		* Input que contiene los minutos seleccionados
		*
		* @var	jQueryObject
		*/
		var minutesInput;

		/**
		* Input que contiene los segundos seleccionados
		*
		* @var	jQueryObject
		*/
		var secondsInput;

		/**
		* Día actualmente seleccionado
		*
		* @var	int
		*/
		var currentDay;

		/**
		* Fecha del día de hoy
		*
		* @var	Date
		*/
		var today;

		/**
		* Fecha seleccionda actualmente
		*
		* @var	Date
		*/
		var current;

		/**
		* Fecha desplegada actualmente
		*
		* @var	Date
		*/
		var displayed;

		/**
		* La fecha actualmente seleccionada en un objeto desordenado
		*
		* @var	object
		*/
		var datetime;

		/**
		* Constructor
		*
		* Inicizaliza el plugin y establece los eventos
		*/
		this.construct = function(){
			picker = $( document.createElement( 'div' ) ).addClass( 'inndate-container' );
			if ( options.useDate ){
				picker.html( '<div class="inndate-monthYear"><select class="inndate-month"></select><select class="inndate-year"></select></div><table><thead></thead><tbody class="inndate-calendar"></tbody></table>' );
				monthPicker = picker.find( '.inndate-month' );
				yearPicker = picker.find( '.inndate-year' );
				for ( var i in options.week ){
					picker.find( 'thead' ).append( $( document.createElement( 'th' ) ).attr( 'title', options.week[ i ][ 1 ] ).html( options.week[ i ][ 0 ] ) );
				}
				for ( var i in options.months ){
					monthPicker.append( $( document.createElement( 'option' ) ).attr( 'value', i ).html( options.months[ i ] ) );
				}
				for ( var i = options.yearStart; i <= options.yearEnd; i++ ){
					yearPicker.append( $( document.createElement( 'option' ) ).attr( 'value', i ).html( i ) );
				}
			}
			if ( options.useTime ){
				picker.append( '<div class="inndate-timer"><div class="inndate-timeTitles"></div><input type="text" class="inndate-hour" /><input type="text" class="inndate-minutes" /><input type="text" class="inndate-seconds" /></div>' );
				hourInput = picker.find( '.inndate-hour' );
				minutesInput = picker.find( '.inndate-minutes' );
				secondsInput = picker.find( '.inndate-seconds' );
				for ( var i in options.times ){
					picker.find( '.inndate-timeTitles' ).append( $( document.createElement( 'span' ) ).html( options.times[ i ] ) );
				}
			}
			today = current = displayed = new Date();
			obj.focus( function(){
				$( '.inndate-container' ).hide();
				var objPosition = obj.offset();
				var pickerHeight = picker.outerHeight();
				var objHeight = obj.outerHeight();
				if ( ( objPosition.top + objHeight + pickerHeight ) >= $( window ).height() && objPosition.top > pickerHeight ){
					picker.css( 'top', ( objPosition.top - pickerHeight - 6 ) );
				}
				else {
					picker.css( 'top', ( objPosition.top + objHeight ) );
				}
				picker.css( 'left', objPosition.left ).show();
				display( current );
				picker.show();
			});
			picker.on( 'click', '.selectable', function(){
				currentDay = $( this ).html();
				setCurrent();
				obj.val( getCurrent() );
				picker.hide();
			});
			monthPicker.change( function(){
				displayed = new Date( displayed.getTime() );
				displayed.setMonth( monthPicker.val() );
				display( displayed );
			});
			yearPicker.change( function(){
				displayed = new Date( displayed.getTime() );
				displayed.setFullYear( yearPicker.val() );
				display( displayed );
			});
			picker.find( '.inndate-timer input' ).keyup( function( ev ){
				if ( ev.keyCode == 13 ){
					setCurrent();
					obj.val( getCurrent() );
					picker.hide();
				}
			});
			$( 'body' ).append( picker );
			$( document ).click( function(){
				picker.hide();
			});
			obj.click( function( ev ){
				ev.stopPropagation();
			});
			picker.click( function( ev ){
				ev.stopPropagation();
			});
		}

		/**
		* Despliega el calendario
		*
		* @param	Date	date	La fecha a desplegar en el calendario
		* @access	private
		*/
		var display = function( date ){
			if ( options.useDate ){
				var parts = {
					year	:	date.getFullYear(),
					month	:	date.getMonth(),
					day		:	date.getDate()
				}
				var weekday = new Date( parts.year, parts.month, 1 ).getDay();
				var days = new Date( parts.year, ( parts.month + 1 ), 0 ).getDate() + weekday;
				var calendar = picker.find( 'table tbody' ).html( '' );
				for ( var i = 0; i < days; i++ ){
					var row;
					if ( i % 7 == 0 || i == 0 ){
						row = $( document.createElement( 'tr' ) );
						calendar.append( row );
					}
					var day = $( document.createElement( 'td' ) );
					if ( i >= weekday ){
						var value = ( i - weekday + 1 )
						day.addClass( 'selectable' ).html( value );
						if ( current.getFullYear() == parts.year && current.getMonth() == parts.month && current.getDate() == value ){
							day.addClass( 'act' );
						}
					}
					row.append( day );
				}
				monthPicker.val( parts.month );
				yearPicker.val( parts.year );
			}
			if ( options.useTime ){
				hourInput.val( date.getHours() );
				minutesInput.val( date.getMinutes() );
				secondsInput.val( date.getSeconds() );
			}
		}

		/**
		* Establece la fecha actualmente seleccionada
		*
		* @access	private
		*/
		var setCurrent = function(){
			datetime = {
				year	:	yearPicker ? yearPicker.val() : today.getMonth(),
				month	:	monthPicker ? monthPicker.val() : today.getFullYear(),
				day		:	currentDay ? currentDay : today.getDate(),
				hour	:	hourInput ? hourInput.val() : 0,
				minutes	:	minutesInput ? minutesInput.val() : 0,
				seconds	:	secondsInput ? secondsInput.val() : 0
			};
			current = new Date( datetime.year, datetime.month, datetime.day, datetime.hour, datetime.minutes, datetime.seconds );
		}

		/**
		* Devuelve una cadena formateada de la fecha seleccionada
		*
		* @access	private
		* @return	string
		*/
		var getCurrent = function(){
			var results = '';
			if ( options.useDate ){
				for ( var i in options.dateOrder ){
					switch ( options.dateOrder[ i ] ){
						case 'year':
							results += datetime.year + '-';
							break;
						case 'month':
							results += parseInt( datetime.month ) + 1 + '-';
							break;
						case 'day':
							results += datetime.day + '-';
							break;
					}
				}
				results = results.slice( 0, -1 );
			}
			if ( options.useTime ){
				results += ' ';
				for ( var i in options.timeOrder ){
					var data = datetime[ options.timeOrder[ i ] ];					
					data = data.length < 2 ? '0' + data : data;
					results += data + ':';
				}
				results = results.slice( 0, -1 );
			}
			return results;
		}
	}

	/**
	* Función para añadir como extensión de jquery
	*/
	$.fn.inndate = function( options ){
		return this.each( function(){
			var obj = $( this );
			if ( !obj.data( 'inndate' ) ){
				obj.data( 'inndate', new inndate( obj, options ) ) 
			}
			obj.data( 'inndate' ).construct();
		});
	}
})( jQuery, document );