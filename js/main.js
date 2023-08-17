( function( $ ) {
	$( document ).ready( function() {

		$( '.header__mobile_toggle' ).click( function( e ) {
			e.preventDefault();

			$('.header__menu').slideToggle(200);
		} );

	} );
} )( jQuery );