<?php

namespace Deposits_WooCommerce;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Cart {
    public function __construct() {
        add_action( 'woocommerce_cart_totals_after_order_total', [$this, 'to_pay_html'] );
        add_filter( 'woocommerce_cart_item_name', [$this, 'display_cart_item_deposit_data'], 10, 3 );
        add_filter( 'woocommerce_add_cart_item_data', [$this, 'cart_item_data'], 20, 3 );
        add_filter( 'woocommerce_cart_totals_order_total_html', [$this, 'cart_total_html'], 10, 1 );
        add_filter( 'woocommerce_calculated_total', [$this, 'recalculate_price'], 100, 2 );

    }

    /**
     *
     * Add the deposit field as item data to the cart object
     * @since 1.0.0
     *
     * @param Array   $cart_item_data Cart item meta data.
     * @param Integer $product_id     Product ID.
     */
    public function cart_item_data( $cart_item_data, $product_id, $variation_id ) {
        $vProductId = ( $variation_id ) ? $variation_id : $product_id;
        if ( cidw_is_product_type_deposit( $vProductId ) == false || !isset( $_POST['deposit-mode'] ) ) {
            return $cart_item_data;
        }

        $product = wc_get_product( $vProductId );

        $deposit_value = apply_filters( 'deposits_value', get_post_meta( $vProductId, '_deposits_value', true ) );

        if ( apply_filters( 'deposits_type', get_post_meta( $vProductId, '_deposits_type', true ) ) == 'percent' ) {
            $deposit_value = ( $deposit_value / 100 ) * $product->get_price();
        }

        $cart_item_data['_deposit']      = $deposit_value;
        $cart_item_data['_due_payment']  = $product->get_price() - $deposit_value;
        $cart_item_data['_deposit_mode'] = sanitize_text_field( $_POST['deposit-mode'] );

        return $cart_item_data;
    }

    /**
     * @param $cart_total
     */
    public function cart_total_html( $cart_total ) {

        $cartTotal = WC()->cart->total;
        // Loop over $cart items
        $depositValue = 0; // no value
        $dueValue     = 0; // no value
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $vProductId = ( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : $cart_item['product_id'];
            $depositValue += ( cidw_is_product_type_deposit( $vProductId ) && isset( $cart_item['_deposit_mode'] ) && $cart_item['_deposit_mode'] == 'check_deposit' ) ? $cart_item['_deposit'] * $cart_item['quantity'] : null;
            $dueValue += ( cidw_is_product_type_deposit( $vProductId ) && isset( $cart_item['_deposit_mode'] ) && $cart_item['_deposit_mode'] == 'check_deposit' ) ? $cart_item['_due_payment'] * $cart_item['quantity'] : null;
        }

        $value = $cartTotal + $dueValue;

        return '<strong>' . wc_price( $value ) . '</strong>';
    }

    /**
     * Display the Deposit Data as item data
     */
    public function display_cart_item_deposit_data( $name, $cart_item, $cart_item_key ) {
        if ( isset( $cart_item['_deposit'] ) && is_cart() && isset( $cart_item['_deposit_mode'] ) && $cart_item['_deposit_mode'] == 'check_deposit' ) {
            $cart_item['_deposit']     = $cart_item['_deposit'] * $cart_item['quantity'];
            $cart_item['_due_payment'] = $cart_item['_due_payment'] * $cart_item['quantity'];

            $name .= sprintf(
                '<p>' . apply_filters( 'label_deposit', __( 'Deposit:', 'deposits-for-woocommerce' ) ) . ' %s <br> ' . apply_filters( 'label_due_payment', __( 'Due Payment:', 'deposits-for-woocommerce' ) ) . ' %s</p>',
                wc_price( $cart_item['_deposit'] ),
                wc_price( $cart_item['_due_payment'] )
            );

            return $name;
        }

        return $name;
    }

    /**
     * @param  $total
     * @param  $cart
     * @return mixed
     */
    public function recalculate_price( $total, $cart ) {
        // Loop over $cart items
        $cart_item_total = 0; // no value
        $depositValue    = 0; // no value
        $dueValue        = 0; // no value

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $vProductId = ( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : $cart_item['product_id'];
            $depositValue += ( cidw_is_product_type_deposit( $vProductId ) && isset( $cart_item['_deposit_mode'] ) && $cart_item['_deposit_mode'] == 'check_deposit' ) ? $cart_item['_deposit'] * $cart_item['quantity'] : null;
            $dueValue += ( cidw_is_product_type_deposit( $vProductId ) && isset( $cart_item['_deposit_mode'] ) && $cart_item['_deposit_mode'] == 'check_deposit' ) ? $cart_item['_due_payment'] * $cart_item['quantity'] : null;
            $cart_item_total += $cart_item['data']->get_price() * $cart_item['quantity'];
        }

        return $total - $dueValue;
    }

    /**
     * Dispaly Deposit amount to know user how much need to pay.
     */
    public function to_pay_html() {
        if ( cidw_cart_have_deposit_item() ) {
            cidw_display_to_pay_html();
        }
    }

}
