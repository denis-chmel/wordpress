<?php
/**
 * This file adds the Landing template to the Agency Pro Theme.
 *
 * @author StudioPress
 * @package Agency Pro
 * @subpackage Customizations
 */

/*
Template Name: Landing2
*/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
    </head>
111
<?php

//if ( have_posts() ) : while ( have_posts() ) : 
the_post();

do_action( 'genesis_post_content' );

//genesis_legacy_loop();
return;
do_action( 'genesis_entry_header' );

	
			do_action( 'genesis_before_entry_content' );
			printf( '<div %s>', genesis_attr( 'entry-content' ) );
				do_action( 'genesis_entry_content' );
			echo '</div>'; //** end .entry-content
			do_action( 'genesis_after_entry_content' );
			
			do_action( 'genesis_entry_footer' );
	

//do_action( 'genesis_loop' );

