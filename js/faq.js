( function( $ ) {
	$( document ).ready( function() {
		$( '.faq__item' ).click( function( e ) {
			e.preventDefault();

			var $item = $( this ),
				$body = $item.find('.faq__item-body');

			if ( $item.hasClass( '_active' ) ) {
				$item.removeClass( '_active' );
				$body.slideUp( 200 );
			} else {
				$( '.faq__item-body' ).slideUp( 200 );

				$item.addClass( '_active' ).siblings().removeClass( '_active' );
				$body.slideDown( 200 );
			}
		} );
	} );
} )( jQuery );