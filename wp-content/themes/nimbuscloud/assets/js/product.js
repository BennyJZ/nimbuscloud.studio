/**
 * Product page enhancements.
 *
 * Deliberately minimal: WooCommerce already handles variation switching and
 * AJAX cart. This only reacts to Woo's own events rather than re-implementing
 * them, which is what keeps the theme compatible across Woo versions.
 */
( function () {
	'use strict';

	if ( typeof jQuery === 'undefined' ) {
		return;
	}

	jQuery( function ( $ ) {
		var $form = $( '.variations_form' );

		// Surface the matched variation's SKU/stock without replacing Woo's own UI.
		$form.on( 'found_variation', function ( event, variation ) {
			if ( variation && variation.sku ) {
				$( '.product_meta .sku' ).text( variation.sku );
			}
		} );

		// Keep the header bubble honest after an AJAX add-to-cart.
		$( document.body ).on( 'added_to_cart', function () {
			$( '.cart-count' ).removeAttr( 'hidden' );
		} );
	} );
}() );
