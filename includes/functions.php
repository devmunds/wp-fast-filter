<?php

/**
 * Add template filter
 */
if(! function_exists('add_wpfst_content_filter')){
    function add_wpfst_content_filter(){
        $plugin_uri = str_replace('/includes', '' , plugin_dir_path(__DIR__));
        include $plugin_uri . 'views/templates/forms/filter.php';
    }
}

/**
 * Add template linting posts
 */
if(! function_exists('add_wpfst_content_linting_posts')){
    function add_wpfst_content_linting_posts(){
        $plugin_uri = str_replace('/includes', '' , plugin_dir_path(__DIR__));
        include $plugin_uri . 'views/templates/listings/listing-posts.php';
    }
}

/**
* Add template previous and next
*/
if(! function_exists('add_wpfst_content_previous_next')){
    function add_wpfst_content_previous_next($query){
        $plugin_uri = str_replace('/includes', '' , plugin_dir_path(__DIR__));
        include $plugin_uri . 'views/templates/listings/nav-previous-next.php';
    }
}

/**
* get posts by category
*/
if(!function_exists('dms_get_posts')){
    function dms_get_posts($atts = [], $html = null ){

        $atts = shortcode_atts(
            array(
                'posts_per_page' => '' ,
                'category_slug'  => '',
            ),             
            $atts, 'wp-fast-filter'
        );    

        $html           = do_action('wpfst_content_filter');

        $catname        = get_category_by_slug($atts['category_slug']);
        $paged          = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $order          = 'DESC';
        $data_query     = [];

        if(!empty(isset($_POST['filter-year']))){
            $data_query = [
                [
                    'year'      => sanitize_text_field($_POST['filter-year'], FILTER_VALIDATE_INT),
                ]
            ];

            $order = 'ASC';
        }

        if(!empty( isset($_POST['filter-year'])  && isset($_POST['filter-month']))){
            $data_query = [
                [
                    'year'      => sanitize_text_field($_POST['filter-year'], FILTER_VALIDATE_INT),
                    'month'     => sanitize_text_field($_POST['filter-month'], FILTER_VALIDATE_INT),  
                ]
            ];

            $order = 'ASC';
        }       


        $args = array(
            'order'                 =>  sanitize_text_field($order),
            'orderby'               =>  'date',
			'post_status'           =>  'publish',            
            'post_type'             =>  'post',
            'posts_per_page'        =>  sanitize_text_field($atts['posts_per_page']),
            'paged'                 =>  $paged,
            'tax_query'             =>  array(
                                            array(
                                                'taxonomy'              => 'category',
                                                'field'                 => 'slug',
                                                'terms'                 =>  $catname->slug,
                                            ),
            ),                            
            'date_query'            => $data_query
        
        );

        $query = new WP_Query( $args );
    
            if ( $query->have_posts() ) {
                                    
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $html = do_action('wpfst_content_linting_posts');                    
                }
                                
                $html = do_action('wpfst_content_previous_next', $query);
                
                wp_reset_postdata();
               

            } else {
                $html = _e('<h2>Nenhuma notícia  encontrada.</h2>','wp-fast-filter');
            }

            $html =  "</div>";

            return $html;
    }
    
}

/**
* add shortcode
*/
if(!function_exists('add_dms_shortcode')){
    function add_dms_shortcode(){
        add_shortcode('wp-fast-filtes','dms_get_posts');
    }
}

/**
 * wp_enqueue_script
 * wp_enqueue_style
 * wp_register_style
 * wp_register_script
 */
if(!function_exists('dms_enqueue_scripts')){
    function dms_enqueue_scripts(){        
        if(!is_admin()){
            $plugin_uri = str_replace('/includes', '' , plugin_dir_url(__FILE__));

            //Register scripts
            wp_register_style('wpftf-style',  $plugin_uri . "views/styles/css/style.css", array(), '1.0.1', false);

            //Enqueue scripts
            wp_enqueue_style('wpftf-style');
        }
    }
}
