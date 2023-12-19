<?php
add_theme_support('menus');

add_action( 'wp_enqueue_scripts', 'FlexIt_style' );
add_action( 'wp_enqueue_scripts', 'FlexIt_scripts' );




require_once('ajax/filterByTerm/filter-by-terms.php');

add_filter( 'jpeg_quality', function( $quality ){ return 100; } );
add_filter( 'big_image_size_threshold', '__return_false' );

function FlexIt_style() {
    wp_enqueue_style( 'normalize-style', get_template_directory_uri() . '/assets/scss/normalize.css' );

    wp_enqueue_style( 'main-style', get_template_directory_uri() . '/assets/scss/style.css' );

}


function FlexIt_scripts() {
  	wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery.min.js' );
    wp_enqueue_script( 'jquery' );



	wp_enqueue_script('filter-by-terms', get_template_directory_uri() . '/ajax/filterByTerm/filter-by-terms.js', array('jquery'), null, true);
	
	$ajax_params_filter_by_terms = array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'ajax_nonce' => wp_create_nonce('filter-by-terms-nonce') 
	);

	wp_localize_script('filter-by-terms', 'ajax_params_filter_by_terms', $ajax_params_filter_by_terms);
	


    wp_enqueue_script( 'main-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true );
}


