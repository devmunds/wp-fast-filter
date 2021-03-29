<?php

if(!is_admin()){
    /*
    *Add shortcode and enqueue scripts
    */
    add_action( 'wp_enqueue_scripts','dms_enqueue_scripts');

    /*
    * Add template filter
    */
    add_action('wpfst_content_filter','add_wpfst_content_filter', 10);

    /*
    * Add template lintings of posts
    */
    add_action('wpfst_content_linting_posts','add_wpfst_content_linting_posts',10);
    add_action('wpfst_content_previous_next','add_wpfst_content_previous_next',10, 1);

    add_action('init', 'add_dms_shortcode');

}

