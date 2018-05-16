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


 



function crunchify_social_sharing_buttons($content) {
	global $post;
	if( is_singular() && $post->post_type == "advert" ){
		
		$partager_text = esc_html__('Partager','fellah');
		if ( $post->post_type == "advert" ) {
			$partager_text = esc_html__('Partager l\'événement','fellah');
		}

      // Get current page URL 
		$crunchifyURL = urlencode(get_permalink());

      // Get current page title
		$crunchifyTitle = str_replace( ' ', '%20', get_the_title());

    // Get Post Thumbnail for pinterest
		$crunchifyThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

    // Construct sharing URL without using any script
		$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$crunchifyURL;
		$twitterURL = 'https://twitter.com/intent/tweet?text='.$crunchifyTitle.'&amp;url='.$crunchifyURL.'&amp;via=Crunchify';
		$googleURL = 'https://plus.google.com/share?url='.$crunchifyURL;
		$bufferURL = 'https://bufferapp.com/add?url='.$crunchifyURL.'&amp;text='.$crunchifyTitle;
		$whatsappURL = 'whatsapp://send?text='.$crunchifyTitle . ' ' . $crunchifyURL;
		$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$crunchifyURL.'&amp;title='.$crunchifyTitle;

    // Based on popular demand added Pinterest too
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$crunchifyURL.'&amp;media='.$crunchifyThumbnail[0].'&amp;description='.$crunchifyTitle;

    // Add sharing button at the end of page/page content 
		$content .= '<div class="partage">';
		// $content .= '<div class="titre"> ' . $partager_text . ' </div> ';    
		$content .= '<a class="btn btn-facebook" href="'.$facebookURL.'" target="_blank" data-network="facebook"><i class="fa fa-facebook" aria-hidden="true"></i>Facebook</a>';
		$content .= '<a class="btn btn-twitter" href="'. $twitterURL .'" target="_blank" data-network="twitter"><i class="fa fa-twitter" aria-hidden="true"></i>Twitter</a>';
		$content .= '<a class="btn btn-googleplus" href="'.$googleURL.'" target="_blank" data-network="google"><i class="fa fa-google-plus" aria-hidden="true"></i>Google+</a>';
		$content .= '<a class="btn btn-linkedin" href="'.$linkedInURL.'" target="_blank">LinkedIn</a>';
    // $content .= '<a class="crunchify-link crunchify-whatsapp" href="'.$whatsappURL.'" target="_blank">WhatsApp</a>';
    // $content .= '<a class="crunchify-link crunchify-buffer" href="'.$bufferURL.'" target="_blank">Buffer</a>';
    // $content .= '<a class="crunchify-link crunchify-pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank">Pin It</a>';
		$content .= '</div>';

		return $content;
	}else{
    // if not a post/page then don't include sharing button
		return $content;
	}
};
// add_filter( 'the_content', 'crunchify_social_sharing_buttons');