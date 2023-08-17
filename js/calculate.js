( function( $ ) {
	$( document ).ready( function() {

		/**
		 * Functional for select
		 * @param select
		 */
		function toggleSelect( select ) {
			var $select = $( select );

			$select.toggleClass( '_active' );
			$select.find( '.select__list' ).slideToggle( 200 );
		}

		$( '.select__result' ).click( function( e ) {
			e.preventDefault();
			var $select = $( this ).parents( '.select' );

			toggleSelect( $select );
		} );

		$( '.select__item' ).click( function( e ) {
			e.preventDefault();

			var $item = $( this ),
				$select = $item.parents( '.select' ),
				value = $item.data( 'value' ) || $item.text();

			$select.find( '.select__result span' ).text( value );
			$select.find( 'input[type="hidden"]' ).val( value );

			toggleSelect( $select );

			ajaxCalculate( this );
		} );

		/**
		 * Functional for calculate
		 * @param select
		 */
		$( '.calculate__form' ).on( 'input keyup', 'input', function( e ) {
			ajaxCalculate( this );
		} );

		function ajaxCalculate( self ) {
			var $form = $( self ).parents( 'form' ),
				$result = $( '.calculate__result span', $form );

			$.ajax( {
				url: '/wp-admin/admin-ajax.php',
				data: $form.serialize() + '&action=ticket_ajax_calculate',
				type: 'POST',
			} ).done( function( result ) {
				if ( result.success && result.data ) {
					$result.text( result.data.result );
				}
			} );
		}

	} );
} )( jQuery );