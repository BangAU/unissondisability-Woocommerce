<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */


 // Display a custom setting option on product edit pages
add_action('woocommerce_product_options_general_product_data', 'add_product_repeater_checkbox_option');
function add_product_repeater_checkbox_option(){
    echo '<div class="product_custom_field">';

    // Custom Product Checkbox Field
    woocommerce_wp_checkbox( array(
        'id'          => '_qty_repeater',
        'label'       => __('Qty repeater', 'woocommerce'),
        'description' => __('Enable quantity repeater for additional "Name" and "Email" billing checkout fields', 'woocommerce'),
        'desc_tip'    => 'true'
    ));

    echo '</div>';
}

// Save the custom setting option value from product edit pages
add_action( 'woocommerce_admin_process_product_object', 'save_product_repeater_checkbox_option', 100, 1 );
function save_product_repeater_checkbox_option( $product ) {
    $qty_repeater = isset( $_POST['_qty_repeater'] ) ? 'yes' : 'no';
    $product->update_meta_data( '_qty_repeater', $qty_repeater );
}



add_filter('woocommerce_billing_fields', 'additional_billing_checkout_fields', 50, 1 );
function additional_billing_checkout_fields( $billing_fields ) {
    foreach(WC()->cart->get_cart() as $cart_item ){
        // Check if the "Quanty repeater option is set for the current item
        if( $cart_item['data']->get_meta('_qty_repeater') === 'yes' && is_checkout() && $cart_item['quantity'] > 1 ) {

            // Quantity repeater
            for( $i = 1, $j = 2; $i < $cart_item['quantity']; $i++, $j++ ){

                // Name fields
                $billing_fields['billing_name_person'.$j] = array(
                    'type'        => 'text',
                    'label'       => __("Name", "woocommerce") . ' ' . $j,
                    'class'       => array('form-row-first'),
                    'required'    => true,
                    'clear'       => false,
                );

                // Email fields
                $billing_fields['billing_email_person'.$j] = array(
                    'type'        => 'email',
                    'label'       => __("Email", "woocommerce") . ' ' . $j,
                    'class'       => array('form-row-last'),
                    'required'    => true,
                    'clear'       => true,
                );
            }
            break; // Only for one item
        }
    }
    return $billing_fields;
}

// Mark Order as having this additional fields data values
add_action('woocommerce_checkout_create_order', 'save_additional_billing_checkout_fields', 20, 2);
function save_additional_billing_checkout_fields( $order, $data ) {
    foreach( $order->get_items() as $item ){
        $product = $item->get_product();
        // Mark the order as containing additional fields
        if( $product->get_meta('_qty_repeater') === 'yes' && $item->get_quantity() > 1 ) {
            $item->update_meta_data( '_qty_repeater', '1' );
            break; // Stop the loop
        }
    }
}


// Display additional billing fields values
add_action('woocommerce_order_details_after_order_table', 'display_additional_billing_fields_values' ); // Order received and view
add_action( 'woocommerce_email_after_order_table', 'display_additional_billing_fields_values' ); // Email notifications
add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_additional_billing_fields_values' ); // Admin edit Order
function display_additional_billing_fields_values( $order ) {

    if( $order->get_meta('_qty_repeater') ) {
        // Only for email notifications
        if( ! ( is_wc_endpoint_url() || is_checkout() || is_admin() ) ){
            echo '<style>
            table.customer-details {width: 100%; font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
                color: #737373; border: 1px solid #e4e4e4; margin-bottom:40px;}
            table.customer-details td{text-align: left; border-top-width: 4px; color: #737373; border: 1px solid #e4e4e4;
                padding: 12px; padding-bottom: 4px;}
            </style>';
        }
        // Others
        else {
            echo '<style> table.customer-details, table.customer-details td { border: none; } </style>';
        }

        echo '<h2>' . __( 'Customer details', 'woocommerce' ) . '</h2>';
        echo '<div><table class="customer-details" cellspacing="0">';

        // Loop through order items
        foreach( $order->get_items() as $item ){
            $product = $item->get_product();
            if( $product->get_meta('_qty_repeater') === 'yes' ) {
                // Loop through item quantity
                for( $i = 1, $j = 2; $i < $item->get_quantity(); $i++, $j++ ){
                    // Name
                    echo '<tr><td><strong>' . __("Name", "woocommerce") . ' ' . $j;
                    echo ': </strong>' . $order->get_meta('_billing_name_person'.$j) . '</td>';
                    // Email
                    echo '<td><strong>' . __("Email", "woocommerce") . ' ' . $j;
                    echo ': </strong>' . $order->get_meta('_billing_email_person'.$j) . '</td></tr>';
                }
                break;
            }
        }
        echo '</table></div>';
    }
}


add_filter( 'woocommerce_admin_billing_fields' , 'additional_admin_editable_billing_fields' );
function additional_admin_editable_billing_fields( $fields ) {
    global $pagenow, $post;

    if( $pagenow != 'post.php' ) return $fields;

    $order = wc_get_order($post->ID);

    if( $order->get_meta('_qty_repeater') ) {
        // Loop through order items
        foreach( $order->get_items() as $item ){
            $product = $item->get_product();
            if( $product->get_meta('_qty_repeater') === 'yes' ) {
                // Loop through item quantity
                for( $i = 1, $j = 2; $i < $item->get_quantity(); $i++, $j++ ){
                    $fields['name_person'.$j] = array(
                        'label'         => __("Name", "woocommerce") . ' ' . $j,
                        'show'          => false,
                        'wrapper_class' => 'first',
                    );
                    $fields['email_person'.$j] = array(
                        'label'         => __("Email", "woocommerce") . ' ' . $j,
                        'show'          => false,
                        'wrapper_class' => 'last',
                    );
                }
                break;
            }
        }
    }
    return $fields;
}