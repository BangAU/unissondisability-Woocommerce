<?php 


// //Custom WooCommerce Checkout Fields based on Quantity
// add_action( 'woocommerce_before_order_notes', 'person_details' );

// function person_details($checkout) {
//     global $woocommerce;
// $items = $woocommerce->cart->cart_contents_count;
// $i = 1;

// foreach(WC()->cart->get_cart() as $item => $values) { 
//     $_product = $values['data']->post;
//     $quantity = $values['quantity'];
//     $x = 1;

//     while ($x <= $quantity) {

//          echo '<div class="camper-group"><h3>' . $_product->post_title .  __(' - Attendee ' . $x . '') .'</h3>';

//         woocommerce_form_field( 'camper_name_' . $x, array(
//             'type'          => 'text',
//             'class'         => array('camper form-row-wide'),
//             'label'         => __('Camper ' . $x . ' Name'),
//             'placeholder'   => __(''),
//             ), $checkout->get_value( 'camper_name_' . $x ));

//         woocommerce_form_field( 'camper_grade_' . $x, array(
//             'type'          => 'select',
//             'class'         => array('camper form-row-wide'),
//             'label'         => __('Camper ' . $x . ' Grade'),
//             'placeholder'   => __(''),
//             'options'       => array(
//                 'blank'     => __( 'Select a grade', 'wps' ),
//                 '1st'       => __( '1st', 'wps' ),
//                 '2nd'       => __( '2nd', 'wps' ),
//                 '3rd'       => __( '3rd', 'wps' ),
//                 '4th'       => __( '4th', 'wps' ),
//                 '5th'       => __( '5th', 'wps' ),
//                 '6th'       => __( '6th', 'wps' ),
//                 '7th'       => __( '7th', 'wps' ),
//                 '8th'       => __( '8th', 'wps' ),
//                 '9th'       => __( '9th', 'wps' ),
//                 '10th'      => __( '10th', 'wps' )

//             )
//             ), $checkout->get_value( 'camper_grade_' . $x ));

//         woocommerce_form_field( 'camper_school_' .$x, array(
//             'type'          => 'text',
//             'class'         => array('camper form-row-wide'),
//             'label'         => __('Camper ' . $x . ' School Name'),
//             'placeholder'   => __('The school your child will attend next fall'),
//             ), $checkout->get_value( 'camper_school_' . $x ));

//         echo '</div>';
//         $x++;
//     }

//     $i++;
//     } 

// }


//Custom WooCommerce Checkout Fields based on Quantity
add_action( 'woocommerce_before_order_notes', 'person_details' );

function person_details($checkout) {
    global $woocommerce;
$items = $woocommerce->cart->cart_contents_count;
$i = 1;
foreach(WC()->cart->get_cart() as $item => $values) { 
    $_product = $values['data']->post;
    $quantity = $values['quantity'];
    $x = 1;

    while ($x <= $quantity) {

         echo '<div class="Attendee-group"><h3>' . $_product->post_title .  __(' - Attendee ' . $x . '') .'</h3>';
       //firstname
        woocommerce_form_field( 'attendee_first_name_' . $x, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-first'),
            'label'         => __('First Name '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_first_name_' . $x ));
        // lastname
        woocommerce_form_field( 'attendee_last_name_' . $x, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-last'),
            'label'         => __('Last Name '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_last_name_' . $x ));
        //email
        woocommerce_form_field( 'attendee_email_' . $x, array(
            'type'          => 'email',
            'class'         => array('attendee form-row-wide'),
            'label'         => __('Email '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_email_' . $x ));
        
        //phone
        woocommerce_form_field( 'attendee_phone_' . $x, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-wide'),
            'label'         => __('Phone '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_phone_' . $x ));
        //DOB
        woocommerce_form_field( 'attendee_dob_' . $x, array(
            'type'          => 'date',
            'class'         => array('attendee form-row-first'),
            'label'         => __('DOB '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_dob_' . $x ));
        //gender
        woocommerce_form_field( 'attendee_gender_' . $x, array(
            'type' => 'select',
            'class' => array('my-field-class form-row-last'),
            'label' => __('Gender'),
            'required' => true,
            'options' => array(
            'blank'  => __( '--'),
            'Male' => __( 'Male'),
            'Female' => __( 'Female'),
            'Others' => __( 'Others' )
            )
            ), $checkout->get_value( 'attendee_gender_' . $x ));
        //Address one 
        woocommerce_form_field( 'attendee_address_1_' . $x, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-wide'),
            'label'         => __('Address '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_address_1_' . $x ));
        //Address 2
        woocommerce_form_field( 'attendee_address_2_' . $x, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-wide'),
            'label'         => __('Apartment, Suite, etc. '),
            'placeholder'   => __(''),
            ), $checkout->get_value( 'attendee_address_2_' . $x ));
        //City
        woocommerce_form_field( 'attendee_city_' . $x, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-wide address-field'),
            'label'         => __('Suburb/City '),
            'placeholder'   => __(''),
            ), $checkout->get_value( 'attendee_city_' . $x ));
        //State
        woocommerce_form_field( 'attendee_state_' . $x, array(
            'type' => 'select',
            'class' => array('attendee form-row-wide address-field'),
            'label' => __('State/Territory'),
            'required' => true,
            'options' => array(
            'blank'  => __( '--'),
            'Australian Capital Territory' => __( 'Australian Capital Territory'),
            'New South Wales' => __( 'New South Wales'),
            'Northern Territory' => __( 'Northern Territory' ),
            'Queensland' => __( 'Queensland' ),
            'Tasmania' => __( 'South Australia' ),
            'Northern Territory' => __( 'Tasmania' ),
            'Victoria' => __( 'Victoria' ),
            'Western Australia' => __( 'Western Australia' ),
            )
            ), $checkout->get_value( 'attendee_gender_' . $x ));
        //Passcode
        woocommerce_form_field( 'attendee_postcode_' . $x, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-wide address-field'),
            'label'         => __('Postcode '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_postcode_' . $x ));

        echo '</div>';
      
      
        echo '<div class="Attendee-group"><h3>Funding Type</h3>';
       //self manage

            woocommerce_form_field( 'self_managed_checkbox', array(
                'type'  => 'checkbox',
                'class' => array( 'self-managed-checkbox form-row-wide' ),
                'label' => __( 'Self-managed' ),
                'required' => true,
            ), $checkout->get_value( 'self_managed_checkbox' ) );

            woocommerce_form_field( 'self_managed_textbox', array(
                'type'  => 'text',
                'required' =>'required',
                'class' => array( 'self-managed-text form-row-first' ),
                'label' => __( 'Enter Neck Size in cm' ),
            ), $checkout->get_value( 'fitting_neck_textbox' ) );
            
            //Plan-managed

            woocommerce_form_field( 'plan_managed_checkbox', array(
                'type'  => 'checkbox',
                'class' => array( 'plan-managed-checkbox form-row-wide' ),
                'label' => __( 'Plan-managed' ),
            ), $checkout->get_value( 'plan_managed_checkbox' ) );

            woocommerce_form_field( 'plan_managed_textbox', array(
                'type'  => 'text',
                'required' =>'required',
                'class' => array( 'plan-managed-text form-row-first' ),
                'label' => __( 'Enter Neck Size in cm' ),
            ), $checkout->get_value( 'plan_managed_textbox' ) );
            
            //INDIA-managed

            woocommerce_form_field( 'ndia_managed_checkbox', array(
                'type'  => 'checkbox',
                'class' => array( 'india-managed-checkbox form-row-wide' ),
                'label' => __( 'NDIA Managed' ),
            ), $checkout->get_value( 'ndia_managed_checkbox' ) );

            woocommerce_form_field( 'ndia_managed_checkbox', array(
                'type'  => 'text',
                'required' =>'required',
                'class' => array( 'ndia-managed-text form-row-first' ),
                'label' => __( 'Enter Neck Size in cm' ),
            ), $checkout->get_value( 'ndia_managed_checkbox' ) );
            
           
            
           
            
                echo '</div>';
        $x++;
    }

    $i++;
    } 

}

/**
 * Save value of fields
 */
 
add_action('woocommerce_checkout_update_order_meta', 'customise_checkout_field_update_order_meta');
 
function customise_checkout_field_update_order_meta($order_id) {
global $woocommerce;
$count = $woocommerce->cart->cart_contents_count;
$i = 0;
       for($k=1; $k<= $count; $k++) {
		$i++;
	if (!empty($_POST['attendee_first_name_'.$i])) {
		update_post_meta($order_id, 'First of Attendee'.$i, sanitize_text_field($_POST['attendee_first_name_'.$i]));
	}
	if (!empty($_POST['attendee_last_name_'.$i])) {
		update_post_meta($order_id, 'Last of Attendee'.$i, sanitize_text_field($_POST['attendee_last_name_'.$i]));
	}
	
}
	
	
	
// global $woocommerce;
// $items = $woocommerce->cart->cart_contents_count;
// $i = 1;

// foreach(WC()->cart->get_cart() as $item => $values) { 
//     $_product = $values['data']->post;
//     $quantity = $values['quantity'];
//     $x = 1;

//     while ($x <= $quantity) {

//         if (!empty($_POST['attendee_first_name_'.$x])) {
// 		update_post_meta($order_id, 'First of Attendee'.$x, sanitize_text_field($_POST['attendee_first_name_'.$x]));
// 	}
// 	if (!empty($_POST['attendee_last_name_'.$x])) {
// 		update_post_meta($order_id, 'Last of Attendee'.$x, sanitize_text_field($_POST['attendee_last_name_'.$x]));
// 	}
	

//         $x++;
//     }

//     $i++;
//     } 
}


/**
 * Add fields to order emails
 **/
add_filter('woocommerce_email_order_meta_keys', 'my_custom_checkout_field_order_meta_keys');
function my_custom_checkout_field_order_meta_keys( $keys ) {

	$i = 0;
for($k=1; $k<= 50; $k++) {
$i++;
foreach(WC()->cart->get_cart() as $item => $values) { 
	$_product = $values['data']->post;
    $quantity = $values['quantity'];
    $x = 1;
	 echo '<div class="Attendee-group"><h3>' . $_product->post_title .  __(' - Attendee ' . $x . '') .'</h3>';
$keys[] = 'First of Attendee'.$i;
$keys[] = 'Last of Attendee'.$i;
}
}	
return $keys;

// global $woocommerce;
// $items = $woocommerce->cart->cart_contents_count;
// foreach(WC()->cart->get_cart() as $item => $values) { 
//     $_product = $values['data']->post;
//     $quantity = $values['quantity'];
//     $x = 1;

//     while ($x <= $quantity) {
//         $keys[] = 'First of Attendee Last of Attendee'.$x;
	
//         $x++;
//     }
// 	return $keys;


//     $i++;
//     } 
	

	
// $i = 1;
// for($k=1; $k<= 50; $k++) {
// $i++;
// $keys[] = 'First Name'.$i;
// $keys[] = 'Last Name'.$i;
// }	
// return $keys;
}