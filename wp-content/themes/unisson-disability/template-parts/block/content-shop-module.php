<section class="section homefilter--section">
    <div class="container">
        <div class="homefilter">
            <div class="homefilter-selects">
                <div class="custom-dropdown">
                    <div class="custom-dropdown-btn">Program</div>
                    <div class="custom-dropdown-list">
                        <?php 
                        $order = 'asc';
                        $hide_empty = true ;
                        $cat_args = array(
                            'orderby'    => $orderby,
                            'order'      => $order,
                            'hide_empty' => $hide_empty,
                        );
                        $count = 0;
                        $product_categories = get_terms( 'product_cat', $cat_args );
                        if( !empty($product_categories) ){
                        ?>
                        <ul>
                            <?php  foreach ($product_categories as $key => $category) { 
                                $count++;
                                ?>
                            <li>
                                <div class="checkbox">
                                    <input id="<?php echo $category->slug; ?>" type="checkbox"
                                        value="<?php echo $category->slug; ?>">
                                    <label for="<?php echo $category->slug; ?>"><?php echo $category->name; ?></label>
                                </div>
                            </li>
                            <?php } 
                            ?>

                        </ul>
                        <?php } ?>
                    </div>
                </div>
                <div class="custom-dropdown">
                    <div class="custom-dropdown-btn">Location</div>
                    <div class="custom-dropdown-list">

                        <ul>
                            <?php  $terms = get_terms(array('taxonomy'=> 'location','hide_empty' => false, ));  
                         //    $count = 0;
                        foreach ( $terms as $term ) {
                            // $count++;
                            if ($term->parent == 0 ) {
                        ?>
                            <li>
                                <div class="checkbox-dropdown">
                                    <div class="checkbox-dropdown-btn">
                                        <div class="checkbox">
                                            <input id="<?php echo $term->slug; ?>" type="checkbox"
                                                value="<?php echo $term->slug; ?>">
                                            <label for="<?php echo $term->slug; ?>"><?php echo $term->name; ?></label>
                                        </div>
                                    </div>
                                    <?php 
                                $subterms = get_terms(array('taxonomy'=> 'location','hide_empty' => false,'parent'=> $term->term_id));
                                if($subterms): ?>
                                    <div class="checkbox-dropdown-list">
                                        <ul>
                                            <?php  
                                            foreach ($subterms as $key => $value) { 
                                                ?>
                                            <li>
                                                <div class="checkbox">
                                                    <input id="<?php echo $value->slug; ?>" type="checkbox"
                                                        value="<?php echo $value->slug; ?>">
                                                    <label
                                                        for="<?php echo $value->slug; ?>"><?php echo $value->name; ?></label>
                                                </div>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <?php endif; ?>

                                </div>
                            </li>
                            <?php }                   
                         } ?>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="programfilter">
                <div class="programfilter-header">
                    <button id="clear-filters" class="reset-btn color-orange dis-sm">Reset search</button>
                    <div class="sortby">
                        <div class="custom-dropdown">
                            <div class="custom-dropdown-btn">
                                <div class="text"><strong>Sort by -</strong> <span class="preview-text">Price
                                        low to high</span></div>
                            </div>
                            <div class="custom-dropdown-list">
                                <ul>
                                    <li>
                                        <button class="is-checked" data-sort-direction="asc"
                                            data-sort-value="priceLow">Price low to
                                            high</button>
                                    </li>
                                    <li><button data-sort-direction="desc" data-sort-value="priceHigh">Price
                                            high to low</button></li>
                                    <li><button data-sort-direction="asc" data-sort-value="ascending">Ascending
                                            A to Z</button></li>
                                    <li><button data-sort-direction="desc" data-sort-value="descending">Descending Z to
                                            A</button></li>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="programfilter-body">
                    <div class="row programfilter-listing">
                        <?php

                        $args =  array(
                            'post_type'         => 'product',
                            'posts_per_page'    => -1,

                        // 'tax_query' => array(
                        );
                        global $product;
                        $loop = new WP_Query($args );
                        while ( $loop->have_posts() ) : $loop->the_post(); 
                        $thumbnail_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), '', true); 
                        // $terms = get_the_terms( $post->ID, 'list_resource_category' );
                        $post_id = get_the_ID();

                        //get content taxonomies
                        $taxonomies = array();
                        $taxonomies_name = array();
                        $term_list = wp_get_post_terms($post_id,'product_cat', array("fields" => "all"));
                        foreach($term_list as $term_single) {
                        array_push($taxonomies, $term_single->slug);
                        array_push($taxonomies_name, $term_single->name);
                        }
                        //taxonomies tags merge
                        $taxonomies_data = array_merge($taxonomies);
                        $taxonomies_name = array_merge($taxonomies_name);
                        
                        
                        //location

                        $locations = array();
                        $locations_name = array();
                        $location_term_list = wp_get_post_terms($post_id, 'location', array("fields" => "all"));
                        foreach($location_term_list as $location_term_single) {
                        array_push($locations, $location_term_single->slug);
                        array_push($locations_name, $location_term_single->name);
                        }
                        //location tags merge
                        $locations_data = array_merge($locations);
                        $locations_name = array_merge($locations_name);

                        $start_date = get_field('tour_start_date', $post_id);
						$end_date = get_field('tour_end_date', $post_id);

                        ?>
                        <div
                            class="col-lg-4 col-6 homefilter-item <?php print implode(', ',$locations) ;?> <?php print implode(' ', $taxonomies) ;?> ">
                            <div class="programfilter-card">
                                <div class="media">
                                    <img src="<?php echo esc_url( $thumbnail_url[0] ); ?>" alt="">
                                </div>
                                <div class="text">
                                    <h6 class="heading-location">
                                        <?php print implode(', ',$locations_name) ;?>
                                    </h6>
                                    <h3 class="heading-title"><?php the_title(); ?></h3>
                                    <span class="heading-date"><?php echo $start_date; ?> -
                                        <?php echo $end_date; ?></span>
                                    <p><?php the_excerpt();  ?>
                                    </p>
                                    <div class="card-footer">
                                        <div class="price">
                                            <p>Total Cost</p>
                                            <?php 
                                            global $product;

                                                if ($product->is_type( 'simple' )) { ?>
                                            <p class="price-num"><?php echo $product->get_price_html(); ?></p>
                                            <?php } ?>
                                            <?php 
                                                if($product->product_type=='variable') {
                                                    $available_variations = $product->get_available_variations();
                                                    $count = count($available_variations)-1;
                                                    $variation_id=$available_variations[$count]['variation_id']; // Getting the variable id of just the 1st product. You can loop $available_variations to get info about each variation.
                                                    $variable_product1= new WC_Product_Variation( $variation_id );
                                                    $regular_price = $variable_product1 ->regular_price;
                                                    $sales_price = $variable_product1 ->sale_price; ?>
                                            <p class="price-num"><?php echo $regular_price;?></p>
                                            <?php   } ?>

                                        </div>
                                        <a href="<?php the_permalink(); ?>" class="btn btn-yellow">View more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <ul class="pagination text-center">
                        <li class="prev"><a href="#"></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">...</a></li>
                        <li class="next"><a href="#"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>