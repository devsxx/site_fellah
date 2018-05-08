<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package fellah
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function fellah_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'fellah_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function fellah_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'fellah_pingback_header' );


/**
 * Shows Term Title in [adverts_list] if not empty.
 * 
 * This function is executed using adverts_sh_list_before action in
 * /wpadverts/templates/index.php file.
 * 
 * @since 1.1.3
 * @global WP_Query $wp_query   Main WP Query
 * @param array $params         [adverts_list] shortcode params.
 * @return void
 */
function adverts_list_show_term_title( $params ) {
	global $wp_query;
	
	$term = $wp_query->get_queried_object();
	
	if( ! $term instanceof WP_Term ) {
		 return;
	}
	$title = "<h3>" . $term->name . "</h3>";
	echo $title;
}


 