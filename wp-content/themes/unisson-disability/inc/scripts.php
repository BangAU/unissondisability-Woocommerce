<?php
/*
* Enqueue scripts.js if file scripts.js exists
*/
function load_scripts() {

	wp_enqueue_script('ajax', get_template_directory_uri() . '/js/vendor/scripts.js', array('jquery'), NULL, true);

	wp_localize_script('ajax' , 'wpAjax', 
		array('ajaxUrl' => admin_url('admin-ajax.php'))
	);

}

add_action( 'wp_enqueue_scripts', 'load_scripts' );


/*
* Custom Post Pagination
* @since 1.0.0
* return 
*/
if (!function_exists('ic_custom_posts_pagination')) :
    function ic_custom_posts_pagination($the_query=NULL, $paged=1){

        global $wp_query;
        $the_query = !empty($the_query) ? $the_query : $wp_query;

        if ($the_query->max_num_pages > 1) {
            $big = 999999999; // need an unlikely integer
            $items = paginate_links(apply_filters('adimans_posts_pagination_paginate_links', array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'prev_next' => TRUE,
                'current' => max(1, $paged),
                'total' => $the_query->max_num_pages,
                'type' => 'array',
                'prev_text' => ' <i class="fas fa-angle-double-left"></i> ',
                'next_text' => ' <i class="fas fa-angle-double-right"></i> ',
                'end_size' => 1,
                'mid_size' => 1
            )));

            $pagination = "<ul class=\"pagination text-center\"><li>";
            $pagination .= join("</li><li>", (array)$items);
            $pagination .= "</li></ul>";

            echo apply_filters('ic_posts_pagination', $pagination, $items, $the_query);
        }
    }
endif;

// <ul class="pagination text-center">
// <li class="prev"><a href="#"></a></li>
// <li class="active"><a href="#">1</a></li>
// <li><a href="#">2</a></li>
// <li><a href="#">3</a></li>
// <li><a href="#">4</a></li>
// <li><a href="#">...</a></li>
// <li class="next"><a href="#"></a></li>
// </ul> 