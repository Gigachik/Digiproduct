<?php
add_theme_support('menus');

add_action( 'wp_enqueue_scripts', 'Digiproduct_style' );
add_action( 'wp_enqueue_scripts', 'Digiproduct_scripts' );

require_once('ajax/registration-form/registration-form.php');

add_filter( 'jpeg_quality', function( $quality ){ return 100; } );
add_filter( 'big_image_size_threshold', '__return_false' );

function Digiproduct_style() {
    wp_enqueue_style( 'normalize-style', get_template_directory_uri() . '/assets/scss/normalize.css' );	

    wp_enqueue_style( 'main-style', get_template_directory_uri() . '/assets/scss/style.css' );

}

function Digiproduct_scripts() {
  	wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery.min.js' );
    wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script('custom-registration-script', get_template_directory_uri() . '/ajax/registration-form/registration-form.js', array('jquery'), null, true);

    wp_localize_script('custom-registration-script', 'customRegistrationAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('custom-registration-nonce')
    ));

    wp_enqueue_script( 'main-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true );
}



function custom_registration_menu() {
    add_menu_page('Custom Registration', 'Registration Shortcode', 'manage_options', 'custom-registration', 'custom_registration_admin_page');
}

add_action('admin_menu', 'custom_registration_menu');

function custom_registration_admin_page() { ?>
	<div>
		<h2>Registration form shortcode</h2>
		<p>Use this shortcode <strong>[theme_form_registration]</strong> to display registration form.</p>
	</div>
<?php }