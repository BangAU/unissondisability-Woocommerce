<?php
/**
 * The plugin bootstrap file
 *
 *
 * @wordpress-plugin
 * Plugin Name:       Bayna - Deposits & Partial Payments for WooCommerce
 * Plugin URI:        https: //wordpress.org/plugins/deposits-for-woocommerce/
 * Description:       Enable customers to pay for products using a deposit or a partial payment.
 * Version:           1.2.3
 * Author:            Codeixer
 * Author URI:        https://codeixer.com
 * Text Domain:       deposits-for-woocommerce
 * Domain Path:       /languages
 * Tested up to: 5.9.3
 * Requires at least: 5.5
 * WC requires at least: 4.9
 * WC tested up to: 6.4.1
 * Requires PHP: 7.2
 * @package           deposits-for-woocommerce
 *
 * @link              http://codeixer.com
 * @since             1.0.0
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * Initialize the plugin tracker
 *
 */
function appsero_init_tracker_deposits_for_woocommerce() {
	if ( !class_exists( 'Appsero\Client' ) ) {
		require __DIR__ . '/appsero/src/Client.php';
	}

	$client = new Appsero\Client( '5379e35c-ac97-4062-9202-8b440ef724ac', 'Bayna - Deposits for WooCommerce', __FILE__ );

	// Active insights
	$client->insights()->init();
}

appsero_init_tracker_deposits_for_woocommerce();

require_once ABSPATH . 'wp-admin/includes/plugin.php';
require __DIR__ . '/vendor/autoload.php';

use \Deposits_WooCommerce\Bootstrap;
use \Deposits_WooCommerce\Modules\Admin;

/**
 * Define the required plugin constants
 */
define( 'CIDW_DEPOSITS_VERSION', '1.2.3' );
define( 'CIDW_DEPOSITS_FILE', __FILE__ );
define( 'CIDW_DEPOSITS_PATH', __DIR__ );
define( 'CIDW_BASE_FILE', plugin_basename( __FILE__ ) );
define( 'CIDW_DEPOSITS_URL', plugins_url( '', CIDW_DEPOSITS_FILE ) );
define( 'CIDW_DEPOSITS_ASSETS', CIDW_DEPOSITS_URL . '/assets' );
define( 'CIDW_TEMPLATE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' );

final class Bayna_Free {
	/**
	 * @return null
	 */
	private function __construct() {
		register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
		register_activation_hook( __FILE__, array( $this, 'plugin_deactivation' ) );
		// multisite
		if ( is_multisite() && self::wc_active_for_network() === false ) {
			//	add_action( 'admin_notices', array( $this, 'woo_inactive' ) );
			//	return;
			// this plugin runs on a single site
		} elseif ( self::wc_plugin_active() === false ) {
			add_action( 'admin_notices', array( $this, 'woo_inactive' ) );
			return;

		}
		add_action( 'plugin_loaded', [$this, 'before_init_plugin'] );
		add_action( 'woocommerce_loaded', [$this, 'init_plugin'], 90 );

		add_action( 'plugin_action_links_' . CIDW_BASE_FILE, [$this, 'plugin_row_meta_links'] );
		add_filter( 'plugin_row_meta', [$this, 'plugin_meta_links'], 10, 2 );

	}

	public function woo_inactive() {
		$class   = 'notice notice-error';
		$message = __( 'Oops! looks like WooCommerce is disabled. Please, enable it in order to use Bayna - Deposits & Partial Payments for WooCommerce.', 'deposits-for-woocommerce' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );

	}
	/**
	 * Add links to plugin's description in plugins table
	 *
	 * @param  array   $links Initial list of links.
	 * @param  string  $file  Basename of current plugin.
	 * @return array
	 */
	public function plugin_meta_links( $links, $file ) {
		if ( $file !== CIDW_BASE_FILE ) {
			return $links;
		}
		$cidw_doc     = '<a target="_blank" href="https://www.codeixer.com/docs-category/bayna-woocommerce-deposit/" title="' . __( 'Docs & FAQs', 'deposits-for-woocommerce' ) . '">' . __( 'Docs & FAQs', 'deposits-for-woocommerce' ) . '</a>';
		$cidw_support = '<a style="color:red;" target="_blank" href="https://codeixer.com/contact-us/" title="' . __( 'Get help', 'deposits-for-woocommerce' ) . '">' . __( 'Support', 'deposits-for-woocommerce' ) . '</a>';
		$cidw_support = '<a style="color:red;" target="_blank" href="https://codeixer.com/contact-us/" title="' . __( 'Get help', 'deposits-for-woocommerce' ) . '">' . __( 'Support', 'deposits-for-woocommerce' ) . '</a>';
		$cidw_review  = '<a target="_blank" title="Click here to rate and review this plugin on WordPress.org" href="https://wordpress.org/support/plugin/deposits-for-woocommerce/reviews/?filter=5"> Rate this plugin » </a>';

		$links[] = $cidw_doc;
		$links[] = $cidw_support;
		$links[] = $cidw_review;
		return $links;
	}

	/**
	 * Check if plugin active for Network Site
	 * @param $plugin
	 */
	public static function wc_active_for_network() {
		if ( !is_multisite() ) {
			return false;
		}

		$plugins = get_site_option( 'active_sitewide_plugins' );
		if ( isset( $plugins['woocommerce/woocommerce.php'] ) ) {
			return true;
		}

		return false;
	}
	/**
	 * Check if plugin active for Single site
	 * @param $plugin
	 */
	public static function wc_plugin_active() {
		return in_array( 'woocommerce/woocommerce.php', (array) get_option( 'active_plugins', array() ) ) || is_plugin_active_for_network( 'woocommerce/woocommerce.php' );
	}
	/**
	 * links in Plugin Meta
	 *
	 * @param  [array] $links
	 * @return void
	 */
	public function plugin_row_meta_links( $links ) {
		$row_meta = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=deposits_settings' ) . '">Settings</a>',
			'go_pro'   => '<a target="_blank" class="cit-get-pro" href="https://www.codeixer.com/upgrade-to-bayna-premium/?utm_source=upgrade&utm_medium=discount&utm_campaign=bayna_upgrade">Get Bayna PRO</a>',

		);
		return array_merge( $links, $row_meta );
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public function init_plugin() {
		new Bootstrap;

		do_action( 'bayna_free_loaded' );
	}
	/**
	 * Before nitialize the plugin
	 *
	 * @return void
	 */
	public function before_init_plugin() {
		Admin::init();
	}

	/**
	 * Run Codes on Plugin activation
	 *
	 * @return void
	 */
	public function plugin_activation() {
		$installed = get_option( 'ci_woo_deposits_installed' );

		if ( !$installed ) {
			update_option( 'ci_woo_deposits_installed', time() );
		}
	}
	/**
	 * Run Codes on Plugin deactivation
	 * @return void
	 */
	public function plugin_deactivation() {

	}

	/**
	 * Initializes a singleton instance
	 *
	 * @return $instance
	 */
	public static function init() {

		/**
		 * @var mixed
		 */
		static $instance = false;
		if ( !$instance ) {
			$instance = new self();
		}
		return $instance;
	}
}
/**
 * Initializes the main plugin
 */
Bayna_Free::init();