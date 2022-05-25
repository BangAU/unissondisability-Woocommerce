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
    $x = 1;

    while ($x <= $quantity) {

         echo '<div class="Attendee-group"><h3>' . $_product->post_title .  __(' - Attendee ' . $x . '') .'</h3>';
       
        woocommerce_form_field( 'attendee_name_' . $x, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-first'),
            'label'         => __('First Name ' . $x . ' First Name'),
            'placeholder'   => __(''),
            ), $checkout->get_value( 'attendee_first_name_' . $x ));

        woocommerce_form_field( 'attendee_name_' . $x, array(
            'type'          => 'text',
            'class'         => array('attendee form-row-last'),
            'label'         => __('Last Name ' . $x . ' Last Name'),
            'placeholder'   => __(''),
            ), $checkout->get_value( 'attendee_last_name_' . $x ));

        woocommerce_form_field( 'camper_grade_' . $x, array(
            'type'          => 'select',
            'class'         => array('camper form-row-wide'),
            'label'         => __('Camper ' . $x . ' Grade'),
            'placeholder'   => __(''),
            'options'       => array(
                'blank'     => __( 'Select a grade', 'wps' ),
                '1st'       => __( '1st', 'wps' ),
                '2nd'       => __( '2nd', 'wps' ),
                '3rd'       => __( '3rd', 'wps' ),
                '4th'       => __( '4th', 'wps' ),
                '5th'       => __( '5th', 'wps' ),
                '6th'       => __( '6th', 'wps' ),
                '7th'       => __( '7th', 'wps' ),
                '8th'       => __( '8th', 'wps' ),
                '9th'       => __( '9th', 'wps' ),
                '10th'      => __( '10th', 'wps' )

            )
            ), $checkout->get_value( 'camper_grade_' . $x ));

        woocommerce_form_field( 'camper_school_' .$x, array(
            'type'          => 'text',
            'class'         => array('camper form-row-wide'),
            'label'         => __('Camper ' . $x . ' School Name'),
            'placeholder'   => __('The school your child will attend next fall'),
            ), $checkout->get_value( 'camper_school_' . $x ));

        echo '</div>';
        $x++;
    }

    $i++;
    } 

}