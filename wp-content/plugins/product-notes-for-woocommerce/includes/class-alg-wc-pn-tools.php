<?php
/**
 * Product Notes for WooCommerce - Tools Class
 *
 * @version 2.0.0
 * @since   2.0.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_Product_Notes_Tools' ) ) :

class Alg_WC_Product_Notes_Tools {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function __construct() {
		add_action( 'alg_wc_product_note_settings_after_save', array( $this, 'delete_all_notes' ) );
	}

	/**
	 * delete_all_notes.
	 *
	 * @version 2.0.0
	 * @since   1.1.2
	 *
	 * @todo    [later] query only products with existing note
	 */
	function delete_all_notes() {
		foreach ( array( 'private', 'public' ) as $private_or_public ) {
			if ( 'yes' === get_option( "alg_wc_pn_{$private_or_public}_delete_all", 'no' ) ) {
				foreach ( wc_get_products( array( 'limit' => -1, 'return' => 'ids' ) ) as $product_id ) {
					delete_post_meta( $product_id, '_' . alg_wc_pn()->get_id( $private_or_public ) );
				}
				update_option( "alg_wc_pn_{$private_or_public}_delete_all", 'no' );
				add_action( 'admin_notices', array( $this, "admin_notices_delete_all_notes_{$private_or_public}_success" ), PHP_INT_MAX );
			}
		}
	}

	/**
	 * admin_notices_delete_all_notes_private_success.
	 *
	 * @version 2.0.0
	 * @since   1.1.2
	 */
	function admin_notices_delete_all_notes_private_success() {
		echo '<div class="notice notice-warning is-dismissible"><p><strong>' .
			__( 'All private notes have been deleted.', 'product-notes-for-woocommerce' ) . '</strong></p></div>';
	}

	/**
	 * admin_notices_delete_all_notes_public_success.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function admin_notices_delete_all_notes_public_success() {
		echo '<div class="notice notice-warning is-dismissible"><p><strong>' .
			__( 'All public notes have been deleted.', 'product-notes-for-woocommerce' ) . '</strong></p></div>';
	}

}

endif;

return new Alg_WC_Product_Notes_Tools();
