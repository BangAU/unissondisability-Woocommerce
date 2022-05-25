<?php
/**
 * Unisson Disability functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Unisson_Disability
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function unisson_disability_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Unisson Disability, use a find and replace
		* to change 'unisson-disability' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'unisson-disability', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'unisson-disability' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'unisson_disability_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'unisson_disability_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function unisson_disability_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'unisson_disability_content_width', 640 );
}
add_action( 'after_setup_theme', 'unisson_disability_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function unisson_disability_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'unisson-disability' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'unisson-disability' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'unisson_disability_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function unisson_disability_scripts() {
	wp_enqueue_style( 'unisson-disability-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'unisson-disability-style', 'rtl', 'replace' );

	wp_enqueue_script( 'unisson-disability-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'unisson_disability_scripts' );


/**
 * acf data sync.
 */
 //require get_template_directory() . '/inc/register-taxonomy.php';
// /**
//  * acf data sync.
//  */
 require get_template_directory() . '/inc/sync-acf.php';
// /**
//  * acf data sync.
//  */
 require get_template_directory() . '/inc/remove-hooks.php';


/**
 * Navwalker specially used for mega menu class include
 */

require get_template_directory() . '/inc/class.walker.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/header-cart.php';

/**
 * register module
 */

require get_template_directory() . '/inc/register-module.php';
/**
 * block categories
 */

require get_template_directory() . '/inc/custom-block-categories.php';
/**
 * custom form
 */

require get_template_directory() . '/inc/search-form.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}




//add_filter( 'woocommerce_enqueue_styles', '__return_false' );




// function mytheme_add_woocommerce_support() {
//     add_theme_support( 'woocommerce' );
// }
// add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );


/** Custom Search for Library */
function my_search_filter($query) {
    if ( $query->is_search && ! is_admin() ) {
        $query->set( 'post_type', 'product' );
        $query->is_post_type_archive = false;
    }
}
add_filter('pre_get_posts','my_search_filter', 9);

function search_filter($query) {
	if ( !is_admin() && $query->is_main_query() ) {
	  if ($query->is_search) {
		$query->set('paged', ( get_query_var('paged') ) ? get_query_var('paged') : 1 );
		$query->set('posts_per_page',6);
	  }
	}
  }


  if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Unisson General Settings',
		'menu_title'	=> 'Unisson Settings',
		'menu_slug' 	=> 'unisson-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> true
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Unisson Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'unisson-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Unisson Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'unisson-general-settings',
	));
	
}



add_filter( 'woocommerce_breadcrumb_defaults', 'ts_woocommerce_breadcrumbs_change' );
function ts_woocommerce_breadcrumbs_change() {
    return array(
            'delimiter'   => '  ',
            'wrap_before' => '<ul class="breadcrumb">',
            'wrap_after'  => '</ul>',
            'before'      => '<li> ',
            'after'       => '</li>',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
            
        );
}


add_filter('gettext', 'change_backend_product_regular_price', 100, 3 );
function change_backend_product_regular_price( $translated_text, $text, $domain ) {
    global $pagenow, $post_type;

    if ( is_admin() && in_array( $pagenow, ['post.php', 'post-new.php'] )
    && 'product' === $post_type && 'Regular price' === $text  && 'woocommerce' === $domain )
    {
        $translated_text =  __( 'Activity price', $domain );
    }
    return $translated_text;
}