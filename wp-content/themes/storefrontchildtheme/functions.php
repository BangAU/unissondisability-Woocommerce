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
add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );



include('inc/register-taxonomy.php');
include('inc/important-message.php');
include('inc/register-custom-checkout-field.php');
include('inc/price-settings.php');


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

