<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fellah
 */

get_header();
?> 

	<div id="primary" class="content-area">
		<main id="main" class="site-main container">
			<div class="container">
				<div class="row">
				
				<div class="col-md-12">
					<!-- start breadcrumbs -->
					<?php the_breadcrumb(); ?>
					<!-- end breadcrumbs -->
				</div>
					<div class="col-md-8">
						<div class="page_blog">
							<?php 
							if ( have_posts() ) :   the_archive_title( '<h1 class="page_titre">', '</h1>' ); 
								while ( have_posts() ) :
									the_post(); 
									get_template_part('template-parts/actus');
								endwhile;
								the_posts_navigation();
							else :
								get_template_part( 'template-parts/content', 'none' );
							endif; ?>
						</div>
					</div>
					<div class="col-md-4">
						<?php get_template_part( 'template-parts/single','side' ) ?>
					</div>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
