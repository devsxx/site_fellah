<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package fellah
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main"> 
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', get_post_type() ); ?> 
		<?php endwhile; ?> 
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_template_part( 'template-parts/call_to_action.php' );
get_sidebar();
get_footer();
