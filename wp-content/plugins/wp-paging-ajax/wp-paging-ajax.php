<?php
/*
Plugin Name: WP Paging Ajax
Plugin URI: https://topxtheme.com
Description: Simple ajax paging for worpdress.
Version: 1.0.1
Author: thinhbg59
Author URI: http://topxtheme.com
Requires at least: 4.0
Tested up to: 4.7
Text Domain: wppa
Domain Path: /languages
License: GNU General Public License v2.0 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WP_Paging_Ajax
{

    /**
     * PJAX constructor.
     */
    public function __construct()
    {
        define('WPPA_PLUGIN_DIR', untrailingslashit(plugin_dir_path(__FILE__)));
        define('WPPA_PLUGIN_URL', untrailingslashit(plugins_url(basename(plugin_dir_path(__FILE__)), basename(__FILE__))));

        include(WPPA_PLUGIN_DIR . '/includes/settings.php');

        add_action('wp_enqueue_scripts', array($this, 'frontend_scripts'));
    }

    public function frontend_scripts()
    {

        wp_enqueue_style('wppa', WPPA_PLUGIN_URL . '/assets/css/wppa.css', array(), '1.0');

        wp_enqueue_script('pjax-standalone', WPPA_PLUGIN_URL . '/assets/js/pjax-standalone.js', array('jquery'), '0.6.1', true);

        $main_selector = wwppa_get_setting('main_selector', '#main');
        $paging_class_name = wwppa_get_setting('paging_class_name', 'page-numbers');
        $wppa_settings = array(
            'main_selector'     => $main_selector,
            'paging_class_name' => $paging_class_name,
        );

        wp_register_script('wppa', WPPA_PLUGIN_URL . '/assets/js/wppa.js', array('jquery'), '1.0', true);
        wp_localize_script('wppa', 'WPPA', $wppa_settings);
        wp_enqueue_script('wppa');
    }
}

new WP_Paging_Ajax();
