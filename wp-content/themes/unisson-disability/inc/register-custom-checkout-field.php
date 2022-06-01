<?php 

// add_action( 'woocommerce_edit_account_form', 'display_checkbox_in_account_page' );
// function display_checkbox_in_account_page() {

//     woocommerce_form_field( 'newsletter-account', array(
//         'type'  => 'text',
//         'class' => array('form-row-wide'),
//         'label' => __( 'Subscribe me.', 'woocommerce' ),
//         'clear' => true,
//     ), get_user_meta(get_current_user_id(), 'newsletter-account', true ) );
// }

// add_action( 'woocommerce_save_account_details', 'save_checkbox_value_to_account_details', 10, 1 );
// function save_checkbox_value_to_account_details( $user_id ) {
//     $value = isset( $_POST['newsletter-account'] ) ? '1' : '0';
//     update_user_meta( $user_id, 'newsletter-account', $value );
// }

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
            ), $user, $checkout->get_value( 'attendee_first_name_' . $x ) );
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
		echo '<div class="checkbox">';
        woocommerce_form_field( 'funding_type_checkbox_self_managed_', array(
                'type' => 'checkbox',
                'class' => array('funding-type-checkbox-self-managed form-row-wide'),
                'required' => true,
			    'label'         => __('Self Managed ')
            ), $checkout->get_value( 'funding_type_checkbox_self_managed_' ) );
		echo '</div>';
		echo '<div class="checkbox">';
		 woocommerce_form_field( 'funding_type_checkbox_plan_managed_', array(
                'type' => 'checkbox',
                'class' => array('funding_type_radio form-row-wide'),
                'required' => true,
			    'label'         => __('Plan Managed ')
            ), $checkout->get_value( 'funding_type_checkbox_plan_managed_' ) );
		echo '</div>';
		echo '<div class="checkbox">';
		 woocommerce_form_field( 'funding_type_checkbox_ndia_managed_', array(
                'type' => 'checkbox',
                'class' => array('funding_type_radio form-row-wide'),
                'required' => true,
			    'label'         => __('NDIA Managed ')
            ), $checkout->get_value( 'funding_type_checkbox_ndia_managed_' ) );
			echo '</div>';
         echo '</div>';
            
		
            echo '<div class="self_manage_funding_text Attendee-group">';
            
           echo '<div class=" funding-type-description"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut               enim ad minim veniam, quis nostrud exercitation ullamco labori</p></div>';
                //self manage
                echo '<div class="Attendee-group"><h4>Self-managed details for invoicing</h4></div>';
                //firstname
                woocommerce_form_field( 'attendee_first_name_' . $x, array(
                    'type'          => 'text',
                    'class'         => array('form-row-first'),
                    'label'         => __('First Name '),
                    'placeholder'   => __(''),
                    'required' => true,
                    ), $user, $checkout->get_value( 'attendee_first_name_' . $x ) );
                // lastname
                woocommerce_form_field( 'attendee_last_name_' . $x, array(
                    'type'          => 'text',
                    'class'         => array('form-row-last'),
                    'label'         => __('Last Name '),
                    'placeholder'   => __(''),
                    'required' => true,
                    ), $checkout->get_value( 'attendee_last_name_' . $x ));
                //email
                woocommerce_form_field( 'attendee_email_' . $x, array(
                    'type'          => 'email',
                    'class'         => array('form-row-wide'),
                    'label'         => __('Email '),
                    'placeholder'   => __(''),
                    'required' => true,
                    ), $checkout->get_value( 'attendee_email_' . $x ));
                
                //phone
                woocommerce_form_field( 'attendee_phone_' . $x, array(
                    'type'          => 'text',
                    'class'         => array('form-row-wide'),
                    'label'         => __('Phone '),
                    'placeholder'   => __(''),
                    'required' => true,
                    ), $checkout->get_value( 'attendee_phone_' . $x ));
                //DOB
                woocommerce_form_field( 'attendee_dob_' . $x, array(
                    'type'          => 'date',
                    'class'         => array('form-row-first'),
                    'label'         => __('DOB '),
                    'placeholder'   => __(''),
                    'required' => true,
                    ), $checkout->get_value( 'attendee_dob_' . $x ));
                //gender
                woocommerce_form_field( 'attendee_gender_' . $x, array(
                    'type' => 'select',
                    'class' => array('form-row-last'),
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
                    'class'         => array('form-row-wide'),
                    'label'         => __('Address '),
                    'placeholder'   => __(''),
                    'required' => true,
                    ), $checkout->get_value( 'attendee_address_1_' . $x ));
                //Address 2
                woocommerce_form_field( 'attendee_address_2_' . $x, array(
                    'type'          => 'text',
                    'class'         => array('form-row-wide'),
                    'label'         => __('Apartment, Suite, etc. '),
                    'placeholder'   => __(''),
                    ), $checkout->get_value( 'attendee_address_2_' . $x ));
                //City
                woocommerce_form_field( 'attendee_city_' . $x, array(
                    'type'          => 'text',
                    'class'         => array('form-row-wide address-field'),
                    'label'         => __('Suburb/City '),
                    'placeholder'   => __(''),
                    ), $checkout->get_value( 'attendee_city_' . $x ));
                //State
                woocommerce_form_field( 'attendee_state_' . $x, array(
                    'type' => 'select',
                    'class' => array('form-row-wide address-field'),
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
                    'class'         => array('form-row-wide address-field'),
                    'label'         => __('Postcode '),
                    'placeholder'   => __(''),
                    'required' => true,
                    ), $checkout->get_value( 'attendee_postcode_' . $x ));
        
               
                
                
            echo '</div>';


                    echo '<div class="plan-managed-funding-text Attendee-group">';
                        echo '<div class="plan-managed-funding-text funding-type-description"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labori</p></div>';
                        //self manage
                        echo '<div class="plan-managed-funding-text Attendee-group"><h4>Plan Managed</h4></div>';
                        //firstname
                        woocommerce_form_field( 'attendee_first_name_' . $x, array(
                            'type'          => 'text',
                            'class'         => array('plan-managed-funding-text form-row-first'),
                            'label'         => __('First Name '),
                            'placeholder'   => __(''),
                            'required' => true,
                            ), $user, $checkout->get_value( 'attendee_first_name_' . $x ) );
                        // lastname
                        woocommerce_form_field( 'attendee_last_name_' . $x, array(
                            'type'          => 'text',
                            'class'         => array('plan-managed-funding-text form-row-last'),
                            'label'         => __('Last Name '),
                            'placeholder'   => __(''),
                            'required' => true,
                            ), $checkout->get_value( 'attendee_last_name_' . $x ));
                        //email
                        woocommerce_form_field( 'attendee_email_' . $x, array(
                            'type'          => 'email',
                            'class'         => array('plan-managed-funding-text form-row-wide'),
                            'label'         => __('Email '),
                            'placeholder'   => __(''),
                            'required' => true,
                            ), $checkout->get_value( 'attendee_email_' . $x ));
                        
                        //phone
                        woocommerce_form_field( 'attendee_phone_' . $x, array(
                            'type'          => 'text',
                            'class'         => array('plan-managed-funding-text form-row-wide'),
                            'label'         => __('Phone '),
                            'placeholder'   => __(''),
                            'required' => true,
                            ), $checkout->get_value( 'attendee_phone_' . $x ));
                        //DOB
                        woocommerce_form_field( 'attendee_dob_' . $x, array(
                            'type'          => 'date',
                            'class'         => array('atteplan-managed-funding-text form-row-first'),
                            'label'         => __('DOB '),
                            'placeholder'   => __(''),
                            'required' => true,
                            ), $checkout->get_value( 'attendee_dob_' . $x ));
                        //gender
                        woocommerce_form_field( 'attendee_gender_' . $x, array(
                            'type' => 'select',
                            'class' => array('plan-managed-funding-text form-row-last'),
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
                            'class'         => array('plan-managed-funding-text form-row-wide'),
                            'label'         => __('Address '),
                            'placeholder'   => __(''),
                            'required' => true,
                            ), $checkout->get_value( 'attendee_address_1_' . $x ));
                        //Address 2
                        woocommerce_form_field( 'attendee_address_2_' . $x, array(
                            'type'          => 'text',
                            'class'         => array('plan-managed-funding-text form-row-wide'),
                            'label'         => __('Apartment, Suite, etc. '),
                            'placeholder'   => __(''),
                            ), $checkout->get_value( 'attendee_address_2_' . $x ));
                        //City
                        woocommerce_form_field( 'attendee_city_' . $x, array(
                            'type'          => 'text',
                            'class'         => array('plan-managed-funding-text form-row-wide address-field'),
                            'label'         => __('Suburb/City '),
                            'placeholder'   => __(''),
                            ), $checkout->get_value( 'attendee_city_' . $x ));
                        //State
                        woocommerce_form_field( 'attendee_state_' . $x, array(
                            'type' => 'select',
                            'class' => array('plan-managed-funding-text form-row-wide address-field'),
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
                            'class'         => array('plan-managed-funding-text form-row-wide address-field'),
                            'label'         => __('Postcode '),
                            'placeholder'   => __(''),
                            'required' => true,
                            ), $checkout->get_value( 'attendee_postcode_' . $x ));
                
                        
                        
                    echo '</div>';


            echo '<div class="ndia-managed-funding-text Attendee-group">';
                echo '<div class="ndia-managed-funding-text funding-type-description"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labori</p></div>';
                //self manage
                echo '<div class="ndia-managed-funding-text Attendee-group"><h4>NDIA-managed details </h4></div>';
                //firstname
                woocommerce_form_field( 'attendee_first_name_' . $x, array(
                    'type'          => 'text',
                    'class'         => array('ndia-managed-funding-text form-row-first'),
                    'label'         => __('NDIA Number (If applicable) '),
                    'placeholder'   => __(''),
                    'required' => true,
                    ), $user, $checkout->get_value( 'attendee_first_name_' . $x ) );
             
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
echo '</div>';
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


