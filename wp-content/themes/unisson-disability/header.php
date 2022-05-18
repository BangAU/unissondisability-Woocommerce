<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Unisson_Disability
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/index.css">

    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="header dis-lg">
        <div class="header-top">
            <div class="container">
                <div class="inner">
                    <div class="logo">
                        <?php 
                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                         
                        if ( has_custom_logo() ) {
                            echo ' <a href="' . esc_url( home_url( '/' ) ) . '"><img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '">'. '</a>';
                        } else {
                            echo '<h1>' . get_bloginfo('name') . '</h1>';
                        }
                        
                        ?>
                    </div>
                    <div class="tools">
                        <div class="access-dropdown custom-dropdown">
                            <div class="custom-dropdown-btn btn btn-yellow">Accessibility</div>
                            <div class="custom-dropdown-list">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <div class="icon">
                                                <img src="https://unissondisability.org.au/themes/unisson_disability_v2/css/images/icon-contrast.png"
                                                    alt="">
                                            </div>
                                            <div class="text">
                                                High Contrast
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="icon">
                                                <img src="https://unissondisability.org.au/themes/unisson_disability_v2/css/images/icon-large-text.png"
                                                    alt="">
                                            </div>
                                            <div class="text">
                                                Text larger
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="icon">
                                                <img src="https://unissondisability.org.au/themes/unisson_disability_v2/css/images/icon-small-text.png"
                                                    alt="">
                                            </div>
                                            <div class="text">
                                                Text smaller
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="icon">
                                                <img src="https://unissondisability.org.au/themes/unisson_disability_v2/css/images/icon-dyslexic.png"
                                                    alt="">
                                            </div>
                                            <div class="text">
                                                Dyslexic font
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="icon">
                                                <img src="https://unissondisability.org.au/themes/unisson_disability_v2/css/images/icon-translate.png"
                                                    alt="">
                                            </div>
                                            <div class="text">
                                                Google translate
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="icon">
                                                <img src="https://unissondisability.org.au/themes/unisson_disability_v2/css/images/icon-reset.png"
                                                    alt="">
                                            </div>
                                            <div class="text">
                                                Reset view
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="header-search">
                        <?php get_search_form(true); ?>
                    </div>
                    <div class="header-account">

                        <?php if ( is_user_logged_in() ) { ?>

                        <div class="header-myaccount custom-dropdown">
                            <div class="custom-dropdown-btn">
                                <div class="icon">
                                    <img src="<?php echo get_template_directory_uri();?>/./images/icons/icon-user.svg"
                                        alt="">
                                </div>
                                <div class="text">My Account</div>
                            </div>
                            <div class="custom-dropdown-list">
                                <ul>
                                    <li><a
                                            href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">Dashbord</a>
                                    </li>
                                    <li><a
                                            href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>orders">My
                                            Orders</a></li>
                                    <li><a
                                            href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>edit-account/">Account
                                            Details</a></li>
                                    <li><a href="<?php echo esc_url( wc_logout_url() ); ?>">Logout</a></li>
                                </ul>
                            </div>
                        </div>

                        <?php } 
                            else { ?>

                        <div class="header-myaccount custom-dropdown">
                            <div class="custom-dropdown-btn">
                                <div class="icon"><img
                                        src="<?php echo get_template_directory_uri();?>/./images/icons/icon-user.svg"
                                        alt=""></div>
                                <div class="text">My Account</div>
                            </div>
                            <div class="custom-dropdown-list">
                                <ul>
                                    <li><a
                                            href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">Login</a>
                                    </li>
                                    <li><a
                                            href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">Register</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="header-cart">
                        <a href="#" class="cart-customlocation"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bot">
            <div class="container">
                <div class="inner">
                    <div class="header-nav">
                    
                        <?php
						if ( has_nav_menu( 'menu-1' ) ) :
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_class'        => 'navul',
                                    'walker'          => new wp_bootstrap_navwalker(),
                                    'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
								)
							);
						endif;
						?>
                    </div>
                    <a href="#" class="btn btn-orange">Donate Now</a>
                </div>
            </div>
        </div>
    </header>

    <header class="header header-sm app-lg">
        <div class="header-main">
            <div class="container">
                <div class="inner">
                    <div class="logo">
                    <?php 
                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                         
                        if ( has_custom_logo() ) {
                            echo ' <a href="' . esc_url( home_url( '/' ) ) . '"><img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '">'. '</a>';
                        } else {
                            echo '<h1>' . get_bloginfo('name') . '</h1>';
                        }
                        
                        ?>
                    </div>
                    <div class="hamburger menu-toggle">
                        <img src="<?php echo get_template_directory_uri();?>/./images/icons/hamburger.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="sidemenu">
        <div class="container">
            <div class="inner">
                <div class="sidemenu-search">
                    <div class="header-search">
                        <?php get_search_form(true); ?>
                    </div>
                </div>
                <div class="sidemenu-blocklinks">
                    <div class="header-account">
                        <div class="header-myaccount">
                            <div class="custom-dropdown-btn">
                                <div class="icon"><img src="<?php echo get_template_directory_uri();?>/./images/icons/icon-user.svg" alt=""></div>
                                <div class="text"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">My Account</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="header-cart">
                        <a href="#" class="cart-customlocation"></a>
                    </div>
                </div>


                <div class="sidemenu-nav">
                <?php
						if ( has_nav_menu( 'menu-1' ) ) :
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_class'        => 'navul',
                                    'walker'          => new wp_bootstrap_navwalker(),
                                    'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
								)
							);
						endif;
						?>
                </div>
            </div>
        </div>
    </div>

    <main class="sitecontent">