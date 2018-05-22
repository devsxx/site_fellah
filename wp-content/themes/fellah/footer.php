<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fellah
 */

?>

	</div><!-- #content -->

<?php get_template_part( 'template-parts/call_to_action' ); ?>

	<footer id="colophon" class="site-footer">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
					<div class="site-info">
						<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'fellah' ) ); ?>">
							<?php printf( esc_html__( 'All rights reserved %d', 'fellah' ), date('Y') ); ?>
						</a>
						<span class="sprt"> - </span>
						<a href="<?php echo esc_url( __( 'https://fellah.ma/', 'fellah' ) ); ?>">Fellah.ma</a>
						<span class="sprt"> | </span>
						<?php $ID = 33;  ?>
						<a href="<?php the_permalink( $ID  ); ?>"><?php echo get_the_title( $ID ); ?></a>
					</div>
				</div>
			</div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php  
wp_footer(); ?>

</body>
</html>
