<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fellah
 */

?>
<div class="page_blog">
	<div class="container">
		<div class="row">
			<div class="col-md-8">

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<?php if ( 'post' === get_post_type() ) : ?>
						<?php fellah_post_thumbnail(); ?>
					<?php endif; ?>

					<header class="post-header">
						<?php the_title( '<h1 class="blog_titre">', '</h1>' );  
							if ( 'post' === get_post_type() ) : ?>
							<div class="entry-meta">
                        <div class="date">
                              <i class="far fa-calendar-plus"></i>
                              <?php echo get_the_date('j.m.Y'); ?>
                        </div>
								<div class="cats">
										<i class="fa fa-folder"></i>
										<?php echo get_the_term_list( $post->ID, 'category', '', ', ' ); ?>
								</div>
							</div><!-- .entry-meta -->
						<?php endif; ?>
					</header><!-- .entry-header -->


					<div class="entry-content">
						<?php
						the_content( sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'fellah' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							get_the_title()
						) );

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fellah' ),
							'after'  => '</div>',
						) );
						?>
					</div><!-- .entry-content -->
	
				</article><!-- #post-<?php the_ID(); ?> -->

				<div class="posts-navigation">
					<?php the_post_navigation(); ?> 
				</div>

			</div>

			<div class="col-md-4">
				<?php get_template_part( 'template-parts/single','side' ) ?>
			</div>

		</div>
	</div>
</div>