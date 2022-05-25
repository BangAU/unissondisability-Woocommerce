<?php

namespace Deposits_WooCommerce;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Product {

    public function __construct() {

        add_action( 'woocommerce_before_add_to_cart_button', [$this, 'before_add_to_cart'], 10 );
        add_action( 'woocommerce_product_data_tabs', [$this, 'product_tab'] );
        add_action( 'woocommerce_product_data_panels', [$this, 'options_fields'] );
        add_action( 'woocommerce_process_product_meta', [$this, 'save_product_metadata'] );
        add_action( 'woocommerce_product_after_variable_attributes', [$this, 'variations_fields'], 10, 3 );
        add_action( 'woocommerce_save_product_variation', [$this, 'variations_fields_save'], 10, 2 );
        add_action( 'admin_head', [$this, 'deposit_icon'] );
        add_action( 'wp_enqueue_scripts', [$this, 'scripts'] );
        add_filter( 'woocommerce_add_cart_item_data', [$this, 'add_item_data'], 10, 3 );
        add_filter( 'woocommerce_add_to_cart_validation', [$this, 'validate_frontend_input'], 10, 3 );
    }

    /**
     * add item data based on deposit option
     *
     * @param  array            $cart_item_data
     * @param  int              $product_id
     * @return cart_item_data
     */
    public function add_item_data( $cart_item_data, $product_id, $variation_id ) {

        $vProductId = ( $variation_id ) ? $variation_id : $product_id;

        if ( cidw_get_option( 'global_deposits_mode' ) == 1 && !empty( cidw_get_option( 'global_deposits_value' ) ) ) {
            $deposit_value = apply_filters( 'deposits_value', get_post_meta( $vProductId, '_deposits_value', true ) );

            $product = wc_get_product( $vProductId );
            $value   = ( $deposit_value / 100 ) * $product->get_price();

            $cart_item_data['_deposit']      = $value;
            $cart_item_data['_due_payment']  = $product->get_price() - $value;
            $cart_item_data['_deposit_mode'] = 'check_deposit';
        } else {
            $deposit_checked = WC()->session->get( 'deposit_checked' );

            if ( $deposit_checked == 'yes' ) {
                $product = wc_get_product( $vProductId );

                $deposit_value = get_post_meta( $vProductId, '_deposits_value', true );

                if ( get_post_meta( $vProductId, '_deposits_type', true ) == 'percent' ) {
                    $deposit_value = get_post_meta( $vProductId, '_deposits_value', true );
                    $deposit_value = ( $deposit_value / 100 ) * $product->get_price();
                }

                $cart_item_data['_deposit']      = $deposit_value;
                $cart_item_data['_due_payment']  = $product->get_price() - $deposit_value;
                $cart_item_data['_deposit_mode'] = 'check_deposit';
            }
        }

        return $cart_item_data;
    }

    /**
     * enqueue scripts and styles
     */
    public function scripts() {
        wp_register_script( 'dfwc-public', CIDW_DEPOSITS_ASSETS . '/js/public.js', ['jquery'], CIDW_DEPOSITS_VERSION, true );

        // run only product page
        wp_enqueue_style( 'pretty-checkbox', CIDW_DEPOSITS_ASSETS . '/css/pretty-checkbox.min.css', [], CIDW_DEPOSITS_VERSION );
        $activeColor = cidw_get_option( 'cidw_box_active_color' );

        $custom_css = "

            .pretty.p-default input:checked~.state label:after,
            .pretty.p-default:not(.p-fill) input:checked~.state.p-primary-o label:after
            {
                            background: {$activeColor} !important;
            }
            .pretty input:checked~.state.p-primary-o label:before, .pretty.p-toggle .state.p-primary-o label:before {
                border-color: {$activeColor} !important;
            }";

        wp_add_inline_style( 'pretty-checkbox', $custom_css );

        $params = array(
            'ajax_url'                => admin_url( 'admin-ajax.php', 'relative' ),
            'ajax_nonce'              => wp_create_nonce( 'deposits_nonce' ),
            'deposit_active_variable' => get_post_meta( get_the_ID(), '_enable_variation_deposit', true ),

        );
        wp_localize_script( 'dfwc-public', 'deposits_params', $params );

        wp_enqueue_style( 'dfwc-public', CIDW_DEPOSITS_ASSETS . '/css/dfwc-public.css', [], CIDW_DEPOSITS_VERSION );
        wp_enqueue_script( 'dfwc-public' );
    }

    /**
     * vaildate desposit input
     *
     * @param  [boolen] $passed
     * @param  [int]    $product_id
     * @param  [int]    $quantity
     * @return boolen
     */
    public function validate_frontend_input( $passed, $product_id, $quantity ) {
        if ( !WC()->cart->is_empty() && cidw_cart_have_deposit_item() && cidw_is_product_type_deposit( $product_id ) == false && apply_filters( 'deposits_mode', true ) ) {
            $passed = false;
            wc_add_notice( cidw_get_option( 'deposit_notice' ), 'error' );
            return $passed;
        }

        if ( !WC()->cart->is_empty() && cidw_cart_have_deposit_item() == false && cidw_is_product_type_deposit( $product_id ) && apply_filters( 'deposits_mode', true ) ) {
            $passed = false;
            wc_add_notice( cidw_get_option( 'regular_notice' ),'error');
            return $passed;
        }

        if ( cidw_is_product_type_deposit( $product_id ) == false ) {
            return $passed;
        }

        return $passed;
    }

    /**
     * Add elements before add to cart form
     * on the single product page
     */
    public function before_add_to_cart() {
        $product = wc_get_product( get_the_ID() );

        if ( cidw_is_product_type_deposit( get_the_ID() ) ) {
            $deposit_type  = apply_filters( 'deposits_type', get_post_meta( get_the_ID(), '_deposits_type', true ) );
            $deposit_value = apply_filters( 'deposits_value', get_post_meta( get_the_ID(), '_deposits_value', true ) );
            if ( $deposit_type == 'percent' ) {
                $deposit_value  = ( $deposit_value / 100 ) * $product->get_price();
                $deposit_amount = $deposit_value;
            } else {
                $deposit_amount = $deposit_value;
            }

            $deposit_text = apply_filters( 'single_product_deposits_notice', cidw_get_option( 'txt_deposit_msg', 'Deposit : %s Per item' ), wc_price( $deposit_amount ) );?>
            <div class="deposits-frontend-wrapper">
            <p class="deposit-notice"><?php echo $deposit_text; ?></p>
            <div class="deposits-input-wrapper">
                <div class="pretty <?php echo esc_attr( cidw_get_option( 'cidw_radio_theme' ) ); ?>">
                <input type="radio" name="deposit-mode" value="check_full" >
                <div class="state p-primary-o">
                    <?php if ( cidw_get_option( 'cidw_radio_theme' ) == 'p-image p-plain' ) {
                echo '<img class="image" src="' . cidw_get_option( 'cidw_radio_theme_image' ) . '">';
                }?>

                        <label><?php echo esc_html( cidw_get_option( 'txt_full_payment', 'Full Payment' ) ); ?></label>
                    </div>
                </div>

                <div class="pretty <?php echo esc_attr( cidw_get_option( 'cidw_radio_theme' ) ); ?>">
                    <input type="radio" name="deposit-mode" value="check_deposit" <?php echo ( $deposit_value || isset( $_POST['deposit-mode'] ) && $_POST['deposit-mode'] == 'check_deposit' || !isset( $_POST['deposit-mode'] ) ) ? 'checked' : '' ?>>
                    <div class="state p-primary-o">
                        <?php if ( cidw_get_option( 'cidw_radio_theme' ) == 'p-image p-plain' ) {
                    echo '<img class="image" src="' . cidw_get_option( 'cidw_radio_theme_image' ) . '">';
                }?>

                        <label><?php echo esc_html( cidw_get_option( 'txt_pay_deposit', 'Pay Deposit' ) ); ?></label>
                    </div>
                </div>
            </div>
           
            <span style="margin-bottom:15px;display: block;"></span>
            </div>


        <?php }
    }
    /**
     * Add deposits icon
     */
    public function deposit_icon() {
        echo '<style>
        #woocommerce-product-data ul li.deposits_options.deposits_tab a:before{
            content:"\f184";
        }
        </style>';
    }
    /**
     * Following code Saves  WooCommerce Product deposits Custom Fields
     */
    public function save_product_metadata( $post_id ) {

        $field_enable_deposit = isset( $_POST['_enable_deposit'] ) ? 'yes' : 'no';
        $variationDeposit     = isset( $_POST['_enable_variation_deposit'] ) ? 'yes' : 'no';
        $field_deposits_type  = sanitize_text_field( $_POST['_deposits_type'] );
        $field_deposits_value = sanitize_text_field( $_POST['_deposits_value'] );

        update_post_meta( $post_id, '_enable_deposit', $field_enable_deposit );
        update_post_meta( $post_id, '_enable_variation_deposit', $variationDeposit );

        if ( !empty( $field_deposits_type ) ) {
            update_post_meta( $post_id, '_deposits_type', $field_deposits_type );
        }
        if ( !empty( $field_deposits_value ) ) {
            update_post_meta( $post_id, '_deposits_value', intval( $field_deposits_value ) );
        }

    }

    /**
     * Add a custom product tab.
     * @param  array   $tabs
     * @return mixed
     */
    public function product_tab( $tabs ) {
        $tabs['deposits'] = array(
            'label'  => __( 'Deposit', 'deposits-for-woocommerce' ),
            'target' => 'woo_desposits_options',
            'class'  => array( 'show_if_simple', 'show_if_variable' ),
        );

        return $tabs;
    }
    /**
     * Fileds for Deposits tab
     */
    public function options_fields() {
        ?>
        <div id="woo_desposits_options" class="panel woocommerce_options_panel">
        <div class="options_group deposit-variation-option" style="display:none">
        <?php woocommerce_wp_checkbox(
            array(
                'id'          => '_enable_variation_deposit',
                'label'       => __( 'Enable Deposit', 'deposits-for-woocommerce' ),
                'value'       => get_post_meta( get_the_ID(), '_enable_variation_deposit', true ),
                'description' => __( 'Enable deposit feature for this Variable product.', 'deposits-for-woocommerce' ),
            )
        );
        ?>
        </div>
        <div class="options_group deposit-simple-options">
            <?php

        woocommerce_wp_checkbox(
            array(
                'id'          => '_enable_deposit',
                'label'       => __( 'Enable Deposit', 'deposits-for-woocommerce' ),
                'value'       => get_post_meta( get_the_ID(), '_enable_deposit', true ),
                'description' => __( 'Enable deposits feature for this product.', 'deposits-for-woocommerce' ),
            )
        );

        // Type.
        woocommerce_wp_select(
            array(
                'id'      => '_deposits_type',
                'label'   => __( 'Deposit type', 'deposits-for-woocommerce' ),
                'class'   => 'wc-enhanced-select',
                'options' => [
                    'percent' => __( 'Percentage of Amount', 'deposits-for-woocommerce' ),
                    'fixed'   => __( 'Fixed Amount', 'deposits-for-woocommerce' ),
                ],
                'value'   => get_post_meta( get_the_ID(), '_deposits_type', true ),
            )
        );
        woocommerce_wp_text_input(
            array(
                'id'          => '_deposits_value',
                'label'       => __( 'Deposit Value *', 'deposits-for-woocommerce' ),
                // 'wrapper_class' => 'show_if_simple', //show_if_simple or show_if_variable
                'placeholder' => '',
                'value'       => get_post_meta( get_the_ID(), '_deposits_value', true ),
                'style'       => 'width:60px;',
                'description' => __( 'Enter the value for deposit. only number allow.', 'deposits-for-woocommerce' ),
            )
        );

        do_action( 'deposits_options_fileds' );?>
        </div>
        </div>
    <?php }

    /**
     * Add deposit Fields to variable products
     *
     * @since 2.0.3
     *
     * @param $loop
     * @param $variation_data
     * @param $variation
     */
    public function variations_fields( $loop, $variation_data, $variation ) {
        echo '<div class="bayna-variable-options options_group woocommerce_options_panel form-row form-row-full ">';
        woocommerce_wp_checkbox(
            array(
                'id'          => '_enable_deposit' . $variation->ID,
                'label'       => __( 'Enable Deposit', 'deposits-for-woocommerce' ),
                'value'       => get_post_meta( $variation->ID, '_enable_deposit', true ),
                'description' => __( 'Enable deposits feature for this product.', 'deposits-for-woocommerce' ),
            )
        );

        woocommerce_wp_select(
            array(
                'id'      => '_deposits_type' . $variation->ID,
                'label'   => __( 'Deposit type', 'deposits-for-woocommerce' ),
                'class'   => 'wc-enhanced-select',
                'options' => [
                    'percent' => __( 'Percentage of Amount', 'deposits-for-woocommerce' ),
                    'fixed'   => __( 'Fixed Amount', 'deposits-for-woocommerce' ),
                ],
                'value'   => get_post_meta( $variation->ID, '_deposits_type', true ),
            )
        );
        woocommerce_wp_text_input(
            array(
                'id'          => '_deposits_value' . $variation->ID,
                'label'       => __( 'Deposit Value *', 'deposits-for-woocommerce' ),
                // 'wrapper_class' => 'show_if_simple', //show_if_simple or show_if_variable
                'placeholder' => '',
                'value'       => get_post_meta( $variation->ID, '_deposits_value', true ),
                'style'       => 'width:60px;',
                'description' => __( 'Enter the value for deposit. only number allow.', 'deposits-for-woocommerce' ),
            )
        );

        do_action( 'deposits_options_fileds' );

        echo '</div>';
    }

    /**
     * Save our variable product fields
     *  @since 2.0.3
     * @param $post_id
     */
    public function variations_fields_save( $post_id ) {
        // $variation_id = $_POST['variable_post_id'][array_keys($_POST['variable_post_id'])[0]];
        $product = wc_get_product( $post_id );

        $enableDeposit = isset( $_POST['_enable_deposit' . $post_id] ) ? 'yes' : 'no';

        $depositType  = sanitize_text_field( $_POST['_deposits_type' . $post_id] );
        $depositValue = sanitize_text_field( $_POST['_deposits_value' . $post_id] );

        $product->update_meta_data( '_enable_deposit', $enableDeposit );

        $product->update_meta_data( '_deposits_type', $depositType );
        $product->update_meta_data( '_deposits_value', $depositValue );

        $product->save();
    }

}
