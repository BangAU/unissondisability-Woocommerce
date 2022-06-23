<section class="section homefilter--section">
    <div class="container">
        <div class="homefilter">
            <form data-css-form="filter" data-js-form="filter">
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
                                            name="program-category[]" value="<?= $category->term_id; ?>">
                                        <label
                                            for="<?php echo $category->slug; ?>"><?php echo $category->name; ?></label>
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
                                                    name="program-location[]" value="<?= $term->term_id; ?>">
                                                <label
                                                    for="<?php echo $term->slug; ?>"><?php echo $term->name; ?></label>
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
                                                            name="program-suburb[]" value="<?= $value->term_id; ?>">
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
                                <select id="sort_by" name="sort_by" class="sort_by_dropdown">
                                    <option value="dateposted-desc">Sort by Newest</option>
                                    <option value="price-desc">Sort by Price (High to Low)</option>
                                    <option value="price-asc">Sort by Price (Low to High)</option>
                                    <option value="program-desc">Descending Z
                                        to
                                        A</option>
                                    <option value="program-asc">Ascending
                                        A to Z</option>
                                </select>
                                <!-- <div class="custom-dropdown-btn"> -->


                                <!-- <div class="text"><strong>Sort by -</strong>
                                        <span class="preview-text">Price
                                            low to high</span>
                                    </div>-->
                            </div>

                            <!-- <div class="custom-dropdown-list">
                                    <ul>
                                        <li>
                                            <button class="is-checked" data-sort-direction="asc"
                                                data-sort-value="priceLow">Price low to
                                                high</button>
                                        </li>
                                        <li><button data-sort-direction="desc" data-sort-value="priceHigh">Price
                                                high to low</button></li>
                                        <li><button id="program-asc" name="program-asc">Ascending
                                                A to Z</button></li>
                                        <li><button data-sort-direction="desc" data-sort-value="descending">Descending Z
                                                to
                                                A</button></li>
                                        </li>

                                    </ul>

                                </div> -->
                            <!-- </div> -->
                        </div>
                    </div>
                    <fieldset data-css-form="group right" style="display:none;">
                        <button data-css-button="button red">Filter</button>
                        <input type="hidden" name="action" value="filter">
                    </fieldset>
            </form>
            <div class="loading-div"></div>
            <div class="programfilter-body">
                <div class="row programfilter-listing" data-js-filter="target">
                    <?php
                            $program_category = $_POST['program-category'];
                            $program_location = $_POST['program-location'];
                            $program_suburb = $_POST['program-suburb'];
                            $sort_by = $_POST['sort_by'];
                            
                            // echo $sort_by;
                            //  print_r($_POST);
                            
                            $property_per_page = 6;
                            if ( get_query_var( 'paged' ) ) { 
                                $paged = get_query_var( 'paged' ); 
                            } elseif ( get_query_var( 'page' ) ) { 
                                $paged = get_query_var( 'page' ); 
                            } else { 
                                $paged = 1; 
                            }
                            $args = array(
                                'post_type'        	=> 'product',
                                'posts_per_page'  	=> $property_per_page ? (int)$property_per_page : 6,
                                'paged' 		=> $paged,
                                
                            );
                        
                        
                            if(!empty($program_category)){
                                $args[tax_query] = array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'term_id',
                                        'terms' => $program_category
                                    )
                                    );
                            }
                            if(!empty($program_location)){
                                $args[tax_query] = array(
                                    array(
                                        'taxonomy' => 'location',
                                        'field' => 'term_id',
                                        'terms' => $program_location
                                    )
                                    );
                            }
                            if(!empty($program_suburb)){
                                $args[tax_query] = array(
                                    array(
                                        'taxonomy' => 'location',
                                        'field' => 'term_id',
                                        'terms' => $program_suburb
                                    )
                                    );
                            }

                            if(!empty($sort_by)){

                            $order_param = '';

                            if($sort_by == 'dateposted-desc'){
                                $order_param = 'date';
                            }
                            elseif($sort_by == 'price-desc'){
                                $order_param = 'meta_value_num';
                                $args['meta_key'] = '_price';
                                $args['order'] = 'DESC';
                            }
                            elseif($sort_by == 'price-asc'){
                                $order_param = 'meta_value_num';
                                $args['meta_key'] = '_price';
                                $args['order'] = 'ASC';
                            }elseif($sort_by == 'program-asc'){
                                // $order_param = 'meta_value_num';
                                //$args['meta_key'] = '_price';
                                $args['order'] = 'ASC';
                            }elseif($sort_by == 'program-asc'){
                                // $order_param = 'meta_value_num';
                                // $args['meta_key'] = '_price';
                                $args['order'] = 'ASC';
                            } else {
                                $order_param = 'date';
                            }
                            $args['orderby'] = $order_param;
                            }

                        
                        global $product;
                        $loop = new WP_Query($args );
                        if ( $loop->have_posts() ) :

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
                    <div class="col-lg-4 col-md-6 homefilter-item">
                        <div class="programfilter-card">
                            <div class="media">
                                <img src="<?php echo esc_url( $thumbnail_url[0] ); ?>" alt="">
                            </div>
                            <div class="text">
                                <h6 class="heading-location">
                                    <?php print implode(' - ',$locations_name) ;?>
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
                                                    
                                                    $prices = $product->get_variation_prices('min', true );
                                                    $maxprices = $product->get_variation_price( 'max', true ) ;
                                                    $min_price = current( $prices['price'] );
                                                    //$max_price = current( $maxprices['price'] );
                                                    $minPrice = sprintf( __( '%1$s', 'woocommerce' ), wc_price( $min_price ) );
                                                    $maxPrice = sprintf( __( '%1$s', 'woocommerce' ), wc_price( $maxprices ) );
                                                    
                                                    ?>
                                        <p class="price-num"><?php echo $maxPrice;?></p>
                                        <?php   } ?>

                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-yellow">View more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php endwhile; ?>

                    <?php ic_custom_posts_pagination($loop, $paged); ?>

                    <?php wp_reset_postdata(); ?>

                    <?php else : ?>
                    <p class="text-warning">
                        <?php esc_html_e( 'Sorry, no property matched your criteria.', 'ichelper' ); ?></p>
                    <?php endif; ?>

                </div>


            </div>
        </div>

    </div>
    </div>
</section>
<section class="section homefilter--section">
    <?php echo do_shortcode('[ajax_filter_posts per_page="6"]'); ?>
</section>