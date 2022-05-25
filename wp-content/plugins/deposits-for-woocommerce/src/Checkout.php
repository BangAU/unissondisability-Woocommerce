<?php
namespace Deposits_WooCommerce;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Checkout {

    public function __construct() {
        add_action( 'woocommerce_review_order_after_order_total', [$this, 'to_pay_html'] );
        add_filter( 'woocommerce_payment_complete_order_status', [$this, 'manage_deposit_orders'], 10, 3 );
        add_filter( 'woocommerce_cod_process_payment_order_status', [$this, 'offline_deposit_orders'], 10, 2 );
        add_filter( 'woocommerce_bacs_process_payment_order_status', [$this, 'offline_deposit_orders'], 10, 2 );
        add_filter( 'woocommerce_cheque_process_payment_order_status', [$this, 'offline_deposit_orders'], 10, 2 );
        add_filter( 'woocommerce_checkout_cart_item_quantity', [$this, 'display_item_deposit_data'], 20, 3 );
        add_filter( 'woocommerce_checkout_create_order_line_item', [$this, 'save_cart_order_meta'], 20, 4 );
        add_filter( 'woocommerce_available_payment_gateways', [$this, 'conditional_payment_gateways'], 20, 1 );
        add_action( 'woocommerce_checkout_update_order_meta', [$this, 'manage_order'], 10, 2 );
        add_action( 'woocommerce_order_status_completed', [$this, 'deposits_completed'], 10, 1 );
        add_action( 'bayna_all_deposit_payments_paid', [$this, 'update_parent_order_metadata'], 10, 1 );

        do_action( 'wc_deposit_checkout', $this );
    }

    /**
     * update order meta data (due Ammount)
     * since all child orders are completed
     * @param $orderID
     */
    public function update_parent_order_metadata( $orderID ) {
        update_post_meta( $orderID, '_order_due_ammount', 0 );
    }

    /**
     * @param  $status
     * @param  $orderId
     * @param  $order
     * @return mixed
     */
    public function offline_deposit_orders( $status, $order ) {
        $orderId = $order->get_id();
        if ( bayna_order_has_deposit( $orderId ) ) {

            $due_ammount = $order->get_total() - get_post_meta( $orderId, '_deposit_value', true );
            update_post_meta( $orderId, '_order_due_ammount', $due_ammount );
            $order->save();

            $order->calculate_shipping();
            $order->calculate_totals();

        }

        if ( bayna_order_has_deposit( $orderId ) && get_post_meta( $orderId, '_genarate_deposit_orders', true ) != 1 ) {
            // create deposit orders based on parent order
            $this->genarate_deposit_order( $order );
            // Set main order status 'deposit' after payment complete
            return 'wc-deposit';
        }
        return $status;
    }
    /**
     * @param  $status
     * @param  $orderId
     * @param  $order
     * @return mixed
     */
    public function manage_deposit_orders( $status, $orderId, $order ) {

        if ( bayna_order_has_deposit( $orderId ) ) {

            $due_ammount = $order->get_total() - get_post_meta( $orderId, '_deposit_value', true );
            update_post_meta( $orderId, '_order_due_ammount', $due_ammount );
            $order->save();

            $order->calculate_shipping();
            $order->calculate_totals();

        }

        if ( bayna_order_has_deposit( $orderId ) && get_post_meta( $orderId, '_genarate_deposit_orders', true ) != 1 ) {
            // create deposit orders based on parent order
            $this->genarate_deposit_order( $order );
            // Set main order status 'deposit' after payment complete
            return 'wc-deposit';
        }
        return $status;
    }

    /**
     * change parent order status based on deposit order
     *
     * @param  [int]    $orderId
     * @param  [object] $depositOrder
     * @return void
     */
    private function change_parent_order_status( $orderId ) {
        // check the post type and set our cusrom function
        if ( get_post_type( $orderId ) == 'shop_deposit' ) {
            $depositOrder  = new ShopDeposit( $orderId );
            $parentId      = $depositOrder->get_parent_id();
            $completedArgs = array(
                'post_parent' => $parentId,
                'post_type'   => 'shop_deposit',
                'post_status' => 'wc-completed',
            );

            $args = array(
                'post_parent' => $parentId,
                'post_type'   => 'shop_deposit',
            );

            if ( count( get_children( $completedArgs ) ) == count( get_children( $args ) ) ) {
                $parentOrder = wc_get_order( $parentId );

                $parentOrder->update_status( apply_filters( 'change_order_status_on_deposit_complete_payments', cidw_get_option( 'bayna_fully_paid_status' ) ) );

                do_action( 'bayna_all_deposit_payments_paid', $parentId, $depositOrder );

                $parentOrder->save();

            }
        }
        return;
    }

    /**
     * must need to be all deposit status completed
     *
     * @param  int    $orderId
     * @return void
     */
    public function deposits_completed( $orderId ) {
        $this->change_parent_order_status( $orderId );
    }
    /**
     * Disbale Payment gateways
     *
     * @param  [array] $availableGateways
     * @return void
     */
    public function conditional_payment_gateways( $availableGateways ) {

        // Not in backend (admin)
        if ( is_admin() || !is_checkout() ) {
            return $availableGateways;
        }

        if ( cidw_cart_have_deposit_item() && cidw_get_option( 'cidw_payment_gateway' ) ) {
            foreach ( cidw_get_option( 'cidw_payment_gateway' ) as $key => $gateway ) {
                unset( $availableGateways[$gateway] );
            }
        }

        return $availableGateways;
    }

    /**
     * Adjust 'deposit parent order' based on cart
     *
     * @param  int    $orderId
     * @param  object $order
     * @return void
     */
    public function manage_order( $orderId, $data ) {
        $order = wc_get_order( $orderId );
        // Loop over $cart items
        $depositValue    = 0; // no value
        $dueValue        = 0; // no value
        $cart_item_total = 0; // no value

        // calculate amount of all deposit items
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $vProductId = ( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : $cart_item['product_id'];
            $depositValue += ( isset( $cart_item['_deposit_mode'] ) && $cart_item['_deposit_mode'] == 'check_deposit' ) ? $cart_item['_deposit'] * $cart_item['quantity'] : 0;

            $cart_item_total += $cart_item['data']->get_price() * $cart_item['quantity'];

            $dueValue += ( cidw_is_product_type_deposit( $vProductId ) && isset( $cart_item['_deposit_mode'] ) && $cart_item['_deposit_mode'] == 'check_deposit' ) ? $cart_item['_due_payment'] * $cart_item['quantity'] : null;
        }

        if ( $depositValue == 0 ) {
            return; // because order don't have any deposit item.
        }

        $depositValue = WC()->cart->get_total( 'f' );
        $order->update_meta_data( '_deposit_value', $depositValue, true );

        do_action( 'banyna_update_checkout_order_meta', $order );

        $order->save();
    }

    /**
     * Genarate 'shop_deposit' orders based on parent order
     *
     * @param  [int]    $orderID
     * @param  [object] $order
     * @return void
     */
    private function genarate_deposit_order( $order ) {
        $orderId      = $order->get_id();
        $depositValue = get_post_meta( $orderId, '_deposit_value', true );
        $offline_payment_gatway_ids = ['bacs', 'cheque', 'cod'];
        $first_deposit_order_status = 'completed';
        if( in_array($order->get_payment_method(), $offline_payment_gatway_ids)){
            $first_deposit_order_status = 'on-hold';
        }

        //todo: create new deposit based on payment plan

        // 2nd payment
        // Get order total
        $total    = $order->get_total();
        $DueOrder = new ShopDeposit();
        // Order details
        $DueOrder->set_customer_id( $order->get_user_id() );
        $DueOrder->set_parent_id( $order->get_id() );

        // Fee items
        $item = new \WC_Order_Item_Fee();
        $item->set_name( cidw_get_option('txt_to_due_payment_fee','Due Payment for order').' #' . $order->get_id() . '-2' );
        $item->set_total( $total - $depositValue );
        $item->set_total_tax( 0 );
        $item->save();
        $DueOrder->add_item( $item );
        $DueOrder->calculate_totals( apply_filters( 'bayna_apply_tax_calculate_totals', false ) );
        $DueOrder->update_meta_data( '_deposit_id', $DueOrder->get_id() . '-2', true );
        $DueOrder->set_status( 'pending' );
        $DueOrder->save();

        // Create new deposit order

        $DepositOrder = new ShopDeposit();
        // Order details
        $DepositOrder->set_customer_id( $order->get_user_id() );
        $DepositOrder->set_payment_method( $order->get_payment_method() );
        $DepositOrder->set_parent_id( $order->get_id() );

        // Fee items
        $item = new \WC_Order_Item_Fee();
        $item->set_name( cidw_get_option('txt_to_deposit_payment_fee','Deposit Payment for order').' #' . $order->get_id() . '-1' );
        $item->set_total( $depositValue );
        $item->set_total_tax( 0 );
        $item->save();

        $DepositOrder->add_item( $item );
        $DepositOrder->calculate_totals(apply_filters( 'bayna_apply_tax_calculate_totals', false ));
        $DepositOrder->update_meta_data( '_deposit_id', $DepositOrder->get_id() . '-1', true );
        $DepositOrder->set_status( $first_deposit_order_status );
        $DepositOrder->save();

        $due_ammount = $order->get_total() - get_post_meta( $orderId, '_deposit_value', true );
        update_post_meta( $orderId, '_order_due_ammount', $due_ammount );

        // add order meta data because deposit order genarate sucessfully
        $order->update_meta_data( '_genarate_deposit_orders', '1', true );
    }

    /**
     * Save cart item custom meta as order item meta data
     * and display it everywhere on orders and email notifications.
     */

    public function save_cart_order_meta( $item, $cart_item_key, $values, $order ) {
        foreach ( $item as $cart_item_key => $values ) {
            if ( isset( $values['_deposit'] ) && $values['_deposit_mode'] == 'check_deposit' ) {
                $deposit_amount = $values['_deposit'] * $item->get_quantity();
                $item->add_meta_data( '_deposit', $deposit_amount, true );
            }
            if ( isset( $values['_due_payment'] ) && $values['_deposit_mode'] == 'check_deposit' ) {
                $due_payment = $values['_due_payment'] * $item->get_quantity();
                $item->add_meta_data( '_due_payment', $due_payment, true );
            }
        }
    }

    /**
     * Display deposit data below the cart item in
     * order review section
     */
    public function display_item_deposit_data( $order, $cart_item ) {
        if ( isset( $cart_item['_deposit_mode'] ) && $cart_item['_deposit_mode'] == 'check_deposit' ) {
            $cart_item['_deposit']     = $cart_item['_deposit'] * $cart_item['quantity'];
            $cart_item['_due_payment'] = $cart_item['_due_payment'] * $cart_item['quantity'];
            $order .= sprintf(
                '<p>' . apply_filters( 'label_deposit', __( 'Deposit:', 'deposits-for-woocommerce' ) ) . ' %s <br> ' . apply_filters( 'label_due_payment', __( 'Due Payment:', 'deposits-for-woocommerce' ) ) . '  %s</p>',
                wc_price( $cart_item['_deposit'] ),
                wc_price( $cart_item['_due_payment'] )
            );
        }

        return $order;
    }

    /**
     * Dispaly Deposit amount to know user how much need to pay.
     */
    public function to_pay_html() {
        if ( cidw_cart_have_deposit_item() ) {
            cidw_display_to_pay_html();
        }
    }
}
