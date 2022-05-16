<?php
add_filter( 'woocommerce_order_item_name', 'display_product_title_as_link', 10, 2 );
	function display_product_title_as_link( $item_name, $item ) {

		$_product = get_product( $item['variation_id'] ? $item['variation_id'] : $item['product_id'] );
		
		$link = get_permalink( $_product->id );

		$_var_description ='';

		if ( $item['variation_id'] ) {
			$_var_description = $_product->get_variation_description();
		}

		return '<a href="'. $link .'"  rel="nofollow">'. $item_name .'</a><br>'. $_var_description ;
}


//Display Fields in admin on product edit screen
// add_action( 'woocommerce_product_after_variable_attributes', 'woo_variable_fields', 10, 3 );

// //Save variation fields values
// add_action( 'woocommerce_save_product_variation', 'save_variation_fields', 10, 2 );

// // Create new fields for variations
// function woo_variable_fields( $loop, $variation_data, $variation ) {

// echo '<div class="variation-custom-fields">';

//   // Text Field
//   woocommerce_wp_text_input( 
//     array( 
//       'id'          => '_text_field['. $loop .']', 
//       'label'       => __( 'additional fees (e.g. monthly fee)', 'woocommerce' ), 
//       'placeholder' => '',
//       //'desc_tip'    => true,
//       'wrapper_class' => 'form-row form-row-first',
//       //'description' => __( 'Enter the custom value here.', 'woocommerce' ),
//       'value'       => get_post_meta($variation->ID, '_text_field', true)
//     )
//   );

// echo "</div>"; 

// }

// // Save custom field value in cart item
// add_filter( 'woocommerce_add_cart_item_data', 'save_custom_field_in_cart_object', 30, 3 );
// function save_custom_field_in_cart_object( $cart_item_data, $product_id, $variation_id ) {

//     // Get the correct Id to be used
//     $the_id = $variation_id > 0 ? $variation_id : $product_id;

//     if( $value = get_post_meta( $the_id, '_text_field', true ) )
//         $cart_item_data['custom_data'] = sanitize_text_field( $value );

//     return $cart_item_data;
// }

// Display on cart and checkout pages
// add_filter( 'woocommerce_get_item_data', 'display_custom_field_as_item_data', 20, 2 );
// function display_custom_field_as_item_data( $cart_data, $cart_item ) {
//     if( isset( $cart_item['custom_data'] ) ){
//         $cart_data[] = array(
//             'name' => __( 'Additional Monthly Fee', 'woocommerce' ),
//             'value' => $cart_item['custom_data']
//         );
//     }
//     return $cart_data;
// }

// Save custom field value in order items meta data
// add_action( 'woocommerce_add_order_item_meta', 'add_custom_field_to_order_item_meta', 20, 3 );
// function add_custom_field_to_order_item_meta( $item_id, $values, $cart_item_key ) {

//     if( isset( $values['custom_data'] ) )
//         wc_add_order_item_meta( $item_id, __( 'Additional Monthly Fee', 'woocommerce' ), $values['custom_data'] );
// }
// add_action( 'woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3 );
// add_action( 'woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2 );
// add_filter( 'woocommerce_available_variation', 'load_variation_settings_fields' );
// //add_filter( 'woocommerce_order_item_name', 'variation_settings_fields', 10, 2 );
// //add_action( 'woocommerce_email_order_meta', 'variation_settings_fields' );
// function variation_settings_fields( $loop, $variation_data, $variation ) {
//     woocommerce_wp_text_input(
//         array(
//             'id'            => "my_text_field{$loop}",
//             'name'          => "my_text_field[{$loop}]",
//             'value'         => get_post_meta( $variation->ID, 'my_text_field', true ),
//             'label'         => __( 'Purchse Note', 'woocommerce' ),
//             'desc_tip'      => true,
//             'description'   => __( 'Purchase note.', 'woocommerce' ),
//             'wrapper_class' => 'form-row form-row-full',
//         )
//     );
// }

// function save_variation_settings_fields( $variation_id, $loop ) {
//     $text_field = $_POST['my_text_field'][ $loop ];

//     if ( ! empty( $text_field ) ) {
//         update_post_meta( $variation_id, 'my_text_field', esc_attr( $text_field ));
//     }
// }

// function load_variation_settings_fields( $variation ) {     
//     $variation['my_text_field'] = get_post_meta( $variation[ 'variation_id' ], 'my_text_field', true );

//     return $variation;
// }
// Admin: Add custom field
// add_action('woocommerce_product_options_sku', 'vp_add_commodity_code' );
// function vp_add_commodity_code(){

//     woocommerce_wp_text_input( array(
//         'id'          => '_commodity_code',
//         'label'       => __('Commodity Code', 'woocommerce' ),
//         'placeholder' => __('Enter Commodity Code here', 'woocommerce' ),
//         'desc_tip'    => true,
//         'description' => __('This field is for the Commodity Code of the product.', 'woocommerce' ),
//     ) );
// }

// // Admin: Save custom field value for simple product inventory options
// add_action('woocommerce_admin_process_product_object', 'vp_product_save_commodity_code', 10, 1 );
// function vp_product_save_commodity_code( $product ){
//     if( isset($_POST['_commodity_code']) )
//         $product->update_meta_data( '_commodity_code', sanitize_text_field($_POST['_commodity_code']) );
// }

// // Admin: Add custom field in product variations options pricing
// add_action( 'woocommerce_variation_options_pricing', 'vp_add_variation_commodity_code', 10, 3 );
// function vp_add_variation_commodity_code( $loop, $variation_data, $variation ){

//    woocommerce_wp_text_input( array(
//         'id'          => '_commodity_code['.$loop.']',
//         'label'       => __('Commodity Code', 'woocommerce' ),
//         'placeholder' => __('Enter Commodity Code here', 'woocommerce' ),
//         'desc_tip'    => true,
//         'description' => __('This field is for the Commodity Code of the product.', 'woocommerce' ),
//         'value'       => get_post_meta( $variation->ID, '_commodity_code', true )
//     ) );
// }

// // Admin: Save custom field value from product variations options pricing
// add_action( 'woocommerce_save_product_variation', 'save_barcode_variations', 10, 2 );
// function save_barcode_variations( $variation_id, $i ){
//     if( isset($_POST['_commodity_code'][$i]) ){
//         update_post_meta( $variation_id, '_commodity_code', sanitize_text_field($_POST['_commodity_code'][$i]) );
//     }
// }

// // Frontend: Display Commodity Code on product
// add_action( 'woocommerce_before_add_to_cart_button', 'vp_product_display_commodity_code' );
// function vp_product_display_commodity_code() {
//     global $product;

//     if( $value = $product->get_meta( '_commodity_code' ) ) {
//         echo '<div class="vp-ccode-wrapper"><strong>' . __("Commodity Code", "woocommerce") .
//         ': </strong>'.esc_html( $value ).'</div>';
//     }
// }

// // Frontend: Display Commodity Code on product variations
// add_filter( 'woocommerce_available_variation', 'vp_variation_display_commodity_code', 10, 3 );
// function vp_variation_display_commodity_code( $data, $product, $variation ) {

//     if( $value = $variation->get_meta( '_commodity_code' ) ) {
//         $data['price_html'] .= '<p class="vp-ccode"><small><strong>' . __("Commodity Code", "woocommerce") .
//         ': </strong>'.esc_html( $value ).'</small></p>';
//     }

//     return $data;
// }

// // Frontend: Display Commodity Code on cart
// add_filter( 'woocommerce_cart_item_name', 'vp_cart_display_commodity_code', 10, 3 );
// function vp_cart_display_commodity_code( $item_name, $cart_item, $cart_item_key ) {
//     if( ! is_cart() )
//         return $item_name;

//     if( $value = $cart_item['data']->get_meta('_commodity_code') ) {
//         $item_name .= '<br><small class="vp-ccode"><strong>' . __("Commodity Code", "woocommerce") .
//             ':</strong> ' . esc_html( $value ) . '</small>';
//     }
//     return $item_name;
// }

// // Frontend: Display Commodity Code on checkout
// add_filter( 'woocommerce_checkout_cart_item_quantity', 'vp_checkout_display_commodity_code', 10, 3 );
// function vp_checkout_display_commodity_code( $item_qty, $cart_item, $cart_item_key ) {
//     if( $value = $cart_item['data']->get_meta('_commodity_code') ) {
//         $item_qty .= '<br><small class="vp-ccode"><strong>' . __("Commodity Code", "woocommerce") .
//             ':</strong> ' . esc_html( $value ) . '</small>';
//     }
//     return $item_qty;
// }

// // Save Commodity Code to order items (and display it on admin orders)
// add_filter( 'woocommerce_checkout_create_order_line_item', 'vp_order_item_save_commodity_code', 10, 4 );
// function vp_order_item_save_commodity_code( $item, $cart_item_key, $cart_item, $order ) {
//     if( $value = $cart_item['data']->get_meta('_commodity_code') ) {
//         $item->update_meta_data( '_commodity_code', esc_attr( $value ) );
//     }
//     return $item_qty;
// }

// // Frontend & emails: Display Commodity Code on orders
// add_action( 'woocommerce_order_item_meta_start', 'vp_order_item_display_commodity_code', 10, 4 );
// function vp_order_item_display_commodity_code( $item_id, $item, $order, $plain_text ) {
//     // Not on admin
//     //if( is_admin() ) return;

//     if( $value = $item->get_meta('_commodity_code') ) {
//         $value = '<strong>' . __("Commodity Code", "woocommerce") . ':</strong> ' . esc_attr( $value );

//         // On orders
//         if( is_wc_endpoint_url() )
//             echo '<div class="vp-ccode"><small>' . $value . '</small></div>';
//         // On Emails
//         else
//             echo '<div style="font-size:11px;padding-top:6px">' . $value . '</div>';
//     }
// }


// Add a custom field before single add to cart
// add_action( 'woocommerce_before_add_to_cart_button', 'custom_product_price_field', 5 );
// function custom_product_price_field(){
//     echo '<div class="custom-text text">
//     <p>Extra Charge ('.get_woocommerce_currency_symbol().'):</p>
//     <input type="text" name="custom_price" value="" placeholder="e.g. 10" title="Custom Text" class="custom_price text_custom text">
//     </div>';
// }

// // Get custom field value, calculate new item price, save it as custom cart item data
// add_filter('woocommerce_add_cart_item_data', 'add_custom_field_data', 20, 2 );
// function add_custom_field_data( $cart_item_data, $product_id ){
//     if (! isset($_POST['custom_price']))
//         return $cart_item_data;

//     $custom_price = (float) sanitize_text_field( $_POST['custom_price'] );
//     if( empty($custom_price) )
//         return $cart_item_data;

//     $product    = wc_get_product($product_id); // The WC_Product Object
//     $base_price = (float) $product->get_regular_price(); // Product reg price

//     // New price calculation
//     $new_price = $base_price + $custom_price;

//     // Set the custom amount in cart object
//     $cart_item_data['custom_data']['extra_charge'] = (float) $custom_price;
//     $cart_item_data['custom_data']['new_price'] = (float) $new_price;
//     $cart_item_data['custom_data']['unique_key'] = md5( microtime() . rand() ); // Make each item unique

//     return $cart_item_data;
// }

// // Set the new calculated cart item price
// add_action( 'woocommerce_before_calculate_totals', 'extra_price_add_custom_price', 20, 1 );
// function extra_price_add_custom_price( $cart ) {
//     if ( is_admin() && ! defined( 'DOING_AJAX' ) )
//         return;

//     if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
//         return;

//     foreach ( $cart->get_cart() as $cart_item ) {
//         if( isset($cart_item['custom_data']['new_price']) )
//             $cart_item['data']->set_price( (float) $cart_item['custom_data']['new_price'] );
//     }
// }

// // Display cart item custom price details
// add_filter('woocommerce_cart_item_price', 'display_cart_items_custom_price_details', 20, 3 );
// function display_cart_items_custom_price_details( $product_price, $cart_item, $cart_item_key ){
//     if( isset($cart_item['custom_data']['extra_charge']) ) {
//         $product = $cart_item['data'];
//         $product_price  = wc_price( wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) ) );
//         $product_price .= '<br>' . wc_price( $cart_item['custom_data']['extra_charge'] ).'&nbsp;';
//         $product_price .= __("Extra Charge", "woocommerce" );
//     }
//     return $product_price;
// }


// Display Fields
//   add_action( 'woocommerce_product_options_general_product_data',      'woo_add_custom_general_fields' );

//   // Save Fields
//   add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );

//   function woo_add_custom_general_fields() {

//     global $woocommerce, $post;

//     echo '<div class="options_group">';

//     // Custom fields will be created here...

//     woocommerce_wp_text_input( 
//     array( 
//         'id'                => '_number_field', 
//         'label'             => __( 'Environmental fee', 'woocommerce' ), 
//         'placeholder'       => '', 
//         'description'       => __( 'Enter the custom value here.', 'woocommerce' ),
//         'type'              => 'number', 
//         'custom_attributes' => array(
//                 'step'  => 'any',
//                 'min'   => '0'
//             ) 
//     )
//   );

//     echo '</div>';

//   }


//   function woo_add_custom_general_fields_save( $post_id ){


//     // Number Field
//     $woocommerce_number_field = $_POST['_number_field'];
//     if( !empty( $woocommerce_number_field ) )
//         update_post_meta( $post_id, '_number_field', esc_attr( $woocommerce_number_field ) );


//   }


//   add_action( 'woocommerce_cart_calculate_fees','endo_handling_fee' );
//   function add_custom_fees( WC_Cart $cart ){
//     $fees = 0;
//     $prod_fee = get_post_meta($item['product_id'] , '_number_field', true);
//     foreach( $cart->get_cart() as $item ){
//        $fees += $item[ 'quantity' ] * $prod_fee ; 
//     }
//     if( $fees != 0 ){
//         $cart->add_fee( 'Handling fee', $fees);
//     }
// }
// 
// 
// 
// Add a custom field before single add to cart
// add_action( 'woocommerce_before_add_to_cart_button', 'custom_product_price_field', 5 );
// function custom_product_price_field(){
//     echo '<div class="custom-text text">
//     <p>Extra Charge ('.get_woocommerce_currency_symbol().'):</p>
//     <input type="text" name="custom_price" value="" placeholder="e.g. 10" title="Custom Text" class="custom_price text_custom text">
//     </div>';
// }

// // Get custom field value, calculate new item price, save it as custom cart item data
// add_filter('woocommerce_add_cart_item_data', 'add_custom_field_data', 20, 2 );
// function add_custom_field_data( $cart_item_data, $product_id ){
//     if (! isset($_POST['custom_price']))
//         return $cart_item_data;

//     $custom_price = (float) sanitize_text_field( $_POST['custom_price'] );
//     if( empty($custom_price) )
//         return $cart_item_data;

//     $product    = wc_get_product($product_id); // The WC_Product Object
//     $base_price = (float) $product->get_regular_price(); // Product reg price

//     // New price calculation
//     $new_price = $base_price + $custom_price;

//     // Set the custom amount in cart object
//     $cart_item_data['custom_data']['extra_charge'] = (float) $custom_price;
//     $cart_item_data['custom_data']['new_price'] = (float) $new_price;
//     $cart_item_data['custom_data']['unique_key'] = md5( microtime() . rand() ); // Make each item unique

//     return $cart_item_data;
// }

// // Set the new calculated cart item price
// add_action( 'woocommerce_before_calculate_totals', 'extra_price_add_custom_price', 20, 1 );
// function extra_price_add_custom_price( $cart ) {
//     if ( is_admin() && ! defined( 'DOING_AJAX' ) )
//         return;

//     if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
//         return;

//     foreach ( $cart->get_cart() as $cart_item ) {
//         if( isset($cart_item['custom_data']['new_price']) )
//             $cart_item['data']->set_price( (float) $cart_item['custom_data']['new_price'] );
//     }
// }

// // Display cart item custom price details
// add_filter('woocommerce_cart_item_price', 'display_cart_items_custom_price_details', 20, 3 );
// function display_cart_items_custom_price_details( $product_price, $cart_item, $cart_item_key ){
//     if( isset($cart_item['custom_data']['extra_charge']) ) {
//         $product = $cart_item['data'];
//         $product_price  = wc_price( wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) ) );
//         $product_price .= '<br>' . wc_price( $cart_item['custom_data']['extra_charge'] ).'&nbsp;';
//         $product_price .= __("Extra Charge", "woocommerce" );
//     }
//     return $product_price;
// }


function sku_before_order_item_name( $item_name, $item, $is_visible ) {     
    $product = $item->get_product();
    $sku = $product->get_sku();

    // When sku doesn't exist we exit
    if( empty( $sku ) ) return $item_name;

    $sku_text = __( 'SKU', 'woocommerce' ) . ': ' . $sku;

    // Add product permalink when argument $is_visible is true
    $product_permalink =  $is_visible ? $product->get_permalink( $item ) : '';

    if( $product_permalink )
        return sprintf( '<a href="%s">%s - %s</a>', $product_permalink, $sku_text, $item->get_name() );
    else
        return $item->get_name() . ' - ' . $sku_text;
}
add_filter( 'woocommerce_order_item_name', 'sku_before_order_item_name', 30, 3 );