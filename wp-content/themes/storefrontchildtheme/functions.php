<?php 
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() { 
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
	
	} 


add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'filter_dropdown_option_html', 12, 2 );
function filter_dropdown_option_html( $html, $args ) {
	$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' );
	$show_option_none_html = '<option value="">'.esc_html( $show_option_none_text ).'</option>';
	$html = str_replace($show_option_none_html, '', $html);
	return $html;
}
add_filter('woocommerce_reset_variations_link', '__return_empty_string');



include('inc/register-taxonomy.php');
include('inc/register-custom-checkout-field.php');

function ssp_always_show_variation_prices($show, $parent, $variation) {
	return true;
	}
	add_filter( 'woocommerce_show_variation_price', 'ssp_always_show_variation_prices', 99, 3);


// Save custom field value in cart item
add_filter( 'woocommerce_add_cart_item_data', 'save_custom_field_in_cart_object', 30, 3 );
function save_custom_field_in_cart_object( $cart_item_data, $product_id, $variation_id ) {

    // Get the correct Id to be used
    $the_id = $variation_id > 0 ? $variation_id : $product_id;

    if( $value = get_post_meta( $the_id, '_text_field', true ) )
        $cart_item_data['custom_data'] = sanitize_text_field( $value );

    return $cart_item_data;
}

// Display on cart and checkout pages
add_filter( 'woocommerce_get_item_data', 'display_custom_field_as_item_data', 20, 2 );
function display_custom_field_as_item_data( $cart_data, $cart_item ) {
    if( isset( $cart_item['custom_data'] ) ){
        $cart_data[] = array(
            'name' => __( 'Additional Monthly Fee', 'woocommerce' ),
            'value' => $cart_item['custom_data']
        );
    }
    return $cart_data;
}

// Save custom field value in order items meta data
add_action( 'woocommerce_add_order_item_meta', 'add_custom_field_to_order_item_meta', 20, 3 );
function add_custom_field_to_order_item_meta( $item_id, $values, $cart_item_key ) {

    if( isset( $values['custom_data'] ) )
        wc_add_order_item_meta( $item_id, __( 'Additional Monthly Fee', 'woocommerce' ), $values['custom_data'] );
}

// Create new fields for variations
function woo_variable_fields( $loop, $variation_data, $variation ) {

	echo '<div class="variation-custom-fields">';
	
	  // Text Field
	  woocommerce_wp_text_input( 
		array( 
		  'id'          => '_text_field['. $loop .']', 
		  'label'       => __( 'additional fees (e.g. monthly fee)', 'woocommerce' ), 
		  'placeholder' => '',
		  //'desc_tip'    => true,
		  'wrapper_class' => 'form-row form-row-first',
		  //'description' => __( 'Enter the custom value here.', 'woocommerce' ),
		  'value'       => get_post_meta($variation->ID, '_text_field', true)
		)
	  );
	
	echo "</div>"; 
	
	}
	
	/** Save new fields for variations */
	function save_variation_fields( $variation_id, $i) {
	
	// Text Field
	$text_field = stripslashes( $_POST['_text_field'][$i] );
	update_post_meta( $variation_id, '_text_field', esc_attr( $text_field ) );
	}
	
	// Custom Product Variation
	add_filter( 'woocommerce_available_variation', 'custom_load_variation_settings_products_fields' );
	
	function custom_load_variation_settings_products_fields( $variations )    { 
	$variations['variation_custom_field'] = get_post_meta( $variations[ 'variation_id' ], '_text_field', true );  
	return $variations;
	}

	add_action( 'woocommerce_email_order_meta', 'woo_add_order_notes_to_email' );
function woo_add_order_notes_to_email() {
	global $woocommerce, $post;
	$args = array(
		'post_id' 	=> $post->ID,
		'approve' 	=> 'approve',
		'type' 		=> 'order_note'
	);
	$notes = get_comments( $args );
	
	echo '<h2>' . __( 'Order Notes', 'woocommerce' ) . '</h2>';
	echo '<ul class="order_notes">';
	if ( $notes ) {
		foreach( $notes as $note ) {
			$note_classes = get_comment_meta( $note->comment_ID, 'is_customer_note', true ) ? array( 'customer-note', 'note' ) : array( 'note' );
			?>
			<li rel="<?php echo absint( $note->comment_ID ) ; ?>" class="<?php echo implode( ' ', $note_classes ); ?>">
				<div class="note_content">
					(<?php printf( __( 'added %s ago', 'woocommerce' ), human_time_diff( strtotime( $note->comment_date_gmt ), current_time( 'timestamp', 1 ) ) ); ?>) <?php echo wpautop( wptexturize( wp_kses_post( $note->comment_content ) ) ); ?>
				</div>
			</li>
			<?php
		}
	} else {
		echo '<li>' . __( 'There are no notes for this order yet.', 'woocommerce' ) . '</li>';
	}
	echo '</ul>';