<?php

namespace SW_WAPF_PRO\Includes\Controllers {

	use SW_WAPF_PRO\Includes\Classes\Field_Groups;
	use SW_WAPF_PRO\Includes\Classes\File_Upload;
	use SW_WAPF_PRO\Includes\Classes\Woocommerce_Service;

    if (!defined('ABSPATH')) {
        die;
    }

    class Public_Controller {

        public function __construct()
        {

            if(!$this->is_woocommerce_active())
                return;

            add_action( 'wp_enqueue_scripts',                               array($this, 'register_assets'), 5000 );

	        add_filter('wc_stripe_hide_payment_request_on_product_page',    '__return_true',10,2);

	        if( File_Upload::is_ajax_upload()) {
		        add_action( 'wp_ajax_wapf_upload', array( $this, 'ajax_upload' ) );
		        add_action( 'wp_ajax_nopriv_wapf_upload', array( $this, 'ajax_upload' ) );
		        add_action( 'wp_ajax_wapf_upload_remove', array( $this, 'ajax_upload_remove' ) );
		        add_action( 'wp_ajax_nopriv_wapf_upload_remove', array( $this, 'ajax_upload_remove' ) );
	        }

	        new Product_Controller();

        }

        public function ajax_upload_remove() {

	        if(!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'wapf_fupload') || !isset($_GET['file'])) {
		        wp_send_json_error();
	        }

	        $file = sanitize_text_field($_GET['file']);

	        if(file_exists($file))
	            unlink(sanitize_text_field($file));
        }

        public function ajax_upload() {
	        if(!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'wapf_fupload') || empty($_POST['field_groups'])) {
		        wp_send_json_error();
	        }

	        if(empty($_FILES))
	        	wp_send_json_error();

	        $files = File_Upload::create_uploaded_file_array();
	        if(empty($files))
	        	wp_send_json_error();

	        $field_groups = Field_Groups::get_by_ids(explode(',', sanitize_text_field($_POST['field_groups'])));
			$valid = File_Upload::validate_files_from_ajax($files,$field_groups);
			if(is_string($valid))
				wp_send_json_error($valid,403);

	        $files_upload_result = File_Upload::handle_files_array($field_groups,$files);
	        if(is_string($files_upload_result)) {
	        	wp_send_json_error($files_upload_result,400);
	        }

	        $res = array();

	        foreach($files_upload_result as $files_arr) {
	        	foreach($files_arr as $f) {
			        $res[] = array(
			        	'path' => $f['field'] . explode($f['field'],$f['uploaded_file_path'])[1],
				        'file' => $f['uploaded_file'],
			        );
		        }
	        }

	        wp_send_json_success($res);
        }

        public function register_assets() {

            $url =  trailingslashit(wapf_get_setting('url')) . 'assets/';
            $version = wapf_get_setting('version');

            wp_enqueue_style('wapf-frontend', $url . 'css/frontend.min.css', array(), $version);
            wp_enqueue_script('wapf-frontend-js', $url . 'js/frontend.min.js', array('jquery'), $version, true);

            $script_vars = array(
            	'ajax'              =>  admin_url('admin-ajax.php'),
                'page_type'         => Woocommerce_Service::get_current_page_type(),
                'display_options'   => Woocommerce_Service::get_price_display_options(),
	            'slider_support'    => get_theme_support('wc-product-gallery-slider')
            );

            wp_localize_Script('wapf-frontend-js', 'wapf_config', $script_vars);

	        if( File_Upload::is_ajax_upload()) {
		        wp_enqueue_script('wapf-dropzone', $url . 'js/dropzone.min.js', array(), $version, true);
		        wp_enqueue_style( 'wapf-dropzone', $url . 'css/dropzone.min.css', array(), $version );
	        }

	        if(get_option('wapf_datepicker','no') === 'yes') {
		        wp_enqueue_script('wapf-dp', $url . 'js/datepicker.min.js', array(), $version, true);
		        wp_enqueue_style( 'wapf-dp', $url . 'css/datepicker.min.css', array(), $version );
	        }

        }

        public function is_woocommerce_active()
        {
            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                return true;
            }
            if (is_multisite()) {
                $plugins = get_site_option('active_sitewide_plugins');
                if (isset($plugins['woocommerce/woocommerce.php']))
                    return true;
            }
            return false;
        }

    }
}