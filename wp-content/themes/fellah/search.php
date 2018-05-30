<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package fellah
 */

get_header();
?>

<section id="primary" class="content-area">
	<main id="main" class="site-main container">

		<div class="container">
			<div class="row">
			
				<div class="col-md-12"> 
						<?php the_breadcrumb(); ?> 
				</div>
				<div class="offset-1 offset-md-0 col-10 col-md-8">
					<div class="page_blog">

						<?php if ( have_posts() ) : ?>
 
								<h1 class="page_titre">
									<?php printf( esc_html__( 'Search Results for: %s', 'fellah' ), '<span>' . get_search_query() . '</span>' );?>
								</h1> 

							<?php
							/* Start the Loop */
							while ( have_posts() ) :
								the_post(); 
								get_template_part( 'template-parts/actus' );

							endwhile;  
							wp_pagenavi( );
						else : 
							get_template_part( 'template-parts/content', 'none' ); 
						endif;
						?>
					</div>
				</div>

				<div class="col-md-4">
					<?php get_template_part( 'template-parts/single','side' ) ?>
				</div>

			</div>
		</div>
            
	</main><!-- #main -->
</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
