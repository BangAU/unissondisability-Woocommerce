    <?php


add_action( 'wp_ajax_nopriv_filter', 'filter_ajax' );
add_action( 'wp_ajax_filter', 'filter_ajax' );

function filter_ajax() {


    $program_category = $_POST['program-category'];
    $program_location = $_POST['program-location'];
    $program_suburb = $_POST['program-suburb'];
    $sort_by = $_POST['sort_by'];
    
    

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
                            // $available_variations = $product->get_available_variations();
                            // $count = count($available_variations)-1;
                            // $variation_id=$available_variations[$count]['variation_id']; // Getting the variable id of just the 1st product. You can loop $available_variations to get info about each variation.
                            // $variable_product1= new WC_Product_Variation( $variation_id );
                            // $regular_price = $variable_product1 ->regular_price;
                            // $sales_price = $variable_product1 ->sale_price; 
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
    <?php //ic_custom_posts_pagination($loop, $paged); ?>


    <?php wp_reset_postdata(); ?>

    <?php else : ?>
    <p class="text-warning"><?php esc_html_e( 'Sorry, no property matched your criteria.', 'ichelper' ); ?></p>
    <?php endif; ?>
    <?php
    die();
}