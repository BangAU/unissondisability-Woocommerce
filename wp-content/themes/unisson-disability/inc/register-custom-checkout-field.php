<?php 

//Custom WooCommerce Checkout Fields based on Quantity

add_action( 'woocommerce_before_order_notes', 'person_details' );

function person_details($checkout) {

    global $woocommerce;
    $count = $woocommerce->cart->cart_contents_count;
    $i = 0;

    
           for($k=1; $k<= $count; $k++) {
             

            $i++;
            // foreach(WC()->cart->get_cart() as $cart_item ){
            //     $_product = $cart_item['data']->post;  

            echo '<div class="Attendee-group"><h4>'.  __('<span class="attendee-title">Attendee ' . $i . ' </span>' )  . $_product->post_title .'</h4>';

            woocommerce_form_field( 'attendee_product_title_' . $i, array(
                'type'          => 'hidden',
                'class'         => array('attendee form-row-first'),
                // 'label'         => __('Attendee product title '),
                'placeholder'   => __(''),
                'required' => true,
                'value'            => 'test',
                'default' =>  " $_product->post_title "
                ), $checkout->get_value( 'attendee_product_title_' . $i ) );
         //firstname
        woocommerce_form_field( 'attendee_first_name_' . $i, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-first'),
            'label'         => __('First Name '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_first_name_' . $i ) );
        // lastname
        woocommerce_form_field( 'attendee_last_name_' . $i, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-last'),
            'label'         => __('Last Name '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_last_name_' . $i ));
        //email
        woocommerce_form_field( 'attendee_email_' . $i, array(
            'type'          => 'email',
            'class'         => array('attendee form-row-wide'),
            'label'         => __('Email '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_email_' . $i ));
        
        //phone
        woocommerce_form_field( 'attendee_phone_' . $i, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-wide'),
            'label'         => __('Phone '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_phone_' . $i ));
        //DOB
        woocommerce_form_field( 'attendee_dob_' . $i, array(
            'type'          => 'date',
            'class'         => array('attendee form-row-first'),
            'label'         => __('DOB '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_dob_' . $i ));
        //gender
        woocommerce_form_field( 'attendee_gender_' . $i, array(
            'type' => 'select',
            'class' => array('my-field-class form-row-last'),
            'label' => __('Gender'),
            'required' => true,
            'options' => array(
            // 'blank'  => __( '--'),
            'Male' => __( 'Male'),
            'Female' => __( 'Female'),
            'Others' => __( 'Others' )
            )
            ), $checkout->get_value( 'attendee_gender_' . $i ));
        //Address one 
        woocommerce_form_field( 'attendee_address_1_' . $i, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-wide'),
            'label'         => __('Address '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_address_1_' . $i ));
        //Address 2
        woocommerce_form_field( 'attendee_address_2_' . $i, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-wide'),
            'label'         => __('Apartment, Suite, etc. '),
            'placeholder'   => __(''),
            ), $checkout->get_value( 'attendee_address_2_' . $i ));
        //City
        woocommerce_form_field( 'attendee_city_' . $i, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-wide address-field'),
            'label'         => __('Suburb/City '),
            'placeholder'   => __(''),
            ), $checkout->get_value( 'attendee_city_' . $i ));
        //State
        woocommerce_form_field( 'attendee_state_' . $i, array(
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
            ), $checkout->get_value( 'attendee_gender_' . $i ));
        //Passcode
        woocommerce_form_field( 'attendee_postcode_' . $i, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-wide address-field'),
            'label'         => __('Postcode '),
            'placeholder'   => __(''),
            'required' => true,
            ), $checkout->get_value( 'attendee_postcode_' . $i ));

            echo '<div class="Attendee-group-funding-type"><h4>Funding Type*</h4>';  echo '</div>';

            woocommerce_form_field( '_funding_type_radio_'. $i, array(
                'type' => 'radio',
                'class' => array('funding-type-radio'),
                'required' => 'required',
                'options' => array(
                'Self_managed' => __( 'Self-managed'),
                'Plan_managed' => __( 'Plan-managed'),
                'Ndia_managed' => __( 'NDIA-managed' ),
                ),
               // 'default'  => 'Self_managed',

            ), $checkout->get_value( '_funding_type_radio_' . $i ));

           // echo '<div class=" funding-type-description"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut               enim ad minim veniam, quis nostrud exercitation ullamco labori</p></div>';

            //funding type radio ending

        echo '<div class="self_manage_funding_text Attendee-group">';
            
             //self manage
             echo '<div class="Attendee-group"><h4>Self-managed details for invoicing</h4></div>';
             //firstname
             woocommerce_form_field( 'self_managed_funding_type_attendee_first_name_' . $i, array(
                 'type'          => 'text',
                 'class'         => array('form-row-first'),
                 'label'         => __('First Name '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $user, $checkout->get_value( 'self_managed_funding_type_attendee_first_name_' . $i ) );
             // lastname
             woocommerce_form_field( 'self_managed_funding_type_attendee_last_name_' . $i, array(
                 'type'          => 'text',
                 'class'         => array('form-row-last'),
                 'label'         => __('Last Name '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_last_name_' . $i ));
             //email
             woocommerce_form_field( 'self_managed_funding_type_attendee_email_' . $i, array(
                 'type'          => 'email',
                 'class'         => array('form-row-wide'),
                 'label'         => __('Email '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_email_' . $i ));
             
             //phone
             woocommerce_form_field( 'self_managed_funding_type_attendee_phone_' . $i, array(
                 'type'          => 'text',
                 'class'         => array('form-row-wide'),
                 'label'         => __('Phone '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_phone_' . $i ));
             //DOB
            //  woocommerce_form_field( 'self_managed_funding_type_attendee_dob_' . $i, array(
            //      'type'          => 'date',
            //      'class'         => array('form-row-first'),
            //      'label'         => __('DOB '),
            //      'placeholder'   => __(''),
            //      'required' => true,
            //      ), $checkout->get_value( 'self_managed_funding_type_attendee_dob_' . $i ));
             //gender
            //  woocommerce_form_field( 'self_managed_funding_type_attendee_gender_' . $i, array(
            //      'type' => 'select',
            //      'class' => array('form-row-last'),
            //      'label' => __('Gender'),
            //      'required' => true,
            //      'options' => array(
            //      'blank'  => __( '--'),
            //      'Male' => __( 'Male'),
            //      'Female' => __( 'Female'),
            //      'Others' => __( 'Others' )
            //      )
            //      ), $checkout->get_value( 'self_managed_funding_type_attendee_gender_' . $i ));
             //Address one 
             woocommerce_form_field( 'self_managed_funding_type_attendee_address_1_' . $i, array(
                 'type'          => 'text',
                 'class'         => array('form-row-wide'),
                 'label'         => __('Address '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_address_1_' . $i ));
             //Address 2
             woocommerce_form_field( 'self_managed_funding_type_attendee_address_2_' . $i, array(
                 'type'          => 'text',
                 'class'         => array('form-row-wide'),
                 'label'         => __('Apartment, Suite, etc. '),
                 'placeholder'   => __(''),
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_address_2_' . $i ));
             //City
             woocommerce_form_field( 'self_managed_funding_type_attendee_city_' . $i, array(
                 'type'          => 'text',
                 'class'         => array('form-row-wide address-field'),
                 'label'         => __('Suburb/City '),
                 'placeholder'   => __(''),
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_city_' . $i ));
             //State
             woocommerce_form_field( 'self_managed_funding_type_attendee_state_' . $i, array(
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
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_state_' . $i ));
             //Passcode
             woocommerce_form_field( 'self_managed_funding_type_attendee_postcode_' . $i, array(
                 'type'          => 'text',
                 'class'         => array('form-row-wide address-field'),
                 'label'         => __('Postcode '),
                 'placeholder'   => __(''),
                 'required' => true,
                 ), $checkout->get_value( 'self_managed_funding_type_attendee_postcode_' . $i ));
                     
         echo '</div>';


           //plan manage funding type
           echo '<div class="plan-managed-funding-text Attendee-group">';
           //self manage
           echo '<div class="plan-managed-funding-text Attendee-group"><h4>Plan Managed</h4></div>';
           //firstname
           woocommerce_form_field( 'plan_managed_funding_type_attendee_first_name_' . $i, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-first'),
               'label'         => __('First Name '),
               'placeholder'   => __(''),
               'required' => true,
               ), $user, $checkout->get_value( 'plan_managed_funding_type_attendee_first_name_' . $i ) );
           // lastname
           woocommerce_form_field( 'plan_managed_funding_type_attendee_last_name_' . $i, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-last'),
               'label'         => __('Last Name '),
               'placeholder'   => __(''),
               'required' => true,
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_last_name_' . $i ));
           //email
           woocommerce_form_field( 'plan_managed_funding_type_attendee_email_' . $i, array(
               'type'          => 'email',
               'class'         => array('plan-managed-funding-text form-row-wide'),
               'label'         => __('Email '),
               'placeholder'   => __(''),
               'required' => true,
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_email_' . $i ));
           
           //phone
           woocommerce_form_field( 'plan_managed_funding_type_attendee_phone_' . $i, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-wide'),
               'label'         => __('Phone '),
               'placeholder'   => __(''),
               'required' => true,
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_phone_' . $i ));
           //DOB
        //    woocommerce_form_field( 'plan_managed_funding_type_attendee_dob_' . $i, array(
        //        'type'          => 'date',
        //        'class'         => array('atteplan-managed-funding-text form-row-first'),
        //        'label'         => __('DOB '),
        //        'placeholder'   => __(''),
        //        'required' => true,
        //        ), $checkout->get_value( 'plan_managed_funding_type_attendee_dob_' . $i ));
           //gender
        //    woocommerce_form_field( 'plan_managed_funding_type_attendee_gender_' . $i, array(
        //        'type' => 'select',
        //        'class' => array('plan-managed-funding-text form-row-last'),
        //        'label' => __('Gender'),
        //        'required' => true,
        //        'options' => array(
        //     //    'blank'  => __( '--'),
        //        'Male' => __( 'Male'),
        //        'Female' => __( 'Female'),
        //        'Others' => __( 'Others' )
        //        )
        //        ), $checkout->get_value( 'plan_managed_funding_type_attendee_gender_' . $i ));
           //Address one 
           woocommerce_form_field( 'plan_managed_funding_type_attendee_address_1_' . $i, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-wide'),
               'label'         => __('Address '),
               'placeholder'   => __(''),
               'required' => true,
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_address_1_' . $i ));
           //Address 2
           woocommerce_form_field( 'plan_managed_funding_type_attendee_address_2_' . $i, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-wide'),
               'label'         => __('Apartment, Suite, etc. '),
               'placeholder'   => __(''),
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_address_2_' . $i ));
           //City
           woocommerce_form_field( 'plan_managed_funding_type_attendee_city_' . $i, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-wide address-field'),
               'label'         => __('Suburb/City '),
               'placeholder'   => __(''),
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_city_' . $i ));
           //State
           woocommerce_form_field( 'plan_managed_funding_type_attendee_state_' . $i, array(
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
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_state_' . $i ));
           //Passcode
           woocommerce_form_field( 'plan_managed_funding_type_attendee_postcode_' . $i, array(
               'type'          => 'text',
               'class'         => array('plan-managed-funding-text form-row-wide address-field'),
               'label'         => __('Postcode '),
               'placeholder'   => __(''),
               'required' => true,
               ), $checkout->get_value( 'plan_managed_funding_type_attendee_postcode_' . $i ));
   
           
             echo '</div>';

             echo '<div class="ndia-managed-funding-text Attendee-group">';
                //self manage
                echo '<div class="ndia-managed-funding-text Attendee-group"><h4>NDIA-managed details </h4></div>';
                //firstname
                woocommerce_form_field( 'ndia_managed_funding_type_attendee_ndia_number_' . $i, array(
                    'type'          => 'text',
                    'class'         => array('ndia-managed-funding-text form-row-first'),
                    'label'         => __('NDIA Number (If applicable) '),
                    'placeholder'   => __(''),
                    ), $checkout->get_value( 'ndia_managed_funding_type_attendee_ndia_number_' . $i ) );
             
            echo '</div>';

        echo '</div>';

        //funding type starting

     
   // }
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

    // var_dump($count);
    // die;
        if (!empty($_POST['attendee_product_title_'.$i])) {
            update_post_meta($order_id, 'Tour Title of Attendee'.$i, sanitize_text_field($_POST['attendee_product_title_'.$i]) );
        }
        if (!empty($_POST['attendee_first_name_'.$i])) {
            update_post_meta($order_id, 'First Name of Attendee'.$i, sanitize_text_field($_POST['attendee_first_name_'.$i]) );
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
        // if (!empty($_POST['self_managed_funding_type_attendee_dob_'.$i])) {
        //     update_post_meta($order_id, 'Self-Managed DOB of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_dob_'.$i]));
        // }
        // if (!empty($_POST['self_managed_funding_type_attendee_gender_'.$i])) {
        //     update_post_meta($order_id, 'Self-Managed Gender of Attendee'.$i, sanitize_text_field($_POST['self_managed_funding_type_attendee_gender_'.$i]));
        // }
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
        // if (!empty($_POST['plan_managed_funding_type_attendee_dob_'.$i])) {
        //     update_post_meta($order_id, 'Plan-Managed DOB of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_dob_'.$i]));
        // }
        // if (!empty($_POST['plan_managed_funding_type_attendee_gender_'.$i])) {
        //     update_post_meta($order_id, 'Plan-Managed Gender of Attendee'.$i, sanitize_text_field($_POST['plan_managed_funding_type_attendee_gender_'.$i]));
        // }
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
//add_action('woocommerce_order_details_after_order_table', 'my_custom_checkout_field_order_meta_keys' ); // Order received and view
add_action( 'woocommerce_email_after_order_table', 'my_custom_checkout_field_order_meta_keys' ); // Email notifications
//add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_order_meta_keys' ); // Admin edit Order
add_action('woocommerce_email_order_meta_keys', 'my_custom_checkout_field_order_meta_keys');

function my_custom_checkout_field_order_meta_keys( $keys ) {
    global $woocommerce;
    $count = $woocommerce->cart->cart_contents_count;
    $i = 0;
    echo '<h2>' . __( 'Attendee details', 'woocommerce' ) . '</h2>';
           for($k=1; $k<= $count; $k++) {
            $i++;
        
            $keys[] = 'First Name of Attendee'.$i; 
            $keys[] = 'Last Name of Attendee'.$i;
            
        //echo '</div>';

    }	
    return $keys;
    }





    // add_action('woocommerce_order_details_after_order_table', 'custom_checkout_field_update_meta'); 
    // function custom_checkout_field_update_meta($order_id) {
    //     global $woocommerce;
    //     $count = $woocommerce->cart->cart_contents_count;
    //     $i = 0;
    //            for($k=1; $k<= $count; $k++) {
    //             $i++;
    
      
    //         if (!empty($_POST['attendee_first_name_'.$i])) {
    //             update_post_meta($order_id, 'First Name of Attendee'.$i, sanitize_text_field($_POST['attendee_first_name_'.$i]) );
    //         }
            
            
    //     }
    
    // }

    // add_filter( 'woocommerce_get_order_item_totals', 'display_delivery_on_order_item_totals', 10, 3 );
    // function display_delivery_on_order_item_totals( $total_rows, $order, $tax_display ){
    //     global $woocommerce;
    //     $count = $woocommerce->cart->cart_contents_count;
    //     $i = 0;
    //            for($k=1; $k<= $count; $k++) {
    //             $i++;
    
      
    //         if (!empty($_POST['attendee_first_name_'.$i])) {
    //             update_post_meta($order_id, 'First Name of Attendee'.$i, sanitize_text_field($_POST['attendee_first_name_'.$i]) );
    //         }
            
            
    //     }
    // }