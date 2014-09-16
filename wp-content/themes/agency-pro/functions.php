<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'agency', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'agency' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Agency Pro Theme', 'agency' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/agency/' );
define( 'CHILD_THEME_VERSION', '3.0.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue EB Garamond and Spinnaker Google fonts
add_action( 'wp_enqueue_scripts', 'agency_google_fonts' );
function agency_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=EB+Garamond|Spinnaker', array(), CHILD_THEME_VERSION );
	
}

//* Enqueue Backstretch script and prepare images for loading
add_action( 'wp_enqueue_scripts', 'agency_enqueue_backstretch_scripts' );
function agency_enqueue_backstretch_scripts() {

	//* Load scripts only if custom background is being used
	if ( ! get_background_image() )
		return;

	wp_enqueue_script( 'agency-pro-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'agency-pro-backstretch-set', get_bloginfo( 'stylesheet_directory' ).'/js/backstretch-set.js' , array( 'jquery', 'agency-pro-backstretch' ), '1.0.0' );

	wp_localize_script( 'agency-pro-backstretch-set', 'BackStretchImg', array( 'src' => str_replace( 'http:', '', get_background_image() ) ) );

}

//* Add new image sizes
add_image_size( 'home-bottom', 380, 150, TRUE );
add_image_size( 'home-middle', 380, 380, TRUE );

//* Add support for custom background
add_theme_support( 'custom-background', array( 'wp-head-callback' => 'agency_background_callback' ) ); 

//* Add custom background callback for background color
function agency_background_callback() {

    if ( ! get_background_color() )
        return;

    printf( '<style>body { background-color: #%s !important; }</style>' . "\n", get_background_color() );

}

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 60,
	'width'           => 300,
) );

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'agency-pro-blue'   => __( 'Agency Pro Blue', 'agency' ),
	'agency-pro-green'  => __( 'Agency Pro Green', 'agency' ),
	'agency-pro-orange' => __( 'Agency Pro Orange', 'agency' ),
	'agency-pro-red'    => __( 'Agency Pro Red', 'agency' ),
) );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Reposition the header
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
add_action( 'genesis_before', 'genesis_header_markup_open', 5 );
add_action( 'genesis_before', 'genesis_do_header', 10 );
add_action( 'genesis_before', 'genesis_header_markup_close', 15 );

//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Hook after post widget after the entry content
add_action( 'genesis_after_entry', 'agency_after_entry', 5 );
function agency_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry widget-area">',
			'after'  => '</div>',
		) );

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'agency_remove_comment_form_allowed_tags' );
function agency_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home Top', 'agency' ),
	'description' => __( 'This is the top section of the homepage.', 'agency' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Home Middle', 'agency' ),
	'description' => __( 'This is the middle section of the homepage.', 'agency' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home Bottom', 'agency' ),
	'description' => __( 'This is the bottom section of the homepage.', 'agency' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'agency' ),
	'description' => __( 'This is the after entry widget area.', 'agency' ),
) );



//* Everything Below is Victor's Custom Code

//* Add Jetpack share buttons above post
remove_filter( 'the_content', 'sharing_display', 19 );
remove_filter( 'the_excerpt', 'sharing_display', 19 );
 
add_filter( 'the_content', 'sp_share_buttons_above_post', 19 );
add_filter( 'the_excerpt', 'sp_share_buttons_above_post', 19 );
 
function sp_share_buttons_above_post( $content = '' ) {
	if ( function_exists( 'sharing_display' ) ) {
		return sharing_display() . $content;
	}
	else {
		return $content;
	}
}

//* Customize the credits
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
function sp_footer_creds_text() {
	echo '<div class="creds"><p>';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; <a href="http://www.gobask.com">Bask Labs Inc</a>';
	echo '</p></div>';
}

//* After Header Landing Widget
genesis_register_sidebar( array(
	'id'          => 'after-header',
	'name'        => __( 'After Header Banner', '$text_domain' ),
	'description' => __( 'Adds a Widget Area After The Header', '$text_domain' ),
) );
 
add_action( 'genesis_after_header', 'after_header_widget' );
 
function after_header_widget() {
 
if ( is_page_template( 'page_landing.php' ) && is_active_sidebar('after-header') ) {
 
		genesis_widget_area( 'after-header', array(
			'before' => '<div class="after-header" class="widget-area">',
			'after'	 => '</div>',
		) );
 
 
 
     }
 
}

//* Before Footer Landing Widget
genesis_register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => __( 'Before Footer Banner', '$text_domain' ),
	'description' => __( 'Adds a Widget Area Before the Footer', '$text_domain' ),
) );
 
add_action( 'genesis_before_footer', 'before_footer_widget' );
 
function before_footer_widget() {
 
if ( is_page_template( 'page_landing.php' ) && is_active_sidebar('before-footer') ) {
 
		genesis_widget_area( 'before-footer', array(
			'before' => '<div class="before-footer" class="widget-area">',
			'after'	 => '</div>',
		) );
 
 
 
     }
 
}
