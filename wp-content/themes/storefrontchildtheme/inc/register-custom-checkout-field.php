<?php 
//Custom WooCommerce Checkout Fields based on Quantity
add_action( 'woocommerce_before_order_notes', 'person_details' );

function person_details($checkout) {
global $woocommerce;

$count = $woocommerce->cart->cart_contents_count;
$i = 1;
		 
	foreach ( WC()->cart->get_cart() as $cart_item ) {
		$count_each_product = count($cart_item);
		
		for($k=1; $k<= $count_each_product; $k++){
			print ('<h3>Please enter details of attendee '.$i.', '. $product->get_name().'</h3>');
			$i ++;
		}

		/* $product = $cart_item['data'];
		//var_dump($cart_item_key);
			//var_dump($_product);
		// var_dump($cart_item);
		
		print ('<h3>Please enter details of attendee '.$i.', '. $product->get_name().'</h3>');
		
		woocommerce_form_field( 'plan_type', array(
		'type'            => 'radio',
		'required'        => true,
		'class'           => array('my-field-class form-row-wide'),
		'options'         => array(
			'self-managed'         => 'Self Managed',
			'plan-managed'    => 'Plan Managed',
		),
		), $checkout->get_value( 'plan_type' ) );   
		woocommerce_form_field( 'cstm_full_name'.$i, array(
			'type'          => 'text',
			'class'         => array('my-field-class form-row-wide'),
			'label'         => __('Full name'),
			'placeholder'   => __('Enter full name'),
			),
			$checkout->get_value( 'cstm_full_name'.$i ));
		echo '<div class="clear"></div>';
		woocommerce_form_field( 'cstm_phone'.$i, array(
			'type'          => 'text',
			'class'         => array('my-field-class form-row-first'),
			'label'         => __('Phone'),
			'placeholder'   => __('Enter phone number'),
			),
			$checkout->get_value( 'cstm_phone'.$i ));
		woocommerce_form_field( 'cstm_email'.$i, array(
			'type'          => 'email',
			'class'         => array('my-field-class form-row-last'),
			'label'         => __('Email address'),
			'placeholder'   => __('Enter email address'),
			),
			$checkout->get_value( 'cstm_email'.$i ));
		echo '<div class="clear"></div>';
		woocommerce_form_field( 'cstm_address'.$i, array(
			'type'          => 'textarea',
			'class'         => array('my-field-class form-row-wide'),
			'label'         => __('Full address'),
			'placeholder'   => __('Enter full address'),
			),
			$checkout->get_value( 'cstm_address'.$i ));
	 */
	}
}
/**
 * Save value of fields
 */
 
add_action('woocommerce_checkout_update_order_meta', 'customise_checkout_field_update_order_meta');
 
function customise_checkout_field_update_order_meta($order_id) {
	global $woocommerce;
$count = $woocommerce->cart->cart_contents_count;
$i = 1;
       for($k=2; $k<= $count; $k++) {
		$i++;
	if (!empty($_POST['plan_type'.$i])) {
		update_post_meta($order_id, 'plan_type'.$i, sanitize_text_field($_POST['cstm_full_name'.$i]));
	}
	if (!empty($_POST['cstm_full_name'.$i])) {
		update_post_meta($order_id, 'Name of Attendee'.$i, sanitize_text_field($_POST['cstm_full_name'.$i]));
	}
	if (!empty($_POST['cstm_phone'.$i])) {
		update_post_meta($order_id, 'Phone of Attendee'.$i, sanitize_text_field($_POST['cstm_phone'.$i]));
	}
	if (!empty($_POST['cstm_email'.$i])) {
		update_post_meta($order_id, 'Email of Attendee'.$i, sanitize_text_field($_POST['cstm_email'.$i]));
	}
	if (!empty($_POST['cstm_address'.$i])) {
		update_post_meta($order_id, 'Address of Attendee'.$i, sanitize_text_field($_POST['cstm_address'.$i]));
	}
}
}

/**
 * Add fields to order emails
 **/
add_filter('woocommerce_email_order_meta_keys', 'my_custom_checkout_field_order_meta_keys');
function my_custom_checkout_field_order_meta_keys( $keys ) {
$i = 1;
for($k=2; $k<= 50; $k++) {
$i++;
$keys[] = 'Plan Type'.$i;
$keys[] = 'Name of Attendee'.$i;
$keys[] = 'Phone of Attendee'.$i;
$keys[] = 'Email of Attendee'.$i;
$keys[] = 'Email of Participant '.$i;
$keys[] = 'Address of Attendee'.$i;
}	
return $keys;
}