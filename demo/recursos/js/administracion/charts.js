$( document ).ready( function(){
	// ultimos tres meses de pagos
	var pagosMesesInfo = $.parseJSON( $( '#pagosMesesInfo' ).val() ), meses = [], data = [];
	for ( var i in pagosMesesInfo ){
		meses.push( getMonth( pagosMesesInfo[ i ].mes ) );
		data.push( pagosMesesInfo[ i ].total );
	}
	var pagosMeses = new Chart( document.getElementById( 'pagosMeses' ).getContext( '2d' ) ).Bar({
		labels : meses,
		datasets : [
			{
				label: 'Aportaciones Recibidas en los Últimos Tres Meses',
				fillColor: "rgba(70,191,189,0.5)",
				strokeColor: "rgba(70,191,189,0.8)",
				highlightFill: "rgba(70,191,189,0.75)",
				highlightStroke: "rgba(70,191,189,1)",
				data: data
			}
		]
	});

	// ultimos tres meses de egresos
	var egresosMesesInfo = $.parseJSON( $( '#egresosMesesInfo' ).val() ), meses = [], data = [];
	for ( var i in egresosMesesInfo ){
		meses.push( getMonth( egresosMesesInfo[ i ].mes ) );
		data.push( egresosMesesInfo[ i ].total );
	}
	var egresosMeses = new Chart( document.getElementById( 'egresosMeses' ).getContext( '2d' ) ).Bar({
		labels : meses,
		datasets : [
			{
				label: 'Pagos Realizados en los Últimos Tres Meses',
				fillColor: "rgba(217,83,79,0.5)",
				strokeColor: "rgba(217,83,79,0.8)",
				highlightFill: "rgba(217,83,79,0.75)",
				highlightStroke: "rgba(217,83,79,1)",
				data: data
			}
		]
	});

	//ocupación de lotes
	var ocupacionInfo = $.parseJSON( $( '#ocupacionInfo' ).val() );
	var ocupacion = new Chart( document.getElementById( 'ocupacion' ).getContext( '2d' ) ).Pie([
		{
			value: parseInt( ocupacionInfo[ 0 ].vacias ),
			color:"#F7464A",
			highlight: "#FF5A5E",
			label: "Deshabitadas"
		},
		{
			value: parseInt( ocupacionInfo[ 0 ].habitadas ),
			color: "#46BFBD",
			highlight: "#5AD3D1",
			label: "Habitadas"
		}
	]);

	//adeudos en el mes
	var adeudosInfo = $.parseJSON( $( '#adeudosInfo' ).val() );
	if ( adeudosInfo.length > 0 ){
		var adeudos = new Chart( document.getElementById( 'adeudos' ).getContext( '2d' ) ).Pie([
			{
				value: parseInt( adeudosInfo[ 0 ].programado ),
				color:"#F7464A",
				highlight: "#FF5A5E",
				label: "Pendiente por Pagar"
			},
			{
				value: parseInt( adeudosInfo[ 0 ].pagado ),
				color: "#46BFBD",
				highlight: "#5AD3D1",
				label: "Pagos Realizados"
			}
		]);
	}	
});

function getMonth( month ){
	return month
		.replace( /^1$/g, 'Enero' ).replace( /2/g, 'Febrero' ).replace( /3/g, 'Marzo' )
		.replace( /4/g, 'Abril' ).replace( /5/g, 'Mayo' ).replace( /6/g, 'Junio' )
		.replace( /7/g, 'Julio' ).replace( /8/g, 'Agosto' ).replace( /9/g, 'Septiembre' )
		.replace( /10/g, 'Octubre' ).replace( /11/g, 'Noviembre' ).replace( /12/g, 'Diciembre' )
}