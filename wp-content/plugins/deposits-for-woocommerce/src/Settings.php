<?php
namespace Deposits_WooCommerce;

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Settings {
	public function __construct() {
		// Validate callback

		$this->pluginOptions();
	}

	public function pluginOptions() {

		// Set a unique slug-like ID
		$prefix = 'deposits_settings';

		//
		// Create options
		\CSF::createOptions( $prefix, array(
			'menu_title'      => 'Deposit Settings',
			'menu_slug'       => 'deposits_settings',
			'framework_title' => 'Bayna - Deposits & Partial Payments for WooCommerce <small>v' . CIDW_DEPOSITS_VERSION . '</small>',
			'menu_type'       => 'submenu',
			'menu_parent'     => 'codeixer',
			'nav'             => 'inline',
			'theme'           => 'light',

			// menu extras
			'show_bar_menu'   => false,
		) );

		// Create a section
		\CSF::createSection( $prefix, array(
			'title'  => 'General Settings',
			'fields' => array(

				// A text field
				array(
					'id'      => 'select_mode',
					'type'    => 'radio',
					'title'   => __( 'Deposit Mode', 'deposits-for-woocommerce' ),
					'options' => array(
						'only_deposits' => __( 'Order only deposit products or regular ones', 'deposits-for-woocommerce' ),
						'allow_mix'     => __( 'Allow Deposit and regular items togather into an order', 'deposits-for-woocommerce' ),

					),
					'default' => 'only_deposits',
				),

				array(
					'id'      => 'bayna_fully_paid_status',
					'type'    => 'select',
					'default' => 'wc-completed',
					'options' => 'cidwOrderStatus',
					'title'   => __( 'Deposit Paid Status', 'deposits-for-woocommerce' ),
					'desc'    => __( 'set order status when deposits are paid', 'deposits-for-woocommerce' ),
				),
				array(
					'id'      => 'cidw_payment_gateway',
					'type'    => 'checkbox',
					'title'   => __( 'Disable Payment Methods	', 'deposits-for-woocommerce' ),
					'options' => 'cidw_payment_gateway_list',
				),

			),
		) );

		//
		// Create a section
		\CSF::createSection( $prefix, array(
			'title'  => 'Text & Labels',
			'fields' => array(
				array(
					'id'         => 'regular_notice',
					'type'       => 'text',
					'title'      => __( 'Regular Products Notice', 'deposits-for-woocommerce' ),
					
					'default'    => 'We detected that your cart has Regular products. Please remove them before being able to add this product.',
				),
				array(
					'id'         => 'deposit_notice',
					'type'       => 'text',
					'title'      => __( 'Deposit Products Notice', 'deposits-for-woocommerce' ),
					
					'default'    => 'We detected that your cart has Deposit products. Please remove them before being able to add this product.',
				),
				array(
					'id'      => 'txt_pay_deposit',
					'type'    => 'text',
					'title'   => __( 'Pay Deposit', 'deposits-for-woocommerce' ),
					'default' => 'Pay Deposit',
					'class'   => 'dfwc-text-field',
				),

				array(
					'id'      => 'txt_full_payment',
					'type'    => 'text',
					'title'   => __( 'Full Payment', 'deposits-for-woocommerce' ),
					'default' => 'Full Payment',
					'class'   => 'dfwc-text-field',
				),

				array(
					'id'          => 'txt_deposit_msg',
					'type'        => 'text',
					'title'       => __( 'Deposit Text', 'deposits-for-woocommerce' ),
					'default'     => 'Deposit : {price} Per item',
					'placeholder' => 'Deposit : {price} Per item',
					'class'       => 'dfwc-text-field',
				),

				array(
					'id'      => 'txt_to_deposit_paid',
					'type'    => 'text',
					'title'   => __( 'Paid', 'deposits-for-woocommerce' ),
					'default' => 'Paid:',
					'class'   => 'dfwc-text-field',
				),

				array(
					'id'      => 'txt_to_pay',
					'type'    => 'text',
					'title'   => __( 'To Pay', 'deposits-for-woocommerce' ),
					'default' => 'To Pay:',
					'class'   => 'dfwc-text-field',
				),
				array(
					'id'      => 'txt_to_deposit',
					'type'    => 'text',
					'title'   => __( 'Deposit', 'deposits-for-woocommerce' ),
					'default' => 'Deposit',
					'class'   => 'dfwc-text-field',
				),
				array(
					'id'      => 'txt_to_due_payment',
					'type'    => 'text',
					'title'   => __( 'Due Payment', 'deposits-for-woocommerce' ),
					'default' => 'Due Payment:',
					'class'   => 'dfwc-text-field',
				),
				array(
					'id'      => 'txt_to_deposit_payment_fee',
					'type'    => 'text',
					'title'   => __( 'Deposit Payment Fee', 'deposits-for-woocommerce' ),
					'default' => 'Deposit Payment for order #',
					'class'   => 'dfwc-text-field',
				),
				array(
					'id'      => 'txt_to_due_payment_fee',
					'type'    => 'text',
					'title'   => __( 'Due Payment Fee', 'deposits-for-woocommerce' ),
					'default' => 'Due Payment for order #',
					'class'   => 'dfwc-text-field',
				),

			),
		) );
		// Create a section
		\CSF::createSection( $prefix, array(
			'title'  => 'Radio Style',
			'fields' => array(

				array(
					'id'      => 'cidw_box_active_color',
					'type'    => 'color',
					'title'   => 'Active Color',
					'default' => '#5cb85c',
				),
				array(
					'id'      => 'cidw_radio_theme',
					'type'    => 'radio',
					'default' => 'p-default p-round p-thick',
					'title'   => __( 'Radio Style', 'deposits-for-woocommerce' ),
					'options' => array(
						'p-default p-round p-thick' => 'Round & Thick & Outline',
						'p-default p-round p-fill'  => 'Round & Fill',
						'p-default p-round'         => 'Round',
						'p-default p-curve p-thick' => 'Curve & Thick & Outline',
						'p-default p-curve'         => 'Curve & Outline',
						'p-default p-thick'         => 'Square & Thick & Outline',
						'p-default p-fill'          => 'Square',
						'p-image p-plain'           => 'Image',
					),
				),
				array(
					'id'           => 'cidw_radio_theme_image',
					'type'         => 'upload',
					'title'        => 'Add Radio Image',
					'library'      => 'image',
					'button_title' => 'Add Image',
					'default'      => CIDW_DEPOSITS_ASSETS . '/img/004.png',
					'remove_title' => 'Remove Image',
					'dependency'   => array( 'cidw_radio_theme', '==', 'p-image p-plain' ),
				),

			),
		) );
	}
}
