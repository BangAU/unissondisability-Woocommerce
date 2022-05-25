<?php

namespace Deposits_WooCommerce;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Emails {

    public function __construct() {
        add_filter( 'woocommerce_email_classes', [$this, 'email_classes'] );
        add_filter( 'woocommerce_email_actions', [$this, 'email_actions'] );
        add_filter( 'woocommerce_email_enabled_new_order', [$this, 'new_deposit_email'], 10, 2 );
        add_filter( 'woocommerce_email_enabled_customer_completed_order', [$this, 'deposit_completed_email'], 10, 2 );
        add_action( 'woocommerce_thankyou', [$this, 'deposit_notification'], 20, 1 );
        add_action( 'woocommerce_order_status_changed', [$this, 'emailNotifications'], 10, 4 );
        add_action( 'woocommerce_email_order_meta', [$this, 'customer_deposit_details'], 10, 1 );

        add_action( 'bayna_email_show_deposit_details', [$this, 'deposit_table'], 20, 1 );

    }
    /**
     * Table data is dispLay on Deposit paid and reminder email notfication
     * @param  object $order
     * @return void
     */
    public function deposit_table( $order ) {
        ?>
            <table border="0" cellpadding="20" cellspacing="0" style="width:100%; margin-bottom:15px">
                <thead>
                <tr>
                    <th class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px;"><?php esc_html_e( 'Payment ID', 'deposits-for-woocommerce' );?> </th>
                    <th class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px;"><?php esc_html_e( 'Status', 'deposits-for-woocommerce' );?> </th>
                    <th class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px;"><?php esc_html_e( 'Amount', 'deposits-for-woocommerce' );?> </th>
                    <th class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px;"><?php esc_html_e( 'Order', 'deposits-for-woocommerce' );?> </th>
                </tr>
                </thead>
                <tbody>
                <?php $depositOrder = new ShopDeposit( $order->get_id() );?>
                    <tr class="order_item">
                        <td class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px;">
                        <?php echo '<strong>#' . get_post_meta( $order->get_id(), '_deposit_id', true ) . '</strong>'; ?>
                        </td>
                        <td class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px;">
                        <?php $depositStatus = $depositOrder->get_status(); // order status ?>
                        <?php echo wc_get_order_status_name( $depositStatus ); ?>
                        </td>
                        <td class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px;">
                        <?php echo wc_price( $depositOrder->get_total() ); ?>
                        </td>
                        <td class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px;">
                        <?php $parentOrder = wc_get_order( $depositOrder->get_parent_id() );?>
                        <?php echo '<a href="' . $parentOrder->get_view_order_url() . '">' . $depositOrder->get_parent_id() . '</a>'; ?>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
    <?php }

    /**
     * Add deposit summary on below email order meta
     *
     * @param  object $order
     * @return void
     */
    public function customer_deposit_details( $order ) {
        if ( !bayna_order_has_deposit( $order->get_id() ) ) {
            return; // hide summary for non deposit orders
        }
        wc_get_template( 'emails/deposit-summary.php', array( 'order' => $order ), '', CIDW_TEMPLATE_PATH );
    }

    /**
     * Prevent 'shop_deposit'  order Complete email and send deposit order email
     * new_order , customer_on_hold_order ,customer_processing_order,customer_completed_order
     * @param  boolen $enabled
     * @param  [type] $object
     * @return void
     */
    public function deposit_completed_email( $enabled, $object ) {
        if ( $object == null ) {
            return $enabled;
        }

        $orderId      = $object->get_order_number();
        $autoGenarate = get_post_meta( $orderId, '_create_from_shop_order', true ); // order genarate by updateDB class. so we don't need to send emails for exsiting orders
        if ( get_post_type( $orderId ) == 'shop_deposit' ) {
            if ( $autoGenarate == 1 ) {
                // check the auto genarate order by updateDB class
                return false; // no need to to send email for exisiting orders
            }
            WC()->mailer()->emails['WC_Customer_Deposit_Order']->trigger( $orderId );
            return false;
        }

        return $enabled;
    }

    /**
     * Prevent 'shop_deposit' new depsoit email
     *
     * @param  string $enabled
     * @param  object $object
     * @return void
     */
    public function new_deposit_email( $enabled, $object ) {
        if ( $object == null ) {
            return $enabled;
        }

        $orderId   = $object->get_order_number();
        $depositID = get_post_meta( $orderId, '_deposit_id', true );
        if ( !empty( $depositID ) ) {
            return false;
        }

        return $enabled;
    }

    /**
     * send deposit order email
     * @param $orderId
     */
    public function deposit_notification( $orderId ) {

        if ( bayna_order_has_deposit( $orderId ) ) {
            // Sending  admin Order email notification
            WC()->mailer()->emails['WC_New_deposit_Alert']->trigger( $orderId );
            // Sending Customer Order email notification
            WC()->mailer()->emails['WC_Customer_Deposit_Alert']->trigger( $orderId );

            // Todo: add custom meta data to prevent send email on reload thank you page.
        }

    }
    /**
     * send deposit-status to new status related emails
     *
     * @param  int    $order_id
     * @param  string $old_status
     * @param  string $new_status
     * @param  object $order
     * @return void
     */
    public function emailNotifications( $order_id, $old_status, $new_status, $order ) {

        if ( $old_status == 'deposit' && $new_status == 'on-hold' ) {

            // Sending Customer On Hold Order email notification
            WC()->mailer()->emails['WC_Email_Customer_On_Hold_Order']->trigger( $order_id );

        } elseif ( $old_status == 'deposit' && $new_status == 'completed' ) {

            // Sending Customer Completed Order email notification
            WC()->mailer()->emails['WC_Email_Customer_Completed_Order']->trigger( $order_id );

        } elseif ( $old_status == 'deposit' && $new_status == 'processing' ) {

            // Sending Customer Processing Order email notification
            WC()->mailer()->emails['WC_Email_Customer_Processing_Order']->trigger( $order_id );

        } elseif ( $old_status == 'deposit' && $new_status == 'cancelled' ) {

            // Sending Customer Cancelled Order email notification
            WC()->mailer()->emails['WC_Email_Cancelled_Order']->trigger( $order_id );

        }
    }

    /**
     * register new email class
     *
     * @param  array  $Classes
     * @return void
     */
    public function email_classes( $Classes ) {
        $Classes['WC_New_deposit_Alert']      = new Emails\NewDeposit();
        $Classes['WC_Customer_Deposit_Alert'] = new Emails\DepositOrder();
        $Classes['WC_Customer_Deposit_Order'] = new Emails\DepositPaid();

        return $Classes;
    }
    /**
     * Email Action
     *
     * @param  array  $actions
     * @return void
     */
    public function email_actions( $actions ) {
        $actions[] = 'woocommerce_order_status_wc-deposit';
        return $actions;
    }
}
