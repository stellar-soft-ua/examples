jQuery(document).ready(function($){ 

	// Marketo Form Checkbox Detection...
		var MktoForms = $( 'script[src$=".marketo.com/js/forms2/js/forms2.min.js"]+form' ).each( function() {
			var ThisForm = $( this );
			var ThisTimer = window.setInterval( function() {
				if( ThisForm.children().length ) {
					ThisForm.find( 'input[type="checkbox"].mktoField' ).parents( '.mktoFormRow' ).addClass( 'mktoHasCheckboxes' );
					clearInterval( ThisTimer );
				}
			}, 100 );
		} );
var MktoFormWatchers = [];
	jQuery( 'form[id^="mktoForm_"]' ).each( function( i ) {

		var ThisForm = jQuery( this );
		MktoFormWatchers[ i ] = setInterval( function() {
			if( ThisForm.find( '> *' ).length ) {

				ThisForm.on( 'change', function() {
					setTimeout( function() {
						var MktoRows = ThisForm.find( '.mktoFormRow' );
						jQuery.each( MktoRows, function() {
							var ThisRow = jQuery( this );
							if( ThisRow.find( 'div.mktoFormCol' ).length ) {
								ThisRow.removeClass( 'hidden-field' );
							} else {
								ThisRow.addClass( 'hidden-field' );
							}
						} );
					}, 10 );
				} ).trigger( 'change' );

				clearInterval( MktoFormWatchers[ i ] );

			}
		}, 10 );

	} );

	var FormListener = window.setInterval( function() {
		jQuery( 'form[id^="mktoForm_"]' ).each( function( i ) {

			jQuery( '#mktoForms2BaseStyle' ).remove();
			jQuery( '#mktoForms2ThemeStyle' ).remove();

			jQuery( this ).attr( 'style', '' );
			jQuery( this ).find( 'style' ).remove();
			jQuery( this ).find( '*' ).attr( 'style', '' );

		} );
	}, 1000 );
});