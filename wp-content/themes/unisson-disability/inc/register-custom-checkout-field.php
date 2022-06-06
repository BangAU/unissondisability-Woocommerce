<?php 
//Custom WooCommerce Checkout Fields based on Quantity
add_action( 'woocommerce_before_order_notes', 'person_details' );

function person_details($checkout) {
    global $woocommerce;
$items = $woocommerce->cart->cart_contents_count;
$i = 1;
foreach(WC()->cart->get_cart() as $item => $values) { 
    $_product = $values['data']->post;
    $quantity = $values['quantity'];
    // $start_date = get_field('tour_start_date' , $_product);
    // $end_date = get_field('tour_end_date' , $_product);
    // $terms = get_the_terms( $_product, 'location' );
    $x = 1;
    
    while ($x <= $quantity) {
        
         echo '<div class="Attendee-group"><h4>'.  __('<span class="attendee-title">Attendee ' . $x . ' - </span>' )  . $_product->post_title .'</h4>';
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

            echo '<div class="Attendee-group-funding-type"><h4>Funding Type*</h4>';  echo '</div>';

            woocommerce_form_field( '_funding_type_radio_'. $x, array(
                'type' => 'radio',
                'class' => array('funding-type-radio'),
                'required' => 'required',
                'options' => array(
                'Self_managed' => __( 'Self-managed'),
                'Plan_managed' => __( 'Plan-managed'),
                'Ndia_managed' => __( 'NDIA-managed' ),
                ),
               // 'default'  => 'Self_managed',

            ), $checkout->get_value( '_funding_type_radio_' . $x ));

            echo '<div class=" funding-type-description"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut               enim ad minim veniam, quis nostrud exercitation ullamco labori</p></div>';

          //  echo "<script>alert('message');</script>";

            //funding type radio ending

        echo '<div class="self_manage_funding_text Attendee-group">';
            
             //self manage
             echo '<div class="Attendee-group"><h4>Self-managed details for invoicing</h4></div>';
             //firstname
             woocommerce_form_field( 'self_managed_funding_type_attendee_first_name_' . $x, array(
                 'type'          => 'text',
                 'class'         => array('form-row-first'),
                 'label'         => __('First Name '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $user, $checkout->get_value( 'self_managed_funding_type_attendee_first_name_' . $x ) );
             // lastname
             woocommerce_form_field( 'self_managed_funding_type_attendee_last_name_' . $x, array(
                 'type'          => 'text',
                 'class'         => array('form-row-last'),
                 'label'         => __('Last Name '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_last_name_' . $x ));
             //email
             woocommerce_form_field( 'self_managed_funding_type_attendee_email_' . $x, array(
                 'type'          => 'email',
                 'class'         => array('form-row-wide'),
                 'label'         => __('Email '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_email_' . $x ));
             
             //phone
             woocommerce_form_field( 'self_managed_funding_type_attendee_phone_' . $x, array(
                 'type'          => 'text',
                 'class'         => array('form-row-wide'),
                 'label'         => __('Phone '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_phone_' . $x ));
             //DOB
             woocommerce_form_field( 'self_managed_funding_type_attendee_dob_' . $x, array(
                 'type'          => 'date',
                 'class'         => array('form-row-first'),
                 'label'         => __('DOB '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_dob_' . $x ));
             //gender
             woocommerce_form_field( 'self_managed_funding_type_attendee_gender_' . $x, array(
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
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_gender_' . $x ));
             //Address one 
             woocommerce_form_field( 'self_managed_funding_type_attendee_address_1_' . $x, array(
                 'type'          => 'text',
                 'class'         => array('form-row-wide'),
                 'label'         => __('Address '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_address_1_' . $x ));
             //Address 2
             woocommerce_form_field( 'self_managed_funding_type_attendee_address_2_' . $x, array(
                 'type'          => 'text',
                 'class'         => array('form-row-wide'),
                 'label'         => __('Apartment, Suite, etc. '),
                 'placeholder'   => __(''),
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_address_2_' . $x ));
             //City
             woocommerce_form_field( 'self_managed_funding_type_attendee_city_' . $x, array(
                 'type'          => 'text',
                 'class'         => array('form-row-wide address-field'),
                 'label'         => __('Suburb/City '),
                 'placeholder'   => __(''),
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_city_' . $x ));
             //State
             woocommerce_form_field( 'self_managed_funding_type_attendee_state_' . $x, array(
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
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_state_' . $x ));
             //Passcode
             woocommerce_form_field( 'self_managed_funding_type_attendee_postcode_' . $x, array(
                 'type'          => 'text',
                 'class'         => array('form-row-wide address-field'),
                 'label'         => __('Postcode '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_postcode_' . $x ));
                     
         echo '</div>';


           //plan manage funding type
           echo '<div class="plan-managed-funding-text Attendee-group">';
           //self manage
           echo '<div class="plan-managed-funding-text Attendee-group"><h4>Plan Managed</h4></div>';
           //firstname
           woocommerce_form_field( 'plan_managed_funding_type_attendee_first_name_' . $x, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-first'),
               'label'         => __('First Name '),
               'placeholder'   => __(''),
               'required' => true,
               ), $user, $checkout->get_value( 'plan_managed_funding_type_attendee_first_name_' . $x ) );
           // lastname
           woocommerce_form_field( 'plan_managed_funding_type_attendee_last_name_' . $x, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-last'),
               'label'         => __('Last Name '),
               'placeholder'   => __(''),
               'required' => true,
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_last_name_' . $x ));
           //email
           woocommerce_form_field( 'plan_managed_funding_type_attendee_email_' . $x, array(
               'type'          => 'email',
               'class'         => array('plan-managed-funding-text form-row-wide'),
               'label'         => __('Email '),
               'placeholder'   => __(''),
               'required' => true,
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_email_' . $x ));
           
           //phone
           woocommerce_form_field( 'plan_managed_funding_type_attendee_phone_' . $x, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-wide'),
               'label'         => __('Phone '),
               'placeholder'   => __(''),
               'required' => true,
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_phone_' . $x ));
           //DOB
           woocommerce_form_field( 'plan_managed_funding_type_attendee_dob_' . $x, array(
               'type'          => 'date',
               'class'         => array('atteplan-managed-funding-text form-row-first'),
               'label'         => __('DOB '),
               'placeholder'   => __(''),
               'required' => true,
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_dob_' . $x ));
           //gender
           woocommerce_form_field( 'plan_managed_funding_type_attendee_gender_' . $x, array(
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
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_gender_' . $x ));
           //Address one 
           woocommerce_form_field( 'plan_managed_funding_type_attendee_address_1_' . $x, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-wide'),
               'label'         => __('Address '),
               'placeholder'   => __(''),
               'required' => true,
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_address_1_' . $x ));
           //Address 2
           woocommerce_form_field( 'plan_managed_funding_type_attendee_address_2_' . $x, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-wide'),
               'label'         => __('Apartment, Suite, etc. '),
               'placeholder'   => __(''),
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_address_2_' . $x ));
           //City
           woocommerce_form_field( 'plan_managed_funding_type_attendee_city_' . $x, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-wide address-field'),
               'label'         => __('Suburb/City '),
               'placeholder'   => __(''),
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_city_' . $x ));
           //State
           woocommerce_form_field( 'plan_managed_funding_type_attendee_state_' . $x, array(
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
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_state_' . $x ));
           //Passcode
           woocommerce_form_field( 'plan_managed_funding_type_attendee_postcode_' . $x, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-wide address-field'),
               'label'         => __('Postcode '),
               'placeholder'   => __(''),
               'required' => true,
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_postcode_' . $x ));
   
           
             echo '</div>';

             echo '<div class="ndia-managed-funding-text Attendee-group">';
                //self manage
                echo '<div class="ndia-managed-funding-text Attendee-group"><h4>NDIA-managed details </h4></div>';
                //firstname
                woocommerce_form_field( 'ndia_managed_funding_type_attendee_ndia_number_' . $x, array(
                    'type'          => 'text',
                    'class'         => array('ndia-managed-funding-text form-row-first'),
                    'label'         => __('NDIA Number (If applicable) '),
                    'placeholder'   => __(''),
                    ), $checkout->get_value( 'ndia_managed_funding_type_attendee_ndia_number_' . $x ) );
             
            echo '</div>';

        echo '</div>';

        //funding type starting

     
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
            update_post_meta($order_id, 'First Name of Attendee'.$i, sanitize_text_field($_POST['attendee_first_name_'.$i][2]) );
        }
        if (!empty($_POST['attendee_last_name_'.$i])) {
            update_post_meta($order_id, 'Last Name of Attendee'.$i, sanitize_text_field($_POST['attendee_last_name_'.$i]));
        }
        if (!empty($_POST['attendee_email_'.$i])) {
            update_post_meta($order_id, 'Email of Attendee'.$i, sanitize_text_field($_POST['attendee_email_'.$i]));
        }
        if (!empty($_POST['attendee_phone_'.$i])) {
            update_post_meta($order_id, 'Phone Number of Attendee'.$i, sanitize_text_field($_POST['attendee_phone_'.$i]));
        }
        if (!empty($_POST['attendee_dob_'.$i])) {
            update_post_meta($order_id, 'DOB of Attendee'.$i, sanitize_text_field($_POST['attendee_dob_'.$i]));
        }
        if (!empty($_POST['attendee_gender_'.$i])) {
            update_post_meta($order_id, 'Gender of Attendee'.$i, sanitize_text_field($_POST['attendee_gender_'.$i]));
        }
        if (!empty($_POST['attendee_address_1_'.$i])) {
            update_post_meta($order_id, 'Address 1 of Attendee'.$i, sanitize_text_field($_POST['attendee_address_1_'.$i]));
        }
        if (!empty($_POST['attendee_address_2_'.$i])) {
            update_post_meta($order_id, 'Address 2 of Attendee'.$i, sanitize_text_field($_POST['attendee_address_2_'.$i]));
        }
        if (!empty($_POST['attendee_city_'.$i])) {
            update_post_meta($order_id, 'City of Attendee'.$i, sanitize_text_field($_POST['attendee_city_'.$i]));
        }
        if (!empty($_POST['attendee_state_'.$i])) {
            update_post_meta($order_id, 'State of Attendee'.$i, sanitize_text_field($_POST['attendee_state_'.$i]));
        }
        if (!empty($_POST['attendee_postcode_'.$i])) {
            update_post_meta($order_id, 'Postcode of Attendee'.$i, sanitize_text_field($_POST['attendee_postcode_'.$i]));
        }
        if (!empty($_POST['_funding_type_radio_'.$i])) {
            update_post_meta($order_id, 'Funding Type of Attendee'.$i, sanitize_text_field($_POST['_funding_type_radio_'.$i]));
        }

	    //self manage funding type start
        if (!empty($_POST['self_managed_funding_type_attendee_first_name_'.$i])) {
            update_post_meta($order_id, 'Self-Managed First Name of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_first_name_'.$i]));
        }
        if (!empty($_POST['self_managed_funding_type_attendee_last_name_'.$i])) {
            update_post_meta($order_id, 'Self-Managed Last Name of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_last_name_'.$i]));
        }
        if (!empty($_POST['self_managed_funding_type_attendee_email_'.$i])) {
            update_post_meta($order_id, 'Self-Managed Email of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_email_'.$i]));
        }
        if (!empty($_POST['self_managed_funding_type_attendee_phone_'.$i])) {
            update_post_meta($order_id, 'Self-Managed Phone Number of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_phone_'.$i]));
        }
        if (!empty($_POST['self_managed_funding_type_attendee_dob_'.$i])) {
            update_post_meta($order_id, 'Self-Managed DOB of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_dob_'.$i]));
        }
        if (!empty($_POST['self_managed_funding_type_attendee_gender_'.$i])) {
            update_post_meta($order_id, 'Self-Managed Gender of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_gender_'.$i]));
        }
        if (!empty($_POST['self_managed_funding_type_attendee_address_1_'.$i])) {
            update_post_meta($order_id, 'Self-Managed Address 1 of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_address_1_'.$i]));
        }
        if (!empty($_POST['self_managed_funding_type_attendee_address_2_'.$i])) {
            update_post_meta($order_id, 'Self-Managed Address 2 of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_address_2_'.$i]));
        }
        if (!empty($_POST['self_managed_funding_type_attendee_city_'.$i])) {
            update_post_meta($order_id, 'Self-Managed City of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_city_'.$i]));
        }
        if (!empty($_POST['self_managed_funding_type_attendee_state_'.$i])) {
            update_post_meta($order_id, 'Self-Managed State of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_state_'.$i]));
        }
        if (!empty($_POST['self_managed_funding_type_attendee_postcode_'.$i])) {
            update_post_meta($order_id, 'Self-Managed Postcode of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_postcode_'.$i]));
        }
        
        //self manage funding type end

        //plan manage funding type start

        if (!empty($_POST['plan_managed_funding_type_attendee_first_name_'.$i])) {
            update_post_meta($order_id, 'Plan-Managed First Name of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_first_name_'.$i]));
        }
        if (!empty($_POST['plan_managed_funding_type_attendee_last_name_'.$i])) {
            update_post_meta($order_id, 'Plan-Managed Last Name of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_last_name_'.$i]));
        }
        if (!empty($_POST['plan_managed_funding_type_attendee_email_'.$i])) {
            update_post_meta($order_id, 'Plan-Managed Email of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_email_'.$i]));
        }
        if (!empty($_POST['plan_managed_funding_type_attendee_phone_'.$i])) {
            update_post_meta($order_id, 'Plan-Managed Phone Number of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_phone_'.$i]));
        }
        if (!empty($_POST['plan_managed_funding_type_attendee_dob_'.$i])) {
            update_post_meta($order_id, 'Plan-Managed DOB of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_dob_'.$i]));
        }
        if (!empty($_POST['plan_managed_funding_type_attendee_gender_'.$i])) {
            update_post_meta($order_id, 'Plan-Managed Gender of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_gender_'.$i]));
        }
        if (!empty($_POST['plan_managed_funding_type_attendee_address_1_'.$i])) {
            update_post_meta($order_id, 'Plan-Managed Address 1 of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_address_1_'.$i]));
        }
        if (!empty($_POST['plan_managed_funding_type_attendee_address_2_'.$i])) {
            update_post_meta($order_id, 'Plan-Managed Address 2 of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_address_2_'.$i]));
        }
        if (!empty($_POST['plan_managed_funding_type_attendee_city_'.$i])) {
            update_post_meta($order_id, 'Plan-Managed City of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_city_'.$i]));
        }
        if (!empty($_POST['plan_managed_funding_type_attendee_state_'.$i])) {
            update_post_meta($order_id, 'Plan-Managed State of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_state_'.$i]));
        }
        if (!empty($_POST['plan_managed_funding_type_attendee_postcode_'.$i])) {
            update_post_meta($order_id, 'Plan-Managed Postcode of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_postcode_'.$i]));
        }

        //end plan managed 

        // start ndia managed

        if (!empty($_POST['ndia_managed_funding_type_attendee_ndia_number_'.$i])) {
            update_post_meta($order_id, 'Plan-Managed First Name of Attendee'.$i, sanitize_text_field($_POST['ndia_managed_funding_type_attendee_ndia_number_'.$i]));
        }
        
    }

}


/**
 * Add fields to order emails
 **/
add_filter('woocommerce_email_order_meta_keys', 'my_custom_checkout_field_order_meta_keys');
function my_custom_checkout_field_order_meta_keys( $keys ) {
	global $woocommerce;
    $count = $woocommerce->cart->cart_contents_count;
    $i = 0;
    for($k=1; $k<= $count; $k++) {
        $i++;
        echo '<div class="Attendee-group"><h4>Attendee Details </h4>';
        $keys[] = 'First Name of Attendee'.$i;
        $keys[] = 'Last Name of Attendee'.$i;
        echo '</div>';
    }	
return $keys;


}


// add_filter( 'woocommerce_email_order_meta_fields', 'custom_woocommerce_email_order_meta_fields', 10, 3 );

// function custom_woocommerce_email_order_meta_fields( $keys, $sent_to_admin, $order ) {
//     $i = 0;
// 	for($k=1; $k<= 50; $k++) {
//         $i++;
//     echo '<div class="ndia-managed-funding-text Attendee-group"><h3>Name of Attendee' .$i. '</h3>';
//     $keys['attendee_first_name_'] = array(
//         'label' => __( 'First of Attendee' ),
//         'value' => get_post_meta( $order->id, 'attendee_first_name_', true ),
//     );
//     $keys['attendee_first_name_'] = array(
//         'label' => __( 'Last of Attendee' ),
//         'value' => get_post_meta( $order->id, 'attendee_last_name_', true ),
//     );
//     echo '</div>';
//  }
//     return $keys;
// }

