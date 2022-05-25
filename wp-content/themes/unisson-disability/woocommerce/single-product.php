<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
<section class="section pageheader--section">
    <div class="container">
        <div class="pageheader">
			<?php
			/**
			 * woocommerce_before_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			do_action( 'woocommerce_before_main_content' );
			?>

        </div>
    </div>
</section>
<section class="section productsec--section background-white pageheader--pullup bgcolor-white">
    <div class="container">
        <div class="productsec">
            <div class="row">
                <?php while ( have_posts() ) : ?>
                <?php the_post(); ?>
                <div class="col-lg-6 productsec--col-media">
                    <div class="productsec--media">
                        <div class="productsec--media-primary">
                            <div class="productsec--media-primary-slider">
                                <?php $attachment_ids = $product->get_gallery_attachment_ids(); ?>
                                <?php  foreach( $attachment_ids as $attachment_id ) {
      										  $image_link =wp_get_attachment_url( $attachment_id ); ?>
                                <div class="item">
                                    <div class="media-item">
                                        <?php  echo '<img src="' . $image_link . '">';?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="slider-navwrap">
                                <span class="slidenav-prev"></span>
                                <span class="slidenav-next"></span>
                                <div class="num">1/4</div>
                            </div>
                        </div>
                        <div class="productsec--media-secondary dis-md">
                            <div class="productsec--media-secondary-slider">
                                <?php  foreach( $attachment_ids as $attachment_id ) {
      										  $image_link =wp_get_attachment_url( $attachment_id ); ?>
                                <div class="item">
                                    <div class="media-item">
                                        <?php  echo '<img src="' . $image_link . '">';?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 productsec--col-text">
                    <div class="productsec--text">
                        <h6 class="heading-location">Beaumont Hills</h6>
                        <h2 class="heading-title">Urban Adventurers</h2>
                        <h5 class="heading-date">February 28th - May 28th 2022</h5>
                        <div class="productsec-description">
                            <p>Unisson Disability host an Urban Adventurers Weekly Program for people with a
                                physical, psychosocial, and/or intellectual disability. Participants will have
                                the opportunity to socialise with similar aged people (18 years and over) with
                                support to enjoy relevant and fun activities.</p>
                            <p>Total costs is made up of $50 activity costs and $80 support cost. Please note,
                                support costs will be invoiced directly after the program has been completed.
                            </p>
                            <p><strong>The program runs over a 12-week period, each week consisting of a
                                    different activity, for more details see below.</strong></p>
                        </div>
                        <div class="price">
                            <p>Total cost</p>
                            <p class="price-num">$130</p>
                        </div>
                        <div class="productsec--footer">
                            <div class="product--num">
                                <div class="product--num-minus"></div>
                                <input type="number" class="product--num-input" min="1" max="25" value="1">
                                <div class="product--num-plus"></div>
                            </div>
                            <button class="btn btn-orange product-addtocart">
                                <div class="icon"><img src="<?php echo get_template_directory_uri();?>/./images/icons/icon-cart-white.svg" alt=""></div>
                                <div class="text">Add to Cart</div>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>

<section class="section productfaq--section bgcolor-gray">
    <div class="container">
        <div class="productfaq">
            <div class="customtab">
                <div class="customtab--nav">
                    <div class="customtab--nav-preview">More information - <span
                            class="customtab--nav-active">Itenerary</span></div>
                    <ul class="customtab--nav-list">
                        <li><a href="tab1">Program Overview</a></li>
                        <li class="active"><a href="tab2">Itinerary</a></li>
                        <li><a href="tab3">How Pricing Works</a></li>
                        <li><a href="tab4">Terms &amp; Conditions</a></li>
                        <li><a href="tab5">FAQs</a></li>
                    </ul>
                </div>
                <div class="customtab--content">
                    <div class="customtab--content-item" data-id="tab1">
                        <h2>Program overview</h2>
                    </div>
                    <div class="customtab--content-item active" data-id="tab2">
                        <h2 class="heading-text color-purple">Activity program week schedule</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                            irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                            pariatur.</p>

                        <div class="customaccord">
                            <div class="customaccord--item active">
                                <div class="customaccord--item-header">
                                    <h2><span>Week 1</span> - Meet and greet</h2>
                                </div>
                                <div class="customaccord--item-body">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="media">
                                                <img src="<?php echo get_template_directory_uri();?>/./images/accord-img.png" alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <h4>When</h4>
                                            <p>Saturday March 5: 9:00am – 3:00pm</p>
                                            <h4>Schedule</h4>
                                            <ul>
                                                <li>Meet and greet at Beaumont Hills Community Access</li>
                                                <li>Visit the local grocery store to purchase items for the BBQ
                                                </li>
                                                <li>Head out to Cattai National Park</li>
                                                <li>Lunch time</li>
                                                <li>Afternoon of games</li>
                                                <li>Return to Beaumont Hills Community Access</li>
                                            </ul>
                                            <h4>Where</h4>
                                            <p>Unisson Disability Community Access Beaumont Hills 12-14 Cressy
                                                Ave, Beaumont Hills NSW 2155</p>
                                            <h4>Cost</h4>
                                            <p>$10</p>
                                            <h4>What to bring</h4>
                                            <p>Hat, sunscreen, water bottle and comfortable shoes</p>
                                            <h4>Goal</h4>
                                            <p>Social networking, cooking skills, grocery shopping, managing a
                                                shopping list and handling money.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="customaccord--item">
                                <div class="customaccord--item-header">
                                    <h2><span>Week 2</span> - Meet and greet</h2>
                                </div>
                                <div class="customaccord--item-body">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="media">
                                                <img src="<?php echo get_template_directory_uri();?>/./images/accord-img.png" alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <h4>When</h4>
                                            <p>Saturday March 5: 9:00am – 3:00pm</p>
                                            <h4>Schedule</h4>
                                            <ul>
                                                <li>Meet and greet at Beaumont Hills Community Access</li>
                                                <li>Visit the local grocery store to purchase items for the BBQ
                                                </li>
                                                <li>Head out to Cattai National Park</li>
                                                <li>Lunch time</li>
                                                <li>Afternoon of games</li>
                                                <li>Return to Beaumont Hills Community Access</li>
                                            </ul>
                                            <h4>Where</h4>
                                            <p>Unisson Disability Community Access Beaumont Hills 12-14 Cressy
                                                Ave, Beaumont Hills NSW 2155</p>
                                            <h4>Cost</h4>
                                            <p>$10</p>
                                            <h4>What to bring</h4>
                                            <p>Hat, sunscreen, water bottle and comfortable shoes</p>
                                            <h4>Goal</h4>
                                            <p>Social networking, cooking skills, grocery shopping, managing a
                                                shopping list and handling money.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="customaccord--item">
                                <div class="customaccord--item-header">
                                    <h2><span>Week 3</span> - Meet and greet</h2>
                                </div>
                                <div class="customaccord--item-body">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="media">
                                                <img src="<?php echo get_template_directory_uri();?>/./images/accord-img.png" alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <h4>When</h4>
                                            <p>Saturday March 5: 9:00am – 3:00pm</p>
                                            <h4>Schedule</h4>
                                            <ul>
                                                <li>Meet and greet at Beaumont Hills Community Access</li>
                                                <li>Visit the local grocery store to purchase items for the BBQ
                                                </li>
                                                <li>Head out to Cattai National Park</li>
                                                <li>Lunch time</li>
                                                <li>Afternoon of games</li>
                                                <li>Return to Beaumont Hills Community Access</li>
                                            </ul>
                                            <h4>Where</h4>
                                            <p>Unisson Disability Community Access Beaumont Hills 12-14 Cressy
                                                Ave, Beaumont Hills NSW 2155</p>
                                            <h4>Cost</h4>
                                            <p>$10</p>
                                            <h4>What to bring</h4>
                                            <p>Hat, sunscreen, water bottle and comfortable shoes</p>
                                            <h4>Goal</h4>
                                            <p>Social networking, cooking skills, grocery shopping, managing a
                                                shopping list and handling money.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="customaccord--item">
                                <div class="customaccord--item-header">
                                    <h2><span>Week 4</span> - Meet and greet</h2>
                                </div>
                                <div class="customaccord--item-body">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="media">
                                                <img src="<?php echo get_template_directory_uri();?>/./images/accord-img.png" alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <h4>When</h4>
                                            <p>Saturday March 5: 9:00am – 3:00pm</p>
                                            <h4>Schedule</h4>
                                            <ul>
                                                <li>Meet and greet at Beaumont Hills Community Access</li>
                                                <li>Visit the local grocery store to purchase items for the BBQ
                                                </li>
                                                <li>Head out to Cattai National Park</li>
                                                <li>Lunch time</li>
                                                <li>Afternoon of games</li>
                                                <li>Return to Beaumont Hills Community Access</li>
                                            </ul>
                                            <h4>Where</h4>
                                            <p>Unisson Disability Community Access Beaumont Hills 12-14 Cressy
                                                Ave, Beaumont Hills NSW 2155</p>
                                            <h4>Cost</h4>
                                            <p>$10</p>
                                            <h4>What to bring</h4>
                                            <p>Hat, sunscreen, water bottle and comfortable shoes</p>
                                            <h4>Goal</h4>
                                            <p>Social networking, cooking skills, grocery shopping, managing a
                                                shopping list and handling money.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="customaccord--item">
                                <div class="customaccord--item-header">
                                    <h2><span>Week 5</span> - Meet and greet</h2>
                                </div>
                                <div class="customaccord--item-body">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="media">
                                                <img src="<?php echo get_template_directory_uri();?>/./images/accord-img.png" alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <h4>When</h4>
                                            <p>Saturday March 5: 9:00am – 3:00pm</p>
                                            <h4>Schedule</h4>
                                            <ul>
                                                <li>Meet and greet at Beaumont Hills Community Access</li>
                                                <li>Visit the local grocery store to purchase items for the BBQ
                                                </li>
                                                <li>Head out to Cattai National Park</li>
                                                <li>Lunch time</li>
                                                <li>Afternoon of games</li>
                                                <li>Return to Beaumont Hills Community Access</li>
                                            </ul>
                                            <h4>Where</h4>
                                            <p>Unisson Disability Community Access Beaumont Hills 12-14 Cressy
                                                Ave, Beaumont Hills NSW 2155</p>
                                            <h4>Cost</h4>
                                            <p>$10</p>
                                            <h4>What to bring</h4>
                                            <p>Hat, sunscreen, water bottle and comfortable shoes</p>
                                            <h4>Goal</h4>
                                            <p>Social networking, cooking skills, grocery shopping, managing a
                                                shopping list and handling money.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="customaccord--item">
                                <div class="customaccord--item-header">
                                    <h2><span>Week 6</span> - Meet and greet</h2>
                                </div>
                                <div class="customaccord--item-body">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="media">
                                                <img src="<?php echo get_template_directory_uri();?>/./images/accord-img.png" alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <h4>When</h4>
                                            <p>Saturday March 5: 9:00am – 3:00pm</p>
                                            <h4>Schedule</h4>
                                            <ul>
                                                <li>Meet and greet at Beaumont Hills Community Access</li>
                                                <li>Visit the local grocery store to purchase items for the BBQ
                                                </li>
                                                <li>Head out to Cattai National Park</li>
                                                <li>Lunch time</li>
                                                <li>Afternoon of games</li>
                                                <li>Return to Beaumont Hills Community Access</li>
                                            </ul>
                                            <h4>Where</h4>
                                            <p>Unisson Disability Community Access Beaumont Hills 12-14 Cressy
                                                Ave, Beaumont Hills NSW 2155</p>
                                            <h4>Cost</h4>
                                            <p>$10</p>
                                            <h4>What to bring</h4>
                                            <p>Hat, sunscreen, water bottle and comfortable shoes</p>
                                            <h4>Goal</h4>
                                            <p>Social networking, cooking skills, grocery shopping, managing a
                                                shopping list and handling money.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="customtab--content-item" data-id="tab3">
                        <h2>How Pricing Works</h2>
                    </div>
                    <div class="customtab--content-item" data-id="tab4">
                        <h2>Terms &amp; Conditions</h2>
                    </div>
                    <div class="customtab--content-item" data-id="tab5">
                        <h2>FAQs</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section ctafooter--section bgcolor-gray">
    <div class="container">
        <div class="ctafooter bgcolor-orange">
            <h2 class="heading">Urban adventures brochure</h2>
            <a href="#" class="btn btn-purple">
                <div class="icon"><img src="<?php echo get_template_directory_uri();?>/./images/icons/icon-download.svg" alt=""></div>
                <div class="text">Download</div>
            </a>
        </div>
    </div>
</section>
<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
	//	do_action( 'woocommerce_before_main_content' );
	?>

<?php //while ( have_posts() ) : ?>
<?php //the_post(); ?>

<?php //wc_get_template_part( 'content', 'single-product' ); ?>

<?php// endwhile; // end of the loop. ?>

<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
	//	do_action( 'woocommerce_after_main_content' );
	?>

<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
	//	do_action( 'woocommerce_sidebar' );
	?>

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */