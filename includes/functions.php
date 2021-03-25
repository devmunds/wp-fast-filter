<?php

//Add template filter
if(! function_exists('add_wpfst_content_filter')){
    function add_wpfst_content_filter(){
        $plugin_uri = str_replace('/includes', '' , plugin_dir_path(__DIR__));
        include $plugin_uri . 'views/templates/forms/filter.php';
    }
}
//Add template linting posts
if(! function_exists('add_wpfst_content_linting_posts')){
    function add_wpfst_content_linting_posts(){
        $plugin_uri = str_replace('/includes', '' , plugin_dir_path(__DIR__));
        include $plugin_uri . 'views/templates/listings/listing-posts.php';
    }
}

/*
*Add template previous and next
*/
if(! function_exists('add_wpfst_content_previous_next')){
    function add_wpfst_content_previous_next($query){
        $plugin_uri = str_replace('/includes', '' , plugin_dir_path(__DIR__));
        include $plugin_uri . 'views/templates/listings/nav-previous-next.php';
    }
}

/*
* get posts by category
*/
if(!function_exists('dms_get_posts')){
    function dms_get_posts($atts){

        $atts = shortcode_atts(
            array(
                'posts_per_page' => ' ' ,
                'category_slug' => ' ',
            ), $atts, 'wp-fast-filter');

        //ob_start();

        do_action('wpfst_content_filter');

        $catname = get_category_by_slug($atts['category_slug']);
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        if(!empty(isset($_GET['filter-year']))){
            $year = $_GET['filter-year'];
        }

        if(!empty(isset($_GET['filter-month']))){
            $month = $_GET['filter-month'];
        }

        $data_query = [];

        if($month >= 1){
            $data_query = [
                [
                    'year'=> $year,
                    'month' => $month,  
                ]
            ];
        }elseif($year >= 1){
            $data_query = [
                [
                    'year'=> $year,
                ]
            ];
        }


        $args = array(
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => 'post',
            'posts_per_page' => $atts['posts_per_page'],
            'paged' => $paged,
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'name',
                    'terms' => $catname,
                    'include_children' => false
                ),
            ),                
            'date_query' => $data_query
        
        );

        $query = new WP_Query( $args );
    
            if ( $query->have_posts() ) {
                                    
                while ( $query->have_posts() ) {
                    $query->the_post(); 
                    do_action('wpfst_content_linting_posts');
                }

                do_action('wpfst_content_previous_next', $query);

                wp_reset_postdata();
               

            } else {
                _e('<h2>Nemhum post encontrado.</h2>','wp-fast-filter');
            }

            echo "</div>";

            //return ob_end_clean();
    }
    
}

//WP_ENQUEUE_STYLE
if(!function_exists('dms_enqueue_scripts')){
    function dms_enqueue_scripts(){
        $plugin_uri = str_replace('/includes', '' , plugin_dir_url(__FILE__));
        wp_enqueue_style('dmsfil-style', $plugin_uri . "/views/styles/css/style.css");
    }
}
