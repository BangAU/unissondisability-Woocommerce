<?php

namespace Deposits_WooCommerce;

use Deposits_WooCommerce\Integrations\Wcmp;

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Bootstrap {
	public function __construct() {

		add_action( 'init', [$this, 'register_order_type'] );
		add_action( 'init', [$this, 'override_hooks'] );

		add_action( 'woocommerce_register_shop_order_post_statuses', [$this, 'shop_order_status'], 10, 1 );
		add_filter( 'wc_order_statuses', [$this, 'shows_order_status'] );
		add_action( 'wp_ajax_variation_toggle', [$this, 'variation_toggle'] );
		add_action( 'wp_ajax_nopriv_variation_toggle', [$this, 'variation_toggle'] );
		add_action( 'admin_init', array( 'PAnD', 'init' ) );
		add_action( 'admin_notices', [$this, 'sdo_notice'] );

		$this->loadClasses();
	}
	/**
	 * @return null
	 */
	function sdo_notice() {
		if ( !\PAnD::is_admin_notice_active( 'sdo-notice-20' ) ) {
			return;
		}

		?>
		<div data-dismissible="sdo-notice-20" class="updated notice notice-success is-dismissible ciplugin-offer notice">

			<p>Thanks for using our free version of <strong>Bayna - Deposits & Partial Payments for WooCommerce</strong> plugin. We have a special limited discount for those who have downloaded the free version and want to go pro. Click this link for <a href="https://www.codeixer.com/bayna-upgrade-discount" class="href" target="_blank">upgrading to PRO</a>.
		</div>
		<?php
}
	// load plugin classes
	public function loadClasses() {
		new Checkout(); // Checkout
		new Order(); // Checkout
		new Product(); // Single Product
		new Cart(); // Cart
		new Emails(); // Emails
		new Settings(); // Settings
		new SubMenu();
		new Deposit_Colums();
		new Wcmp();

		$this->set_admin_settings();
	}

	public function override_hooks() {
		remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );

	}

	/**
	 * Ajax option for adding deposits value into product
	 * on Variation Toggle
	 * @since 2.0.3
	 *
	 * @return void
	 */
	public function variation_toggle() {
		if ( !DOING_AJAX ) {
			wp_die();
		} // Not Ajax

		// Check for nonce security
		$nonce = $_POST['nonce'];

		if ( !wp_verify_nonce( $nonce, 'deposits_nonce' ) ) {
			wp_die( 'oops!' );
		}

		$variationID = absint( $_POST['product_id'] );
		$vProduct    = wc_get_product( $variationID );
		if ( cidw_is_product_type_deposit( $variationID ) ) {
			$deposit_type  = apply_filters( 'deposits_type', get_post_meta( $variationID, '_deposits_type', true ) );
			$deposit_value = apply_filters( 'deposits_value', get_post_meta( $variationID, '_deposits_value', true ) );
			if ( $deposit_type == 'percent' ) {
				$deposit_value  = ( $deposit_value / 100 ) * $vProduct->get_price();
				$deposit_amount = $deposit_value;
			} else {
				$deposit_amount = $deposit_value;
			}

			$deposit_text = apply_filters( 'single_product_deposits_notice', cidw_get_option( 'txt_deposit_msg', 'Deposit : %s Per item' ), wc_price( $deposit_amount ) );?>
            <div class="deposits-frontend-wrapper">
            <p class="deposit-notice"><?php echo $deposit_text; ?></p>
 			<div class="deposits-input-wrapper">	
			<div class="pretty <?php echo esc_attr( cidw_get_option( 'cidw_radio_theme' ) ); ?>">
                <input type="radio" name="deposit-mode" value="check_full" >
                <div class="state p-primary-o">
            <?php if ( cidw_get_option( 'cidw_radio_theme' ) == 'p-image p-plain' ) {
				echo '<img class="image" src="' . cidw_get_option( 'cidw_radio_theme_image' ) . '">';
			}?>

                    <label><?php echo esc_html( cidw_get_option( 'txt_full_payment', 'Full Payment' ) ); ?></label>
                </div>
            </div>

            <div class="pretty <?php echo esc_attr( cidw_get_option( 'cidw_radio_theme' ) ); ?>">
                <input type="radio" name="deposit-mode" value="check_deposit" <?php echo ( $deposit_value || isset( $_POST['deposit-mode'] ) && $_POST['deposit-mode'] == 'check_deposit' || !isset( $_POST['deposit-mode'] ) ) ? 'checked' : '' ?>>
                <div class="state p-primary-o">
            <?php if ( cidw_get_option( 'cidw_radio_theme' ) == 'p-image p-plain' ) {
				echo '<img class="image" src="' . cidw_get_option( 'cidw_radio_theme_image' ) . '">';
			}?>

                    <label><?php echo esc_html( cidw_get_option( 'txt_pay_deposit', 'Pay Deposit' ) ); ?></label>
                </div>
            </div>
			</div>

            

            <span style="margin-bottom:15px;display: block;"></span>
            </div>

            <?php

		}

		// RIP
		wp_die();
	}

	/**
	 * Plugin settings options
	 *
	 * @return void
	 */
	public function set_admin_settings() {
		if ( cidw_get_option( 'select_mode' ) == 'allow_mix' ) {
			add_filter( 'deposits_mode', '__return_false', 10 );
		}
		// Text & labels start
		add_filter( 'single_product_deposits_notice', function ( $message, $price ) {
			$message = cidw_get_option( 'txt_deposit_msg', 'Deposit : %s Per item' );
			return replaceDepositText( $message, $price );
		}, 10, 2 );

		add_filter( 'label_deposit_paid', function ( $message ) {
			$message = cidw_get_option( 'txt_to_deposit_paid', 'Paid:' );
			return $message;
		} );
		add_filter( 'label_due_payment', function ( $message ) {
			$message = cidw_get_option( 'txt_to_due_payment', 'Due Payment:' );
			return $message;
		} );

		add_filter( 'label_deposit', function ( $message ) {
			$message = cidw_get_option( 'txt_to_deposit', 'Deposit:' );
			return $message;
		} );

		// Text & labels end
	}

	/**
	 * register post type for deposit
	 *
	 * @return void
	 */
	public function register_order_type() {
		wc_register_order_type(
			'shop_deposit',
			array(
				'labels'                           => array(
					'name'      => __( 'Deposit Payments', 'deposits-for-woocommerce' ),
					'menu_name' => _x( 'Deposit Payments', 'Admin menu name', 'deposits-for-woocommerce' ),
				),
				'description'                      => __( 'This is where store Deposit Payments are stored.', 'deposits-for-woocommerce' ),
				'public'                           => false,
				'show_ui'                          => true,
				'capability_type'                  => 'shop_order',
				'map_meta_cap'                     => true,
				'publicly_queryable'               => false,
				'exclude_from_search'              => true,
				'show_in_menu'                     => current_user_can( 'manage_woocommerce' ) ? 'woocommerce' : true,
				'hierarchical'                     => false,
				'show_in_nav_menus'                => false,
				'capabilities'                     => array(
					'create_posts' => 'do_not_allow',
				),
				'query_var'                        => false,
				'supports'                         => array( 'title', 'custom-fields' ),
				'has_archive'                      => false,

				// wc_register_order_type() params
				'exclude_from_orders_screen'       => true,
				'add_order_meta_boxes'             => true,
				'exclude_from_order_count'         => true,
				'exclude_from_order_views'         => true,
				'exclude_from_order_webhooks'      => true,
				'exclude_from_order_reports'       => true,
				'exclude_from_order_sales_reports' => false,
				//   'class_name'                       => 'ShopDeposit',

			)
		);
	}

	/**
	 * add deposit order sattus for Order post type
	 *
	 * @param  [array] $statuses
	 * @return void
	 */
	public function shop_order_status( $statuses ) {
		$statuses['wc-deposit'] = [
			'label'                     => _x( 'Deposit Payment', 'Order status', 'deposits-for-woocommerce' ),
			'public'                    => false,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			/* translators: %s: number of orders */
			'label_count'               => _n_noop( 'Deposit Payment <span class="count">(%s)</span>', 'Deposit Payment <span class="count">(%s)</span>', 'deposits-for-woocommerce' ),
		];

		return $statuses;
	}

	/**
	 * @param  $order_statuses
	 * @return mixed
	 */
	public function shows_order_status( $order_statuses ) {
		$order_statuses['wc-deposit'] = _x( 'Deposit Payment', 'Order status', 'deposits-for-woocommerce' );
		return $order_statuses;
	}
}