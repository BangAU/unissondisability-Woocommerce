<?php

namespace Deposits_WooCommerce;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Order {

    public function __construct() {

        add_filter( 'woocommerce_order_item_quantity_html', [$this, 'display_item_deposit_data'], 20, 2 );

        add_filter( 'woocommerce_get_order_item_totals', [$this, 'table_row_data'], 10, 2 );
        add_action( 'woocommerce_admin_order_totals_after_tax', [$this, 'deposit_data_dispaly_table_tr'], 20, 1 );
        add_action( 'woocommerce_admin_order_preview_end', [$this, 'preview_deposit_data'] );
        add_action( 'woocommerce_admin_order_item_headers', [$this, 'admin_order_items_headers'], 10, 1 );
        add_action( 'woocommerce_admin_order_item_values', [$this, 'admin_order_items_values'], 10, 3 );
        add_action( 'add_meta_boxes', [$this, 'deposit_metabox'] );
        add_action( 'woocommerce_after_order_details', [$this, 'customer_deposit_details'], 20, 1 );
        add_action( 'woocommerce_order_details_after_order_table', [$this, 'woocommerce_order_again_button'], 10, 1 );

        add_filter( 'wc_order_is_editable', [$this, 'order_status_editable'], 10, 2 );
        add_filter( 'woocommerce_admin_order_preview_get_order_details', [$this, 'add_deposit_details'], 10, 2 );
    }
    /**
     * add depsoit data into teh array for display
     * as preview
     * @param $data
     */
    public function add_deposit_details( $data, $order ) {
        $data['depositPaid'] = ( !empty( get_post_meta( $order->get_id(), '_deposit_value', true ) ) ) ? wc_price( get_post_meta( $order->get_id(), '_deposit_value', true ) ) : '-';
        $data['depositDue']  = ( !empty( get_post_meta( $order->get_id(), '_deposit_value', true ) ) ) ? wc_price( $order->get_total() - get_post_meta( $order->get_id(), '_deposit_value', true ) ) : '-';
        return $data;
    }
    public function preview_deposit_data() {
        ?>

        <div class="wc-order-preview-deposit">
            <h2><?php esc_html_e( 'Deposit Payment details', 'deposits-for-woocommerce' );?></h2>
            <div>
                <strong><?php echo esc_html( cidw_get_option( 'txt_to_deposit_paid', 'Paid:' ) ); ?></strong>
                {{{ data.depositPaid }}}
            </div>
            <div>
                <strong><?php echo esc_html( cidw_get_option( 'txt_to_due_payment', 'Due Payment' ) ); ?></strong>
                {{{ data.depositDue }}}
            </div>
        </div>

    <?php }

    /**
     * make deposit order status editable as like the pending payment status
     *
     * @param  string $editable
     * @param  object $order
     * @return void
     */
    public function order_status_editable( $editable, $order ) {
        if ( $order->get_status() == 'deposit' ) {
            $editable = true;
        }
        return $editable;
    }
    /**
     * Display an 'order again' button on the view order page.
     *
     * @param object $order.
     */
    public function woocommerce_order_again_button( $order ) {
        if ( !$order || !$order->has_status( apply_filters( 'woocommerce_valid_order_statuses_for_order_again', array( 'completed' ) ) ) || !is_user_logged_in() ) {
            return;
        }

        $depositId = get_post_meta( $order->get_id(), '_deposit_id', true );

        if ( !empty( $depositId ) ) {
            return;
        }

        wc_get_template(
            'order/order-again.php',
            array(
                'order'           => $order,
                'order_again_url' => wp_nonce_url( add_query_arg( 'order_again', $order->get_id(), wc_get_cart_url() ), 'woocommerce-order_again' ),
            )
        );
    }

    /**
     * @param  $order
     * @return null
     */
    public function customer_deposit_details( $order ) {

        if ( empty( get_post_meta( $order->get_id(), '_deposit_value', true ) ) ) {
            return; // hide summary for non deposit orders
        }
        wc_get_template( 'order/deposit-summary.php', array( 'order' => $order ), '', CIDW_TEMPLATE_PATH );
    }

    /**
     * Add metabox in order post type
     *
     * @return void
     */
    public function deposit_metabox() {
        if ( empty( get_post_meta( get_the_id(), '_deposit_value', true ) ) ) {
            return; // return if not deposit
        }

        add_meta_box( 'deposit-orders', __( 'Deposit Payments', 'deposits-for-woocommerce' ), [$this, 'depositMarkupBox'], 'shop_order' );

    }
    /**
     * Add markup to show depsoit orders
     *
     * @return void
     */
    public function depositMarkupBox() {
        $args = array(
            'post_type'   => 'shop_deposit',
            'post_parent' => get_the_id(),
        );

        $depositList = get_children( $args );?>

        <table class="wp-list-table widefat fixed striped table-view-excerpt ">
        <thead>

            <tr>
            <th><?php esc_html_e( 'Order Number', 'deposits-for-woocommerce' );?></th>
            <th><?php esc_html_e( 'Relationship', 'deposits-for-woocommerce' );?></th>
            <th><?php esc_html_e( 'Date', 'deposits-for-woocommerce' );?></th>
            <th><?php esc_html_e( 'Payment', 'deposits-for-woocommerce' );?></th>
            <th><?php esc_html_e( 'Status', 'deposits-for-woocommerce' );?></th>
            <th><?php esc_html_e( 'Total', 'deposits-for-woocommerce' );?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ( $depositList as $key => $deposit ) {
            $depositOrder = new ShopDeposit( $deposit->ID );
            if ( $depositOrder->get_status() == 'completed' ) {
                $paymentStatus = __( 'Deposit', 'deposits-for-woocommerce' );
            } else {
                $paymentStatus = __( 'Due Payment', 'deposits-for-woocommerce' );
            }?>
                    <tr>
                    <td><?php echo '<a href="' . esc_url( admin_url( 'post.php?post=' . $depositOrder->get_id() ) . '&action=edit' ) . '" class="order-view"><strong>#' . $depositOrder->get_id() . '</strong></a>'; ?></td>

                    <td><?php esc_html_e( 'Deposit payment', 'deposits-for-woocommerce' );?></td>

                    <td><?php $depositDate = human_time_diff( get_the_date( 'U' ), current_time( 'U' ) );
            if ( get_the_date( 'U' ) > current_time( 'U' ) - 86400 ) {
                echo $depositDate;
            } else {
                echo get_the_date( 'F j Y' );
            }?></td>

                    <td><?php echo esc_html( $paymentStatus ); ?></td>

                    <td>
                    <?php $depositStatus = $depositOrder->get_status(); // order status ?>
                    <?php echo sprintf( '<mark class="order-status %s tips"><span>%s</span></mark>', esc_attr( sanitize_html_class( 'status-' . $depositStatus ) ), wc_get_order_status_name( $depositStatus ) ); ?>
                    </td>

                    <td><?php echo wc_price( $depositOrder->get_total() ) ?></td>

                    </tr>

        <?php }?>

        </tbody>
        </table>
    <?php }
    /**
     * Add order backend table headers
     *
     * @param  object $order
     * @return void
     */
    public function admin_order_items_headers( $order ) {

        if ( bayna_order_has_deposit( $order->get_id() ) == false ) {
            return;
        }
        ?>
        <th class="line-deposit sortable" data-sort="float"><?php esc_html_e( 'Deposit', 'deposits-for-woocommerce' );?></th>
        <th class="line-due-paymnet sortable" data-sort="float"><?php esc_html_e( 'Due', 'deposits-for-woocommerce' );?></th>
    <?php }

    /**
     * Display Order backendend deposit value
     *
     * @param  object $product
     * @param  array  $item
     * @param  int    $item_id
     * @return void
     */

    public function admin_order_items_values( $product, $item, $item_id ) {

        if ( null == $product ) {
            //  fix fatal error if order change to refund
            echo '<td class="item_cost" width="1%">&nbsp;</td><td class="quantity" width="1%">&nbsp;</td>';

            return;
        }
        $depositValue = $item['_deposit'];
        $dueValue     = $item['_due_payment'];

        if ( null == $depositValue ) {
            return;
        }
        ?>

        <td class="line-deposit" width="1%">

            <?php if ( $product && $depositValue ) {?>
                <div class="view">
                    <?php echo wc_price( $depositValue ); ?>
                </div>
                <div class="edit" style="display: none;">
                    <input type="text" disabled="disabled" name="deposit[<?php echo absint( $item_id ); ?>]"
                            placeholder="<?php echo wc_format_localized_price( 0 ); ?>" value="<?php echo round( $depositValue, wc_get_price_decimals() ); ?>"
                            class=" wc_input_price" data-total="<?php echo round( $depositValue, wc_get_price_decimals() ); ?>"/>
                </div>
            <?php }?>
        </td>
        <td class="deposit-due-paymnet" width="1%">

            <?php if ( $product && $depositValue ) {?>
                <div class="view">
                    <?php echo wc_price( $dueValue ); ?>
                </div>
                <div class="edit" style="display: none;">
                    <input type="text" disabled="disabled" name="due_payment[<?php echo absint( $item_id ); ?>]"
                            placeholder="<?php echo wc_format_localized_price( 0 ); ?>" value="<?php echo round( $dueValue, wc_get_price_decimals() ); ?>"
                            class="due_payment wc_input_price" data-total="<?php echo round( $dueValue, wc_get_price_decimals() ); ?>"/>
                </div>
            <?php }?>
        </td>
    <?php }

    /**
     * Add deposit Table data in order details / Email template
     */
    public function table_row_data( $total_rows, $order ) {
        if ( bayna_order_has_deposit( $order->get_id() ) == false ) {
            return $total_rows;
        }

        // Deposit order no need to show 'order again' button
        remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );

        // Overrirde : default order tr
        $total_rows['order_total'] = array(
            'label' => apply_filters( 'label_order_total', __( 'Total:', 'deposits-for-woocommerce' ) ),
            'value' => apply_filters( 'woocommerce_deposit_to_pay_html', wc_price( $order->get_total() ) ),
        );
        $total_rows['deposit_paid'] = array(
            'label' => apply_filters( 'label_deposit_paid', __( 'Paid:', 'deposits-for-woocommerce' ) ),
            'value' => wc_price( get_post_meta( $order->get_id(), '_deposit_value', true ) ),
        );
        $total_rows['due_payment'] = array(
            'label' => apply_filters( 'label_due_payment', __( 'Due Payment:', 'deposits-for-woocommerce' ) ),
            'value' => wc_price( get_post_meta( $order->get_id(), '_order_due_ammount', true ) ) . ' <small>' . esc_html( apply_filters( 'dfwc_after_due_payment_label', null ) ) . '</small>',
        );

        return $total_rows;
    }

    /**
     * Dispaly Due amount in order table after deposit - for admin
     * Dispaly Total deposit amount in order table [for admin]
     */
    public function deposit_data_dispaly_table_tr( $order_id ) {
        $depositValue = get_post_meta( $order_id, '_deposit_value', true );

        if ( empty( $depositValue ) ) {
            return;
        }

        $dueValue = get_post_meta( $order_id, '_order_due_ammount', true );?>
        <tr>
			<td class="label"><?php esc_html_e( 'Deposit', 'deposits-for-woocommerce' );?>:</td>

			<td width="1%"></td>
			<td class="total">
				<?php echo wc_price( $depositValue ); ?>
			</td>
        </tr>
        <tr>
			<td class="label"><?php esc_html_e( 'Due Amount', 'deposits-for-woocommerce' );?>:</td>
			<td width="1%"></td>
			<td class="total">
				<?php echo wc_price( $dueValue ); ?>
			</td>
		</tr>
    <?php }

    /**
     * Display deposit data below the cart item in
     * order review section
     */
    public function display_item_deposit_data( $quantity, $item ) {
        if ( isset( $item['_deposit'] ) ) {
            $depositValue = $item['_deposit'] * $item['quantity'];
            $dueValue     = $item['_due_payment'] * $item['quantity'];
            $quantity .= sprintf(
                '<p>' . apply_filters( 'label_deposit', __( 'Deposit:', 'deposits-for-woocommerce' ) ) . ' %s <br> ' . apply_filters( 'label_due_payment', __( 'Due Payment:', 'deposits-for-woocommerce' ) ) . '%s</p>',
                wc_price( $depositValue ),
                wc_price( $dueValue )
            );
        }

        return $quantity;
    }
}
