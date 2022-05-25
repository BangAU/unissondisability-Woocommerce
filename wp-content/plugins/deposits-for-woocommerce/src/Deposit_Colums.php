<?php

namespace Deposits_WooCommerce;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Deposit_Colums {

    public function __construct() {
        add_action( 'manage_shop_deposit_posts_custom_column', array( $this, 'shop_deposit_column' ), 10, 2 );
        add_action( 'pre_get_posts', array( $this, 'show_all_orders' ), 10, 1 );
        add_action( 'pre_get_posts', array( $this, 'order_by_columns' ), 10, 1 );
        add_filter( 'views_edit-shop_deposit', array( $this, 'remove_status' ) );
        add_filter( 'manage_shop_deposit_posts_columns', array( $this, 'shop_deposit_columns' ) );
        add_filter( 'manage_edit-shop_deposit_sortable_columns', array( $this, 'sortable_columns' ) );

        add_filter( 'post_row_actions', array( $this, 'remove_row_actions' ), 10, 1 );
        add_filter( 'admin_body_class', array( $this, 'deposit_body_class' ) );
    }
    /**
     * Columns sorting Query
     *
     * @param  object $query
     * @return void
     */
    public function order_by_columns( $query ) {
        if ( !is_admin() ) {
            return;
        }

        $orderby = $query->get( 'orderby' );

        if ( 'deposit' == $orderby ) {
            $query->set( 'meta_key', '_deposit_id' );
            $query->set( 'orderby', 'meta_value_num' );
        } elseif ( 'parent_order' == $orderby ) {
            $query->set( 'orderby', 'parent' );
        } elseif ( 'deposit_date' == $orderby ) {
            $query->set( 'orderby', 'date' );
        }
    }
    /**
     * Add sortable option to columns
     *
     * @param  array  $columns
     * @return void
     */
    public function sortable_columns( $columns ) {
        $columns['deposit']      = 'deposit';
        $columns['parent_order'] = 'parent_order';
        $columns['deposit_date'] = 'deposit_date';

        return $columns;
    }
    /**
     * Add shop order style to depost page
     *
     * @param  string $classes
     * @return void
     */
    public function deposit_body_class( $classes ) {
        if ( get_post_type() === 'shop_deposit' ) {
            $classes .= ' post-type-shop_order';
        }
        return $classes;
    }

    /**
     * Remove unwanted or default columns
     *
     * @param  array  $actions
     * @return void
     */
    public function remove_row_actions( $actions ) {
        if ( get_post_type() === 'shop_deposit' ) {
            unset( $actions['edit'] );
            unset( $actions['trash'] );
            unset( $actions['view'] );
            unset( $actions['inline hide-if-no-js'] );
        }
        return $actions;
    }

    /**
     * Modify the main query to dispaly evry status in 'all' tab
     *
     * @param  object $query
     * @return void
     */
    public function show_all_orders( $query ) {
        // We have to check if we are in admin and check if current query is the main query and check if you are looking for 'shop_deposit' post type

        if ( is_admin() && $query->is_main_query() && $query->get( 'post_type' ) == "shop_deposit" ) {
            if ( !isset( $_GET['post_status'] ) ) {
                $query->set( 'post_status', 'any' );
            }
        }
    }

    /**
     * remove status from shop_deposit table
     *
     * @param  array  $views
     * @return void
     */
    public function remove_status( $views ) {
        unset( $views['draft'] );
        unset( $views['publish'] );
        return $views;
    }

    /**
     * Add the custom columns to the shop_deposit post type:
     *
     * @param  array  $columns
     * @return void
     */
    public function shop_deposit_columns( $columns ) {
        unset( $columns['title'] );
        unset( $columns['date'] );
        $columns['deposit']        = __( 'Deposit ID', 'deposits-for-woocommerce' );
        $columns['deposit_date']   = __( 'Date', 'deposits-for-woocommerce' );
        $columns['deposit_status'] = __( 'Status', 'deposits-for-woocommerce' );
        $columns['total']          = __( 'Total', 'deposits-for-woocommerce' );
        $columns['parent_order']   = __( 'Order', 'deposits-for-woocommerce' );

        return $columns;
    }
    /**
     * Add the data to the custom columns for the shop_deposit post type:
     *
     * @param  loop   $column
     * @param  int    $post_id
     * @return void
     */
    public function shop_deposit_column( $column, $post_id ) {
        $depositOrder = new ShopDeposit( $post_id );

        switch ( $column ) {

        case 'deposit':

            echo '<a href="' . esc_url( admin_url( 'post.php?post=' . $post_id ) . '&action=edit' ) . '" class="order-view"><strong>#' . get_post_meta( $post_id, '_deposit_id', true ) . '</strong></a>';

            break;

        case 'total':
            echo wc_price( $depositOrder->get_total() );

            break;

        case 'deposit_status':

            $depositStatus = $depositOrder->get_status(); // order status
            echo sprintf( '<mark class="order-status %s tips"><span>%s</span></mark>', esc_attr( sanitize_html_class( 'status-' . $depositStatus ) ), wc_get_order_status_name( $depositStatus ) );

            break;

        case 'parent_order':

            $parentId = $depositOrder->get_parent_id(); // order parent

            echo '<a href="' . esc_url( admin_url( 'post.php?post=' . $parentId ) . '&action=edit' ) . '" class="order-view">' . $parentId . '</a>';

            break;

        case 'deposit_date':

            if ( get_post_meta( $depositOrder->get_id(), '_create_from_shop_order', true ) == 1 ) {
                echo get_the_date( 'F j Y' );
                return;
            }

            $humanDepositDate = ( $depositOrder->get_date_paid() ) ? human_time_diff( $depositOrder->get_date_paid()->date( 'U' ), current_time( 'U' ) ) : human_time_diff( get_the_date( 'U' ), current_time( 'U' ) );

            $depositDate = ( $depositOrder->get_date_paid() ) ? $depositOrder->get_date_paid()->date( 'U' ) : get_the_date( 'U' );

            if ( $depositDate > current_time( 'U' ) - 86400 ) {
                echo $humanDepositDate;
            } else {
                echo ( $depositOrder->get_date_paid() ) ? $depositOrder->get_date_paid()->date( 'F j Y' ) : get_the_date( 'F j Y' );
            }
            //TODO : replace all depsoit date based on date_paid like this case
            break;

        }
    }
}
