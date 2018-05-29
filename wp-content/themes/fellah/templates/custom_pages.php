<?php
/* Template Name: Page */
get_header();
?>
 

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
 
				get_template_part( 'template-parts/content', 'custom' ); 

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<br>
<br>

<?php
get_sidebar();
get_footer();
