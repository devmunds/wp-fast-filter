<?php 
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

        ?>
        <div class="filter-content">
            <div class="filter-wrap">
                <form action="" class="filter-form">
                    <input type="date" name="post_date" id="filter-date">
                    <input type="submit" value="Pesquisar" id="filter-submit">
                </form>
            </div>       
        <?php

        $catname = get_category_by_slug($atts['category_slug']);
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

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
                'date_query' => array(
                    array(
                        'after'     => $_GET['post_date'],
                        'inclusive' => true,                        
                ),
            ),
        );

        $query = new WP_Query( $args );
    
            if ( $query->have_posts() ) {
                                    
                while ( $query->have_posts() ) {
                    $query->the_post(); 
                    
                    ?>                                    
                        <article class="filter-post-wrap">                            
                            <h2 class="entry-title"><a href="' <?php echo  get_post_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
                            <?php the_excerpt(); ?>                       
                        </article>
                    <?php 
                }
                ?>
                <div class="nav-previous"> <?php previous_posts_link( __( '« Entradas Antigas', 'dms-filter-posts' ) ) ?> </div>
                <div class="nav-next">  <?php next_posts_link( __( 'Próximas Entradas »', 'dms-filter-posts' ), $query->max_num_pages ) ?> </div>
                <?php
                wp_reset_postdata();
               

            } else {
                _e('<h2>Nem um post foi encontrado!</h2>','dms-filter-post');
            }

            echo "</div>";
    }
    
}

//WP_ENQUEUE_STYLE
if(!function_exists('dms_enqueue_scripts')){
    function dms_enqueue_scripts(){
        $plugin_uri = str_replace('/includes', '' , plugin_dir_url(__FILE__));
        wp_enqueue_style('dmsfil-style', $plugin_uri . "/views/styles/css/style.css");
    }
}
