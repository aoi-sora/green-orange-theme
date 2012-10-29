<?php
/*
 * Other theme initialization here
 */

/**
 * add head
 **/
function add_head() {
    
}
add_action('wp_head', 'add_head');
 
/**  post types **/
function startup_post_type() {
    /* portfolio */
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('Portfolios'),
            'singular_name' => __('Portfolio')
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'portfolios'),
        'menu_icon' => get_stylesheet_directory_uri()."/inc/images/portfolio-icon-menu.png"        
    ));
    
    /* home sliding image */
    register_post_type('top-sliding-image', array(
        'labels' => array(
            'name' => __('Top Sliding Images'),
            'singular_name' => __('Top Sliding Image')
        ),
        'public' => true,
        'has_archive' => false,
        'rewrite' => array('slug' => 'top-sliding-images'),
        'menu_icon' => get_stylesheet_directory_uri()."/inc/images/sliding-image-icon.png",
        'supports'  => array('title')
    ));    
}


 /* All features are directly associated with a functional area of the edit screen, such as the
 * editor or a meta box: 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author',
 * 'excerpt', 'page-attributes', 'thumbnail', and 'custom-fields'.
 */
add_action('init', 'startup_post_type');
 


function debug($v) {
	echo '<pre>', print_r($v), '</pre>';
}

 